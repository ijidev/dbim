@extends('layouts.app')

@section('title', 'My Profile - DBIM LMS')

@push('styles')
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .fill-1 {
        font-variation-settings: 'FILL' 1;
    }
    
    .profile-tab-btn {
        transition: all 0.2s;
    }
    .profile-tab-btn.active {
        color: var(--primary, #1754cf);
        border-bottom: 3px solid var(--primary, #1754cf);
    }
    .profile-tab-btn:not(.active) {
        color: #64748b;
        border-bottom: 3px solid transparent;
    }
    .profile-tab-btn:not(.active):hover {
        color: #1e293b;
    }

    .profile-tab-content {
        display: none;
        animation: fadeIn 0.3s ease;
    }
    .profile-tab-content.active {
        display: block;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .stat-card {
        background: white;
        padding: 24px;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    #settings-container .settings-nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-radius: 12px;
        color: #64748b;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
        cursor: pointer;
    }
    #settings-container .settings-nav-item:hover,
    #settings-container .settings-nav-item.active {
        background: white;
        color: var(--primary);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .settings-loading {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 4rem 0;
        color: #94a3b8;
    }
    .settings-loading .spinner {
        width: 40px;
        height: 40px;
        border: 3px solid #e2e8f0;
        border-top-color: var(--primary, #1754cf);
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>
@endpush

@section('content')
<div class="flex h-[calc(100vh-72px)] overflow-hidden bg-slate-50">
    <!-- Sidebar -->
    @include('partials.student_sidebar')

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-y-auto bg-slate-50 relative w-full">
        <!-- Top Cover -->
        <div class="h-48 w-full bg-blue-100/50"></div>
        
        <div class="max-w-6xl mx-auto w-full px-6 lg:px-12 -mt-16 z-10">
            <!-- Profile Info Row -->
            <div class="flex flex-col md:flex-row md:items-end gap-6 pb-2">
                <!-- Avatar -->
                <div class="shrink-0 relative group">
                    <div class="w-32 h-32 rounded-3xl bg-[#E8C592] border-4 border-white shadow-sm overflow-hidden flex items-center justify-center">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/'.Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-4xl font-black text-amber-900">{{ substr(Auth::user()->name, 0, 2) }}</span>
                        @endif
                    </div>
                </div>
                
                <!-- Info -->
                <div class="flex-1 pb-1">
                    <div class="flex items-center gap-3 mb-1">
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight">{{ Auth::user()->name }}</h1>
                        <span class="bg-emerald-100 text-emerald-700 text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full">Faith Member</span>
                    </div>
                    <div class="flex items-center gap-1.5 text-slate-500 text-sm font-medium">
                        <span class="material-symbols-outlined text-[18px]">mail</span>
                        <span>{{ Auth::user()->email }}</span>
                    </div>
                </div>
                
                <!-- Action -->
                <div class="pb-2 mt-4 md:mt-0">
                    <button onclick="switchProfileTab('settings', document.querySelector('[data-tab=settings]'))" class="inline-flex items-center justify-center bg-primary text-white px-6 py-2.5 rounded-xl font-bold hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20 text-sm">
                        Edit Profile
                    </button>
                </div>
            </div>
            
            <!-- Tabs -->
            <div class="flex items-center gap-8 border-b border-slate-200 mt-6 lg:mt-8 overflow-x-auto whitespace-nowrap scrollbar-hide">
                <button data-tab="journey" onclick="switchProfileTab('journey', this)" class="profile-tab-btn active pb-3 flex items-center gap-2 text-sm font-bold">
                    <span class="material-symbols-outlined text-[18px]">explore</span> Spiritual Journey
                </button>
                <button data-tab="notes" onclick="switchProfileTab('notes', this)" class="profile-tab-btn pb-3 flex items-center gap-2 text-sm font-bold">
                    <span class="material-symbols-outlined text-[18px]">history_edu</span> My Notes
                </button>
                <button data-tab="settings" onclick="switchProfileTab('settings', this)" class="profile-tab-btn pb-3 flex items-center gap-2 text-sm font-bold">
                    <span class="material-symbols-outlined text-[18px]">settings</span> Settings
                </button>
            </div>

        <!-- ================================ -->
        <!-- TAB: Spiritual Journey (default) -->
        <!-- ================================ -->
        <div id="tab-journey" class="profile-tab-content active">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 py-8">
                
                <!-- LEFT COLUMN -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- My Story -->
                    <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm relative">
                        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2 mb-4">
                            <span class="material-symbols-outlined text-primary text-xl">person</span>
                            My Story
                        </h2>
                        
                        @if(Auth::user()->bio)
                            <p class="text-slate-600 italic text-lg leading-relaxed">"{{ Auth::user()->bio }}"</p>
                        @else
                            <div class="text-center py-6">
                                <p class="text-slate-400 italic mb-3">You haven't added your story yet.</p>
                                <button onclick="switchProfileTab('settings', document.querySelector('[data-tab=settings]'))" class="text-primary font-bold text-sm hover:underline">Add your bio →</button>
                            </div>
                        @endif
                    </div>

                    <!-- Spiritual Milestones -->
                    <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-xl active-icon">star</span>
                                Spiritual Milestones
                            </h2>
                            <span class="text-xs font-bold text-slate-400">{{ $enrollments->where('progress', 100)->count() }}/{{ $enrollments->count() }} Completed</span>
                        </div>
                        
                        <div class="space-y-8 relative before:absolute before:inset-0 before:ml-[1.1rem] before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                            
                            <!-- Timeline: Joined -->
                            <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                                <div class="flex items-center justify-center w-9 h-9 rounded-full bg-blue-50 text-primary shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10 
                                    shadow-[0_0_0_8px_white]">
                                    <span class="material-symbols-outlined text-base">check</span>
                                </div>
                                <div class="w-[calc(100%-3rem)] md:w-[calc(50%-2rem)] bg-white p-4 rounded-xl border border-slate-100 shadow-sm">
                                    <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1 block">{{ Auth::user()->created_at->format('M Y') }}</span>
                                    <h3 class="font-bold text-slate-900 text-sm">Joined the Community</h3>
                                    <p class="text-xs text-slate-500 mt-1">Started the learning journey and joined the community.</p>
                                </div>
                            </div>

                            <!-- Timeline: Enrollments -->
                            @foreach($enrollments as $enrollment)
                            <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                                <div class="flex items-center justify-center w-9 h-9 rounded-full shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10 shadow-[0_0_0_8px_white]
                                    {{ $enrollment->progress == 100 ? 'bg-blue-50 text-primary' : 'bg-slate-100 text-slate-400' }}">
                                    <span class="material-symbols-outlined text-sm">{{ $enrollment->progress == 100 ? 'school' : 'more_horiz' }}</span>
                                </div>
                                <div class="w-[calc(100%-3rem)] md:w-[calc(50%-2rem)] bg-white p-4 rounded-xl border border-slate-100 shadow-sm relative">
                                    @if($enrollment->progress < 100)
                                        <div class="absolute bottom-0 left-0 h-1 bg-slate-100 w-full rounded-b-xl overflow-hidden">
                                            <div class="h-full bg-primary" style="width: {{ $enrollment->progress }}%"></div>
                                        </div>
                                    @endif
                                    <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1 block">{{ $enrollment->progress == 100 ? 'Completed' : 'In Progress' }}</span>
                                    <h3 class="font-bold text-slate-900 text-sm">{{ $enrollment->course->title }}</h3>
                                    <p class="text-xs text-slate-500 mt-1 line-clamp-1">{{ $enrollment->course->short_description ?? 'Developing leadership skills for the next generation of believers.' }}</p>
                                    @if($enrollment->progress == 100)
                                        <a href="#" class="text-[11px] font-bold text-primary mt-2 flex items-center gap-1 hover:underline">View Certificate <span class="material-symbols-outlined text-[12px]">open_in_new</span></a>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
                
                <!-- RIGHT COLUMN -->
                <div class="space-y-6">
                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col items-center justify-center text-center">
                            <span class="text-lg font-black text-primary mb-1">{{ Auth::user()->created_at->format('M Y') }}</span>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Member Since</span>
                        </div>
                        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col items-center justify-center text-center">
                            <span class="text-3xl font-black text-slate-900 mb-1">{{ $annotationCount }}</span>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Reflections</span>
                        </div>
                    </div>

                    <!-- My Notes (Sidebar Preview) -->
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden p-6 relative">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-lg active-icon">import_contacts</span>
                                My Notes
                            </h3>
                            <button onclick="switchProfileTab('notes', document.querySelector('[data-tab=notes]'))" class="text-[11px] font-bold text-primary hover:underline uppercase tracking-wider">View All</button>
                        </div>
                        
                        <div class="space-y-4 mb-6">
                            @forelse($annotations->take(2) as $ann)
                            <a href="{{ route('student.library.read', $ann->book->slug ?? $ann->book->id) }}#ann-{{ $ann->annotation_id }}" class="block bg-slate-50 p-4 rounded-xl border border-slate-100 hover:border-blue-100 transition-colors cursor-pointer group">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[9px] font-black text-primary uppercase tracking-widest">{{ Str::limit($ann->book->title ?? 'Unknown Book', 25) }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $ann->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm font-bold text-slate-700 leading-snug mb-3">"{{ Str::limit($ann->text, 80) }}"</p>
                                @if($ann->note)
                                <p class="text-xs text-slate-500 mb-2 line-clamp-1">{{ $ann->note }}</p>
                                @endif
                                <div class="flex gap-2">
                                    <span class="bg-white text-slate-500 text-[9px] font-bold px-2 py-0.5 rounded border border-slate-200">{{ ucfirst($ann->type) }}</span>
                                </div>
                            </a>
                            @empty
                            <div class="text-center py-6">
                                <span class="material-symbols-outlined text-3xl text-slate-300 mb-2 block">edit_note</span>
                                <p class="text-xs text-slate-400 font-medium">No notes yet. Highlight text in the book reader to create notes.</p>
                            </div>
                            @endforelse
                        </div>

                        <a href="{{ route('student.library.index') }}" class="w-full py-4 rounded-xl border-2 border-dashed border-slate-200 text-slate-500 font-bold text-sm flex items-center justify-center gap-2 hover:border-primary hover:text-primary transition-colors bg-slate-50/50 hover:bg-blue-50/50">
                            <span class="material-symbols-outlined text-lg">auto_stories</span>
                            Go to Library
                        </a>
                    </div>

                    <!-- Notifications Promo -->
                    <div class="bg-gradient-to-br from-[#4f46e5] to-[#7c3aed] p-6 rounded-2xl text-white shadow-lg relative overflow-hidden">
                        <span class="material-symbols-outlined absolute -right-6 -bottom-6 text-9xl text-white opacity-5 rotate-12">notifications_active</span>
                        <h3 class="text-lg font-bold mb-1">Notifications</h3>
                        <p class="text-white/80 text-xs mb-6 font-medium leading-relaxed">Get weekly journey summaries & course reminders.</p>
                        <button onclick="switchProfileTab('settings', document.querySelector('[data-tab=settings]'))" class="w-max bg-white text-[#4f46e5] font-bold text-xs py-2 px-5 rounded-full hover:bg-slate-50 transition-colors shadow-sm">
                            Update Preferences
                        </button>
                    </div>
                </div>
                
            </div>
        </div>

        <!-- =================== -->
        <!-- TAB: My Notes (Full) -->
        <!-- =================== -->
        <div id="tab-notes" class="profile-tab-content">
            <div class="py-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-xl">history_edu</span>
                        All My Notes & Highlights
                    </h2>
                    <span class="text-sm font-bold text-slate-400">{{ $annotationCount }} total</span>
                </div>

                @if($annotations->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($annotations as $ann)
                    <a href="{{ route('student.library.read', $ann->book->slug ?? $ann->book->id) }}#ann-{{ $ann->annotation_id }}" class="block bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-100 transition-all group">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[9px] font-black text-primary uppercase tracking-widest">{{ $ann->book->title ?? 'Unknown Book' }}</span>
                            <span class="text-[10px] text-slate-400">{{ $ann->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm font-bold text-slate-700 leading-snug mb-2">"{{ Str::limit($ann->text, 120) }}"</p>
                        @if($ann->note)
                        <p class="text-xs text-slate-500 mb-3 italic">📝 {{ Str::limit($ann->note, 100) }}</p>
                        @endif
                        <div class="flex items-center justify-between">
                            <div class="flex gap-2">
                                <span class="bg-slate-50 text-slate-500 text-[9px] font-bold px-2 py-0.5 rounded border border-slate-200">{{ ucfirst($ann->type) }}</span>
                                @if($ann->color)
                                <span class="w-4 h-4 rounded-full {{ str_replace('hl-', 'bg-', $ann->color) === 'bg-gold' ? 'bg-yellow-400' : ($ann->color === 'hl-blue' ? 'bg-blue-400' : ($ann->color === 'hl-green' ? 'bg-green-400' : ($ann->color === 'hl-pink' ? 'bg-pink-400' : ($ann->color === 'hl-purple' ? 'bg-purple-400' : 'bg-orange-400')))) }} border border-white shadow-sm"></span>
                                @endif
                            </div>
                            <span class="text-[10px] font-bold text-primary opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1">
                                View in Reader <span class="material-symbols-outlined text-xs">open_in_new</span>
                            </span>
                        </div>
                    </a>
                    @endforeach
                </div>
                @else
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-16 text-center">
                    <span class="material-symbols-outlined text-5xl text-slate-200 mb-4 block">edit_note</span>
                    <h3 class="text-lg font-bold text-slate-700 mb-2">No Notes Yet</h3>
                    <p class="text-slate-400 text-sm max-w-md mx-auto mb-6">Start reading books in the library and highlight text to create personal notes and reflections.</p>
                    <a href="{{ route('student.library.index') }}" class="inline-flex items-center gap-2 bg-primary text-white font-bold text-sm px-6 py-3 rounded-xl hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">
                        <span class="material-symbols-outlined text-lg">auto_stories</span>
                        Browse Library
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- ================= -->
        <!-- TAB: Settings     -->
        <!-- ================= -->
        <div id="tab-settings" class="profile-tab-content">
            <div class="py-8" id="settings-container">
                <div class="settings-loading" id="settings-loading">
                    <div class="spinner mb-4"></div>
                    <p class="text-sm font-bold">Loading settings...</p>
                </div>
                <div id="settings-content" class="hidden"></div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    let settingsLoaded = false;

    function switchProfileTab(tabId, btn) {
        // Hide all tab contents
        document.querySelectorAll('.profile-tab-content').forEach(t => t.classList.remove('active'));
        // Deactivate all tab buttons
        document.querySelectorAll('.profile-tab-btn').forEach(b => b.classList.remove('active'));

        // Activate selected
        const tabEl = document.getElementById('tab-' + tabId);
        if (tabEl) tabEl.classList.add('active');
        if (btn) btn.classList.add('active');

        // Load settings via AJAX on first visit
        if (tabId === 'settings' && !settingsLoaded) {
            loadSettingsContent();
        }
    }

    async function loadSettingsContent() {
        const container = document.getElementById('settings-content');
        const loading = document.getElementById('settings-loading');

        try {
            const res = await fetch("{{ route('student.settings.content') }}", {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            });
            if (!res.ok) throw new Error('Failed to load settings');
            const html = await res.text();
            container.innerHTML = html;
            container.classList.remove('hidden');
            loading.classList.add('hidden');
            settingsLoaded = true;

            // Re-execute any inline scripts from the loaded HTML
            container.querySelectorAll('script').forEach(oldScript => {
                const newScript = document.createElement('script');
                newScript.textContent = oldScript.textContent;
                document.body.appendChild(newScript);
                oldScript.remove();
            });
        } catch (e) {
            loading.innerHTML = `
                <span class="material-symbols-outlined text-3xl text-red-300 mb-2">error</span>
                <p class="text-sm font-bold text-slate-500">Failed to load settings.</p>
                <button onclick="loadSettingsContent()" class="text-primary font-bold text-xs mt-2 hover:underline">Retry</button>
            `;
        }
    }
</script>
@endpush
