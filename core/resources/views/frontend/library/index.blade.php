@extends('layouts.app')

@section('title', 'Digital Library')

@push('styles')
<style>
    /* Library page custom styles */
    .waveform-bar {
        width: 3px;
        background-color: #3b4354;
        border-radius: 1px;
        transition: background-color 0.2s;
    }
    .waveform-bar.active { background-color: #0f49bd; }

    /* Tab switching */
    .tab-content { display: none; }
    .tab-content.active { display: block; }
    .tab-btn.active { color: #0f49bd; }
    .tab-btn.active .tab-underline { display: block; }
    .tab-underline { display: none; }
</style>
@endpush


@section('content')
<div class="relative flex h-auto min-h-screen w-full flex-col bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 antialiased overflow-x-hidden">

<main class="flex-1 flex flex-col">
    {{-- Featured Hero Section --}}
    <section class="w-full px-6 py-6 md:px-12 md:py-8">
        <div class="relative overflow-hidden rounded-2xl aspect-[21/9] min-h-[360px] flex items-end">
            {{-- Background --}}
            <div class="absolute inset-0 bg-cover bg-center" style='background-image: url("https://images.unsplash.com/photo-1507692049790-de58290a4334?auto=format&fit=crop&w=2070&q=80");'></div>
            {{-- Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-t from-background-dark via-background-dark/40 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-background-dark/80 via-background-dark/20 to-transparent"></div>
            {{-- Content --}}
            <div class="relative z-10 p-8 md:p-12 w-full max-w-3xl">
                <div class="flex items-center gap-2 mb-4">
                    <span class="bg-accent-gold text-background-dark text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded">Featured Resource</span>
                    <span class="text-white/60 text-xs font-medium uppercase tracking-wider">• {{ $wisdomAuthor }}</span>
                </div>
                <h1 class="text-white text-4xl md:text-5xl font-black leading-tight tracking-tight mb-4">
                    {{ Str::limit($wisdomText, 80) }}
                </h1>
                @if($recentRead)
                <p class="text-white/80 text-base md:text-lg mb-8 max-w-xl">
                    Continue reading: <strong class="text-accent-gold">"{{ $recentRead->book->title }}"</strong> — {{ round($recentRead->percentage_complete) }}% complete
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('student.library.read', $recentRead->book->slug) }}" class="flex items-center gap-2 bg-primary hover:bg-primary/90 text-white px-6 py-3 rounded-xl font-bold transition-all transform hover:scale-105">
                        <span class="material-symbols-outlined">play_arrow</span>
                        Continue Reading
                    </a>
                    <a href="{{ route('library.index') }}" class="flex items-center gap-2 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white px-6 py-3 rounded-xl font-bold border border-white/20 transition-all">
                        <span class="material-symbols-outlined">auto_stories</span>
                        Browse Library
                    </a>
                </div>
                @else
                <p class="text-white/80 text-base md:text-lg mb-8 max-w-xl">
                    Explore our vast collection of spiritual wisdom through videos, audio, and literature.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#books" class="flex items-center gap-2 bg-primary hover:bg-primary/90 text-white px-6 py-3 rounded-xl font-bold transition-all transform hover:scale-105">
                        <span class="material-symbols-outlined">auto_stories</span>
                        Browse Books
                    </a>
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Library Content Area --}}
    <div class="flex flex-1 gap-8 px-6 pb-12 md:px-12">

        {{-- Sidebar Filters --}}
        <aside class="hidden lg:flex flex-col w-64 shrink-0 gap-8">
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-4 px-2">Library Filters</h3>
                <div class="space-y-1">
                    <a href="{{ route('library.index') }}" class="w-full flex items-center justify-between p-3 rounded-xl {{ !request('category') || request('category') == 'all' ? 'bg-primary/10 text-primary' : 'hover:bg-slate-100 dark:hover:bg-surface-dark' }} group transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined {{ !request('category') || request('category') == 'all' ? 'text-primary' : 'text-slate-400 group-hover:text-primary' }}">folder</span>
                            <span class="text-sm {{ !request('category') || request('category') == 'all' ? 'font-bold' : 'font-medium' }}">All Books</span>
                        </div>
                        <span class="material-symbols-outlined text-sm text-slate-400">expand_more</span>
                    </a>
                    @foreach(['Theology','Devotional','History','Biography','Liturgy','Prayer'] as $cat)
                    <a href="{{ route('library.index', ['category' => $cat]) }}" class="w-full flex items-center justify-between p-3 rounded-xl {{ request('category') == $cat ? 'bg-primary/10 text-primary' : 'hover:bg-slate-100 dark:hover:bg-surface-dark' }} group transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined {{ request('category') == $cat ? 'text-primary' : 'text-slate-400 group-hover:text-primary' }}">label</span>
                            <span class="text-sm {{ request('category') == $cat ? 'font-bold' : 'font-medium' }}">{{ $cat }}</span>
                        </div>
                        <span class="material-symbols-outlined text-sm text-slate-400">chevron_right</span>
                    </a>
                    @endforeach
                </div>
            </div>
            <div>
                <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-4 px-2">Popular Tags</h3>
                <div class="flex flex-wrap gap-2 px-2">
                    @foreach(['PRAYER','FAITH','RESTORATION','GENESIS','DEVOTION'] as $tag)
                    <span class="px-3 py-1 bg-slate-100 dark:bg-surface-dark rounded-full text-[11px] font-bold text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-border-dark cursor-pointer hover:border-primary/50 transition-colors">{{ $tag }}</span>
                    @endforeach
                </div>
            </div>
            <div class="mt-auto">
                <a href="{{ route('library.index') }}" class="w-full block text-center py-3 bg-slate-100 dark:bg-surface-dark text-slate-500 dark:text-slate-400 text-sm font-bold rounded-xl border border-dashed border-slate-300 dark:border-border-dark hover:border-primary/50 transition-colors">
                    Reset All Filters
                </a>
            </div>
        </aside>

        {{-- Content Grid --}}
        <div class="flex-1 flex flex-col gap-6" id="books">

            {{-- Tab Controls --}}
            <div class="flex items-center justify-between border-b border-slate-200 dark:border-border-dark">
                <div class="flex gap-8">
                    <button onclick="switchTab('books')" id="tab-books" class="tab-btn active relative py-4 text-sm font-bold text-primary">
                        Book Collection
                        <div class="tab-underline absolute bottom-0 left-0 right-0 h-0.5 bg-primary"></div>
                    </button>
                    <button onclick="switchTab('audio')" id="tab-audio" class="tab-btn relative py-4 text-sm font-bold text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                        Podcasts &amp; Audio
                    </button>
                </div>
                <div class="flex items-center gap-2 text-slate-400">
                    <span class="text-xs font-medium">Sort by:</span>
                    <a href="{{ route('library.index', array_merge(request()->query(), ['sort' => 'latest'])) }}" class="text-xs font-bold flex items-center gap-1 dark:text-white">
                        Newest First
                        <span class="material-symbols-outlined text-sm">expand_more</span>
                    </a>
                </div>
            </div>

            {{-- Books Tab Content --}}
            <div id="tab-content-books" class="tab-content active">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($books as $book)
                    <div class="group relative bg-white dark:bg-surface-dark p-3 rounded-2xl border border-slate-200 dark:border-border-dark hover:shadow-xl transition-all duration-300">
                        <div class="relative aspect-[3/4] rounded-xl overflow-hidden mb-4">
                            @if($book->cover_url)
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 src="{{ $book->cover_url }}"
                                 alt="{{ $book->title }}"
                                 onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-slate-100 dark:bg-surface-dark flex items-center justify-center\'><span class=\'material-symbols-outlined text-5xl text-slate-300 dark:text-slate-600\'>auto_stories</span></div>'">
                            @else
                                <div class="w-full h-full bg-slate-100 dark:bg-surface-dark flex items-center justify-center p-4">
                                    <span class="material-symbols-outlined text-5xl text-slate-300 dark:text-slate-600">auto_stories</span>
                                </div>
                            @endif

                            {{-- Hover overlay with actions --}}
                            <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col items-center justify-center p-4 gap-3">
                                @auth
                                    @php 
                                        $isOwned = $book->isOwnedBy(auth()->user()); 
                                        $progress = $book->getProgressPercentage(auth()->user());
                                    @endphp
                                    
                                    @if($isOwned)
                                        <a href="{{ route('student.library.read', $book->slug) }}" class="w-full py-2.5 bg-primary text-white text-xs font-bold rounded-lg text-center hover:scale-105 transition-transform flex items-center justify-center gap-2">
                                            <span class="material-symbols-outlined text-sm">menu_book</span>
                                            Continue Reading
                                        </a>
                                    @else
                                        <a href="{{ route('student.library.read', $book->slug) }}" class="w-full py-2.5 bg-white text-primary text-xs font-bold rounded-lg text-center hover:bg-primary hover:text-white transition-colors">
                                            Read Intro
                                        </a>
                                        <button onclick="addToCollection(event, {{ $book->id }})" class="add-btn-{{ $book->id }} w-full py-2.5 bg-primary text-white text-xs font-bold rounded-lg hover:scale-105 transition-transform flex items-center justify-center gap-2">
                                            <span class="material-symbols-outlined text-sm">bookmark_add</span>
                                            {{ $book->is_free ? 'Get Book' : 'Purchase Book' }}
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('student.library.read', $book->slug) }}" class="w-full py-2.5 bg-white text-primary text-xs font-bold rounded-lg text-center hover:bg-primary hover:text-white transition-colors">
                                        Read Intro
                                    </a>
                                    <a href="{{ route('login') }}" class="w-full py-2.5 bg-primary text-white text-xs font-bold rounded-lg text-center">
                                        Login to Read
                                    </a>
                                @endauth
                            </div>

                            {{-- Edge Badge --}}
                            <div class="absolute top-3 right-3 flex flex-col gap-2 items-end">
                                @auth
                                    @if($book->isOwnedBy(auth()->user()))
                                        <span class="px-2 py-1 bg-emerald-500 text-white text-[10px] font-black rounded uppercase shadow-lg shadow-emerald-500/40 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[10px]">check_circle</span>
                                            Owned
                                        </span>
                                    @endif
                                @endauth

                                @if($book->is_free)
                                    <span class="px-2 py-1 bg-blue-500 text-white text-[10px] font-black rounded uppercase shadow-lg shadow-blue-500/40">Free</span>
                                @else
                                    <span class="px-2 py-1 bg-black/80 text-white text-[10px] font-black rounded uppercase">${{ number_format($book->price, 2) }}</span>
                                @endif
                            </div>

                            {{-- Progress Bar for Owned Books --}}
                            @auth
                                @if($book->isOwnedBy(auth()->user()))
                                @php $pct = $book->getProgressPercentage(auth()->user()); @endphp
                                <div class="absolute bottom-0 left-0 right-0 h-1.5 bg-black/20 backdrop-blur-sm">
                                    <div class="h-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.5)] transition-all duration-500" style="width: {{ $pct }}%"></div>
                                </div>
                                @endif
                            @endauth
                        </div>

                        <div class="px-1">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="font-black text-sm group-hover:text-primary transition-colors leading-tight truncate flex-1">{{ $book->title }}</h4>
                                @auth
                                    @if($book->isOwnedBy(auth()->user()))
                                        <span class="text-[10px] font-black text-emerald-500">{{ $book->getProgressPercentage(auth()->user()) }}%</span>
                                    @endif
                                @endauth
                            </div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $book->category }} • {{ $book->author }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-3 text-center py-20 text-slate-400">
                        <span class="material-symbols-outlined text-5xl mb-3 block">auto_stories</span>
                        <p class="font-bold">No books found.</p>
                        @if(request('category'))
                            <a href="{{ route('library.index') }}" class="text-primary text-sm underline mt-2 inline-block">Clear filters</a>
                        @endif
                    </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if($books->hasPages())
                <div class="flex justify-center mt-12 gap-2">
                    {{-- Use Laravel pagination --}}
                    {{ $books->appends(request()->query())->links('pagination::simple-tailwind') }}
                </div>
                @endif
            </div>

            {{-- Audio Tab Content --}}
            <div id="tab-content-audio" class="tab-content">
                <div class="mt-4">
                    <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">podcasts</span>
                        Latest Audio Episodes
                    </h3>
                    <div class="space-y-4">
                        {{-- Audio Item Placeholder --}}
                        <div class="bg-slate-100 dark:bg-surface-dark p-4 rounded-2xl border border-slate-200 dark:border-border-dark flex items-center gap-6">
                            <button class="size-12 rounded-full bg-primary text-white flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined">play_arrow</span>
                            </button>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start mb-1">
                                    <h5 class="font-bold text-sm truncate">EP. 01 - The Silence of Prayer</h5>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter shrink-0">Coming Soon</span>
                                </div>
                                <div class="flex items-end gap-[2px] h-8 w-full mt-2">
                                    @foreach([40,60,30,70,80,50,90,60,40,20,50,80,30,60,40,20,90,50,70,30,60,40,80,50,70,30,60,40] as $h)
                                    <div class="waveform-bar h-[{{ $h }}%]"></div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button class="size-10 rounded-full hover:bg-slate-200 dark:hover:bg-slate-800 text-slate-400 flex items-center justify-center transition-colors">
                                    <span class="material-symbols-outlined">download</span>
                                </button>
                                <button class="size-10 rounded-full hover:bg-slate-200 dark:hover:bg-slate-800 text-slate-400 flex items-center justify-center transition-colors">
                                    <span class="material-symbols-outlined">share</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- end content grid --}}
    </div>{{-- end content area --}}
</main>

{{-- Sticky Bottom Mini Player --}}
<div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-[calc(100%-48px)] max-w-4xl bg-white/90 dark:bg-surface-dark/95 backdrop-blur-xl border border-slate-200 dark:border-white/10 shadow-2xl rounded-2xl p-4 z-50 flex items-center gap-6">
    <div class="flex items-center gap-4 min-w-[200px]">
        <div class="size-10 rounded-lg bg-primary/20 shrink-0 flex items-center justify-center text-primary">
            <span class="material-symbols-outlined">auto_stories</span>
        </div>
        <div class="min-w-0">
            <h6 class="text-xs font-bold truncate">Digital Library</h6>
            <p class="text-[10px] text-slate-400 font-medium">Voice Reader Available</p>
        </div>
    </div>
    <div class="flex-1 flex flex-col gap-2">
        <div class="flex items-center justify-center gap-6">
            <button class="text-slate-400 hover:text-primary transition-colors">
                <span class="material-symbols-outlined">skip_previous</span>
            </button>
            <button class="size-10 rounded-full bg-primary text-white flex items-center justify-center shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined">play_arrow</span>
            </button>
            <button class="text-slate-400 hover:text-primary transition-colors">
                <span class="material-symbols-outlined">skip_next</span>
            </button>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-[10px] font-bold text-primary">00:00</span>
            <div class="flex-1 h-1.5 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                <div class="h-full bg-primary w-0"></div>
            </div>
            <span class="text-[10px] font-bold text-slate-400">0:00</span>
        </div>
    </div>
    <div class="hidden sm:flex items-center gap-4 shrink-0">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-slate-400 text-lg">volume_up</span>
            <div class="w-20 h-1 bg-slate-200 dark:bg-slate-700 rounded-full">
                <div class="h-full bg-slate-400 w-[60%] rounded-full"></div>
            </div>
        </div>
        <button class="text-slate-400 hover:text-primary transition-colors">
            <span class="material-symbols-outlined">playlist_play</span>
        </button>
    </div>
</div>

</div>{{-- end outer wrapper --}}

<script>
function switchTab(tab) {
    // Reset all tabs
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active', 'text-primary');
        btn.classList.add('text-slate-400');
        btn.querySelector('.tab-underline')?.classList.add('hidden');
    });
    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

    // Activate selected
    const activeBtn = document.getElementById('tab-' + tab);
    const activeContent = document.getElementById('tab-content-' + tab);
    if (activeBtn) {
        activeBtn.classList.add('active', 'text-primary');
        activeBtn.classList.remove('text-slate-400');
        activeBtn.querySelector('.tab-underline')?.classList.remove('hidden');
    }
    if (activeContent) activeContent.classList.add('active');
}

async function addToCollection(e, bookId) {
    e.preventDefault();
    const btn = document.querySelector('.add-btn-' + bookId);
    const originalContent = btn.innerHTML;
    
    try {
        btn.disabled = true;
        btn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">progress_activity</span> Adding...';
        
        const res = await fetch(`/dbim/my-library/add/${bookId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });
        
        const data = await res.json();
        
        if (res.ok) {
            if (data.redirect) {
                window.location.href = data.url;
                return;
            }
            btn.parentElement.innerHTML = '<div class="w-full py-2.5 bg-emerald-500/20 text-emerald-400 text-xs font-bold rounded-lg text-center border border-emerald-500/30">In Collection</div>';
            if (window.Swal) {
                Swal.fire({
                    icon: 'success',
                    title: 'Added!',
                    text: data.success || 'Book added to your collection.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        } else {
            throw new Error(data.error || 'Failed to add book.');
        }
    } catch (err) {
        btn.disabled = false;
        btn.innerHTML = originalContent;
        if (window.Swal) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: err.message
            });
        } else {
            alert(err.message);
        }
    }
}
</script>
@endsection
