@extends('layouts.app')

@section('title', 'Student Dashboard')

@push('styles')
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .fill-1 { font-variation-settings: 'FILL' 1; }
    
    .sidebar-link.active {
        background-color: rgba(23, 84, 207, 0.1);
        color: var(--primary);
    }
</style>
@endpush

@section('content')
<div class="flex h-[calc(100vh-64px)] overflow-hidden bg-slate-50">
    <!-- Sidebar Navigation (Desktop) -->
    <aside class="hidden lg:flex w-72 flex-col border-r border-slate-200 bg-white h-full shrink-0">
        <nav class="flex-1 px-6 py-8 space-y-2">
            <a href="{{ route('student.dashboard') }}" class="sidebar-link active flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-black transition-all">
                <span class="material-symbols-outlined fill-1">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('student.catalog') }}" class="sidebar-link flex items-center gap-4 px-4 py-3 text-slate-500 hover:text-primary hover:bg-slate-50 rounded-xl text-sm font-bold transition-all">
                <span class="material-symbols-outlined">book_2</span>
                <span>Course Catalog</span>
            </a>
            <a href="{{ route('student.learning') }}" class="sidebar-link flex items-center gap-4 px-4 py-3 text-slate-500 hover:text-primary hover:bg-slate-50 rounded-xl text-sm font-bold transition-all">
                <span class="material-symbols-outlined">school</span>
                <span>My Learning</span>
            </a>
            <a href="{{ route('calendar') }}" class="sidebar-link flex items-center gap-4 px-4 py-3 text-slate-500 hover:text-primary hover:bg-slate-50 rounded-xl text-sm font-bold transition-all">
                <span class="material-symbols-outlined">groups</span>
                <span>Community</span>
            </a>
        </nav>
        <div class="p-6 border-t border-slate-100">
            <a href="{{ route('student.profile') }}" class="flex items-center gap-4 p-2 hover:bg-slate-50 rounded-xl transition-colors group">
                <div class="size-11 rounded-full bg-primary/10 flex items-center justify-center text-primary font-black text-xs border border-primary/20 group-hover:bg-primary group-hover:text-white transition-colors">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <div class="flex flex-col">
                    <p class="text-sm font-black text-slate-900 group-hover:text-primary transition-colors">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">View Profile</p>
                </div>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-y-auto px-6 lg:px-12 py-10 max-w-7xl mx-auto w-full">
        <!-- Welcome Heading -->
        <div class="flex flex-wrap justify-between items-end gap-6 mb-10">
            <div class="flex flex-col gap-1">
                <h2 class="text-4xl font-black tracking-tight text-slate-900">Welcome back, {{ explode(' ', Auth::user()->name)[0] }}</h2>
                <p class="text-slate-500 text-lg font-medium">You have <strong>{{ $enrollments->count() }}</strong> active courses in your growth track.</p>
            </div>
            <a href="{{ route('student.schedule') }}" class="flex items-center gap-3 px-6 h-12 bg-white border border-slate-100 rounded-xl text-sm font-black shadow-sm hover:bg-slate-50 transition-all">
                <span class="material-symbols-outlined text-primary">calendar_month</span>
                <span>View Schedule</span>
            </a>
        </div>

        <!-- Live Class Alert -->
        @if(($is_live->value ?? '0') == '1')
        <div class="relative group mb-10">
            <div class="absolute inset-0 bg-primary/5 rounded-3xl blur-xl group-hover:bg-primary/10 transition-all"></div>
            <div class="relative flex flex-col md:flex-row items-center justify-between gap-8 rounded-3xl border border-primary/20 bg-white p-8 border-l-8 border-l-primary shadow-xl shadow-primary/5">
                <div class="flex gap-6">
                    <div class="bg-primary size-16 rounded-2xl flex items-center justify-center text-white shrink-0 shadow-lg shadow-primary/20">
                        <span class="material-symbols-outlined text-3xl animate-pulse">videocam</span>
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center gap-2">
                            <span class="flex h-2 w-2 rounded-full bg-red-500 animate-ping"></span>
                            <p class="text-xs font-black text-red-500 uppercase tracking-widest">Live Now</p>
                        </div>
                        <p class="text-slate-900 text-2xl font-black leading-tight">Ongoing Service / Class</p>
                        <p class="text-slate-500 font-medium">Join the live stream and participate in the interactive session.</p>
                    </div>
                </div>
                <a href="{{ route('live') }}" class="w-full md:w-auto min-w-[180px] flex items-center justify-center gap-3 rounded-xl h-14 px-8 bg-primary text-white text-base font-black transition-all hover:scale-105 active:scale-95 shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined fill-1">bolt</span>
                    <span>Join Now</span>
                </a>
            </div>
        </div>
        @endif

        <!-- Public Meetings Section -->
        @if(isset($public_meetings) && $public_meetings->count() > 0)
        <section class="mb-12">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-black tracking-tight text-slate-900">Open Service Meetings</h2>
                <span class="text-[10px] font-black px-2.5 py-1 bg-primary/10 text-primary rounded-full uppercase tracking-widest">{{ $public_meetings->count() }} Available</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($public_meetings as $meeting)
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="size-12 rounded-2xl bg-primary/5 text-primary flex items-center justify-center font-black">
                            {{ substr($meeting->host->name ?? 'D', 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 leading-tight">{{ $meeting->title }}</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Host: {{ $meeting->host->name ?? 'Faculty' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-4 gap-4">
                        <div class="flex items-center gap-2 text-slate-500">
                            <span class="material-symbols-outlined text-sm">groups</span>
                            <span class="text-xs font-bold uppercase tracking-wider">Public</span>
                        </div>
                        <a href="{{ route('meeting.room', $meeting->room_code) }}" class="px-6 py-2 bg-primary text-white rounded-xl text-xs font-black shadow-lg shadow-primary/20 hover:scale-105 transition-all">Join Meeting</a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white p-8 rounded-3xl border border-slate-100 flex items-center gap-6 shadow-sm">
                <div class="size-14 rounded-2xl bg-blue-50 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">menu_book</span>
                </div>
                <div>
                    <p class="text-4xl font-black text-slate-900">{{ $enrollments->count() }}</p>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest mt-1">Active Courses</p>
                </div>
            </div>
            <div class="bg-white p-8 rounded-3xl border border-slate-100 flex items-center gap-6 shadow-sm">
                <div class="size-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">verified</span>
                </div>
                <div>
                    <p class="text-4xl font-black text-slate-900">{{ $completed_count ?? 0 }}</p>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest mt-1">Completed</p>
                </div>
            </div>
            <div class="bg-white p-8 rounded-3xl border border-slate-100 flex items-center gap-6 shadow-sm">
                <div class="size-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">military_tech</span>
                </div>
                <div>
                    <p class="text-4xl font-black text-slate-900">{{ $certificates_count ?? 0 }}</p>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest mt-1">Certificates</p>
                </div>
            </div>
        </div>

        <!-- My Courses Section -->
        <section class="mb-12">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-black tracking-tight text-slate-900">Enrolled Courses</h2>
                <a class="text-primary font-black text-sm hover:underline" href="#">View All</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($enrollments as $enrollment)
                <div class="bg-white p-6 rounded-3xl border border-slate-100 flex flex-col gap-6 hover:shadow-2xl transition-all hover:border-primary/20">
                    <div class="flex gap-5">
                        <div class="size-20 rounded-2xl overflow-hidden shrink-0 border border-slate-100">
                            @if($enrollment->course->thumbnail)
                                <img src="{{ asset($enrollment->course->thumbnail) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-primary/5 flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-4xl">school</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="font-black text-lg text-slate-900 leading-tight line-clamp-1">{{ $enrollment->course->title }}</h3>
                                <span class="text-[10px] font-black px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-full uppercase tracking-widest">Active</span>
                            </div>
                            <p class="text-slate-400 text-xs font-bold">{{ $enrollment->course->instructor->name ?? 'DBIM Faculty' }}</p>
                            <p class="text-slate-400 text-[11px] mt-2 font-medium italic">{{ $enrollment->course->modules->count() }} Learning Modules</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between text-xs font-black text-slate-500 uppercase tracking-widest">
                            <span>Status</span>
                            <span>Ongoing</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-primary h-full w-[10%] rounded-full animate-pulse"></div>
                        </div>
                    </div>
                    <a href="{{ route('student.course.learn', $enrollment->course->id) }}" class="w-full h-14 bg-primary/5 text-primary text-sm font-black rounded-xl hover:bg-primary hover:text-white transition-all flex items-center justify-center">Resume Learning</a>
                </div>
                @empty
                <div class="col-span-2 text-center py-20 bg-white rounded-3xl border-2 border-dashed border-slate-100">
                    <span class="material-symbols-outlined text-6xl text-slate-200 mb-4 font-light">inventory_2</span>
                    <p class="text-slate-400 font-black">You are not enrolled in any courses yet</p>
                    <a href="{{ route('student.catalog') }}" class="text-primary font-black mt-4 inline-block hover:underline">Explore Catalog</a>
                </div>
                @endforelse
            </div>
        </section>

        <!-- Featured Catalog Section -->
        <section class="mb-12">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-8">
                <h2 class="text-2xl font-black tracking-tight text-slate-900">Explore New Content</h2>
                <div class="flex p-1.5 bg-slate-100 rounded-xl">
                    <button onclick="filterContent('all')" id="filter-all" class="filter-btn px-5 py-2 rounded-lg text-xs font-black bg-white shadow-sm transition-all">All</button>
                    <button onclick="filterContent('video')" id="filter-video" class="filter-btn px-5 py-2 rounded-lg text-xs font-black text-slate-500 flex items-center gap-2 hover:text-primary transition-all">
                        <span class="material-symbols-outlined text-lg">videocam</span> Video
                    </button>
                    <button onclick="filterContent('audio')" id="filter-audio" class="filter-btn px-5 py-2 rounded-lg text-xs font-black text-slate-500 flex items-center gap-2 hover:text-primary transition-all">
                        <span class="material-symbols-outlined text-lg">mic</span> Audio
                    </button>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" id="featured-grid">
                @forelse($featured_courses as $course)
                <div class="group cursor-pointer course-card" data-type="{{ $course->type ?? 'video' }}">
                    <div class="aspect-video w-full rounded-2xl relative overflow-hidden mb-4 shadow-lg group-hover:shadow-primary/10 transition-all text-white">
                        <img src="{{ $course->thumbnail ? asset('storage/'.$course->thumbnail) : 'https://placehold.co/600x400?text=Course' }}" onerror="this.src='https://placehold.co/600x400?text=Course'" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-colors"></div>
                        <div class="absolute bottom-4 left-4 px-3 py-1 bg-black/60 backdrop-blur-md text-white text-[10px] font-black rounded-lg uppercase tracking-widest">{{ $course->modules->count() }} Modules</div>
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 size-14 bg-white rounded-full text-primary shadow-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all scale-75 group-hover:scale-100">
                            <a href="{{ route('course.show', $course->id) }}" class="material-symbols-outlined text-3xl fill-1">play_arrow</a>
                        </div>
                    </div>
                    <h4 class="font-black text-lg text-slate-900 leading-tight group-hover:text-primary transition-colors mb-2">
                        <a href="{{ route('course.show', $course->id) }}">{{ $course->title }}</a>
                    </h4>
                    <div class="flex items-center gap-3">
                        <a href="{{ $course->instructor ? route('instructor.profile', $course->instructor->id) : '#' }}" class="text-xs font-black text-slate-400 flex items-center gap-1 uppercase tracking-widest hover:text-primary transition-colors {{ !$course->instructor ? 'pointer-events-none opacity-50' : '' }}">
                            <span class="material-symbols-outlined text-base">person</span> {{ $course->instructor->name ?? 'DBIM Faculty' }}
                        </a>
                        <span class="text-slate-300">•</span>
                        <span class="text-xs font-black text-slate-400 flex items-center gap-1 uppercase tracking-widest">
                            <span class="material-symbols-outlined text-base">{{ ($course->type ?? 'video') == 'audio' ? 'mic' : 'videocam' }}</span> {{ ucfirst($course->type ?? 'Video') }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12 bg-white rounded-3xl border border-dashed border-slate-100">
                    <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">library_books</span>
                    <p class="text-slate-500 font-medium">No new courses available at the moment.</p>
                </div>
                @endforelse
            </div>
        </section>
    </main>
</div>

<footer class="p-8 border-t border-slate-100 bg-white text-center">
    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">© 2024 Divine Business Impact Ministry. Powered by DBIM LMS.</p>
</footer>
@push('scripts')
<script>
    function filterContent(type) {
        const cards = document.querySelectorAll('.course-card');
        const btns = document.querySelectorAll('.filter-btn');
        
        // Update Buttons
        btns.forEach(btn => {
            btn.classList.remove('bg-white', 'shadow-sm', 'text-slate-900');
            btn.classList.add('text-slate-500');
        });
        
        const activeBtn = document.getElementById('filter-' + type);
        activeBtn.classList.remove('text-slate-500');
        activeBtn.classList.add('bg-white', 'shadow-sm', 'text-slate-900');
        
        // Filter Cards
        cards.forEach(card => {
            if (type === 'all' || card.getAttribute('data-type') === type) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
@endpush
@endsection
