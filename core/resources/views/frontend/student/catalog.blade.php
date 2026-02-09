@extends('layouts.app')

@section('title', 'Course Catalog')

@push('styles')
<style>
    .catalog-layout {
        display: flex;
        min-height: calc(100vh - 72px);
    }
    
    .catalog-sidebar {
        width: 260px;
        background: white;
        border-right: 1px solid #e5e7eb;
        position: sticky;
        top: 72px;
        height: calc(100vh - 72px);
        overflow-y: auto;
        display: none;
    }
    
    @media (min-width: 1024px) {
        .catalog-sidebar {
            display: flex;
            flex-direction: column;
        }
    }
    
    .nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        color: #64748b;
        transition: all 0.2s;
    }
    
    .nav-item:hover {
        background: #f1f5f9;
        color: var(--primary);
    }
    
    .nav-item.active {
        background: rgba(23, 84, 207, 0.1);
        color: var(--primary);
    }
    
    .catalog-main {
        flex: 1;
        background: var(--bg-body);
        overflow-y: auto;
    }
    
    .catalog-header {
        background: white;
        border-bottom: 1px solid #e5e7eb;
        padding: 16px 32px;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .filter-tabs {
        display: flex;
        padding: 4px;
        background: #f1f5f9;
        border-radius: 8px;
        width: fit-content;
    }
    
    .filter-tab {
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .filter-tab.active {
        background: white;
        color: var(--text-main);
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .course-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
    }
    
    .course-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .course-card:hover {
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        transform: translateY(-4px);
    }
    
    .course-card:hover .course-thumbnail {
        transform: scale(1.05);
    }
    
    .course-card:hover .play-btn {
        transform: scale(1);
        opacity: 1;
    }
    
    .course-thumbnail-container {
        position: relative;
        aspect-ratio: 16/9;
        overflow: hidden;
    }
    
    .course-thumbnail {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    
    .thumbnail-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, transparent 50%, rgba(0,0,0,0.4));
    }
    
    .lesson-badge {
        position: absolute;
        bottom: 12px;
        left: 12px;
        padding: 4px 10px;
        background: rgba(0,0,0,0.7);
        backdrop-filter: blur(4px);
        color: white;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        border-radius: 4px;
    }
    
    .play-btn {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 36px;
        height: 36px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: scale(0);
        opacity: 0;
        transition: all 0.3s;
    }
    
    .course-content {
        padding: 16px;
    }
    
    .course-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 8px;
        line-height: 1.4;
        transition: color 0.2s;
    }
    
    .course-card:hover .course-title {
        color: var(--primary);
    }
    
    .course-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 11px;
        color: #64748b;
    }
    
    .enrolled-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
    }
    
    .progress-bar {
        height: 8px;
        background: #e5e7eb;
        border-radius: 999px;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        background: var(--primary);
        border-radius: 999px;
        transition: width 0.5s ease;
    }
    
    .live-alert {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        padding: 20px 24px;
        background: rgba(23, 84, 207, 0.05);
        border: 1px solid rgba(23, 84, 207, 0.2);
        border-left: 4px solid var(--primary);
        border-radius: 12px;
        flex-wrap: wrap;
    }
    
    @keyframes live-pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    .live-dot {
        animation: live-pulse 2s infinite;
    }
</style>
@endpush

@section('content')
<div class="catalog-layout">
    <!-- Sidebar -->
    <aside class="catalog-sidebar">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-white">
                    <span class="material-symbols-outlined">school</span>
                </div>
                <div>
                    <h1 class="text-base font-bold leading-tight">DBIM Academy</h1>
                    <p class="text-slate-500 text-xs">Spiritual Growth</p>
                </div>
            </div>
        </div>
        
        <nav class="flex-1 px-4 space-y-1">
            <a href="{{ route('student.dashboard') }}" class="nav-item">
                <span class="material-symbols-outlined text-xl">dashboard</span>
                Dashboard
            </a>
            <a href="{{ route('student.catalog') }}" class="nav-item active">
                <span class="material-symbols-outlined text-xl">book_2</span>
                Course Catalog
            </a>
            <a href="{{ route('student.dashboard') }}" class="nav-item">
                <span class="material-symbols-outlined text-xl">school</span>
                My Learning
            </a>
            <a href="{{ route('library.index') }}" class="nav-item">
                <span class="material-symbols-outlined text-xl">auto_stories</span>
                Library
            </a>
        </nav>
        
        <div class="p-4 border-t border-slate-200">
            <div class="flex items-center gap-3 p-2">
                <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary font-bold text-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-500 capitalize">{{ Auth::user()->role }}</p>
                </div>
            </div>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="catalog-main">
        <!-- Header -->
        <div class="catalog-header">
            <div class="flex items-center gap-6">
                <div class="relative flex-1 max-w-md">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                    <input type="text" id="catalog-search" placeholder="Search courses, topics..." 
                           class="w-full pl-10 pr-4 py-2.5 rounded-lg bg-slate-100 border-none focus:ring-2 focus:ring-primary text-sm">
                </div>
            </div>
        </div>
        
        <div class="p-8 max-w-6xl mx-auto space-y-8">
            <!-- Welcome -->
            <div class="flex flex-wrap justify-between items-end gap-4">
                <div>
                    <h2 class="text-2xl font-black tracking-tight">Welcome back, {{ explode(' ', Auth::user()->name)[0] }}</h2>
                    <p class="text-slate-500">Explore our catalog and continue your spiritual growth journey.</p>
                </div>
                <a href="{{ route('student.schedule') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm font-bold shadow-sm hover:bg-slate-50">
                    <span class="material-symbols-outlined text-lg">calendar_month</span>
                    View Schedule
                </a>
            </div>
            
            @if($live_meeting)
            <!-- Live Class Alert -->
            <div class="live-alert">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white shrink-0">
                        <span class="material-symbols-outlined">videocam</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-2 h-2 rounded-full bg-red-500 live-dot"></span>
                            <span class="text-xs font-bold text-red-500 uppercase tracking-wider">Live Now</span>
                        </div>
                        <p class="font-bold text-lg">{{ $live_meeting->title }}</p>
                        <p class="text-slate-500 text-sm">Join {{ $live_meeting->host->name }} and others in this live session.</p>
                    </div>
                </div>
                <a href="{{ route('meeting.room', $live_meeting->room_code) }}" class="flex items-center justify-center gap-2 rounded-lg h-11 px-6 bg-primary text-white text-sm font-bold hover:bg-primary-dark transition-all">
                    <span class="material-symbols-outlined">bolt</span>
                    Join Now
                </a>
            </div>
            @endif
            
            @if($my_enrollments->count() > 0)
            <!-- My Courses -->
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold">My Courses</h2>
                    <a href="{{ route('student.dashboard') }}" class="text-primary text-sm font-semibold hover:underline">View All</a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($my_enrollments->take(2) as $enrollment)
                    <div class="enrolled-card">
                        <div class="flex gap-4">
                            <div class="w-16 h-16 rounded-lg bg-blue-50 flex items-center justify-center text-primary shrink-0">
                                <span class="material-symbols-outlined text-3xl">menu_book</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-bold">{{ $enrollment->course->title }}</h3>
                                    <span class="text-xs font-bold px-2 py-1 bg-green-100 text-green-700 rounded">Active</span>
                                </div>
                                <p class="text-slate-500 text-xs mt-1">
                                    {{ $enrollment->course->modules->sum(fn($m) => $m->lessons->count()) }} Lessons
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 space-y-2">
                            <div class="flex justify-between text-xs font-medium">
                                <span>Progress</span>
                                <span>{{ $enrollment->progress ?? 0 }}%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $enrollment->progress ?? 0 }}%"></div>
                            </div>
                        </div>
                        <a href="{{ route('student.course.learn', $enrollment->course) }}" 
                           class="block w-full mt-4 py-2 bg-primary/10 text-primary text-sm font-bold rounded-lg text-center hover:bg-primary/20">
                            Resume Learning
                        </a>
                    </div>
                    @endforeach
                </div>
            </section>
            @endif
            
            <!-- Course Catalog -->
            <section class="space-y-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-xl font-bold">Browse Catalog</h2>
                    <div class="filter-tabs">
                        <button class="filter-tab active" data-filter="all">All</button>
                        <button class="filter-tab" data-filter="video">
                            <span class="material-symbols-outlined text-base">videocam</span> Video
                        </button>
                        <button class="filter-tab" data-filter="audio">
                            <span class="material-symbols-outlined text-base">mic</span> Audio
                        </button>
                    </div>
                </div>
                
                <div class="course-grid" id="course-grid">
                    @forelse($courses as $course)
                    <a href="{{ route('course.show', $course) }}" class="course-card" data-type="{{ $course->type ?? 'video' }}">
                        <div class="course-thumbnail-container">
                            <img src="{{ asset($course->thumbnail ?? 'assets/images/courses/default.jpg') }}" 
                                 alt="{{ $course->title }}" 
                                 class="course-thumbnail"
                                 onerror="this.src='https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=600&h=400&fit=crop'">
                            <div class="thumbnail-overlay"></div>
                            <div class="lesson-badge">
                                {{ $course->modules->sum(fn($m) => $m->lessons->count()) }} Lessons
                            </div>
                            <div class="play-btn">
                                <span class="material-symbols-outlined">play_arrow</span>
                            </div>
                        </div>
                        <div class="course-content">
                            <h4 class="course-title">{{ $course->title }}</h4>
                            <div class="course-meta">
                                <div class="meta-item">
                                    <span class="material-symbols-outlined text-sm">person</span>
                                    {{ $course->instructor->name ?? 'DBIM' }}
                                </div>
                                <span class="text-slate-300">•</span>
                                <div class="meta-item">
                                    @if(($course->type ?? 'video') === 'audio')
                                    <span class="material-symbols-outlined text-sm">mic</span> Audio
                                    @else
                                    <span class="material-symbols-outlined text-sm">videocam</span> Video
                                    @endif
                                </div>
                                @if($course->price > 0)
                                <span class="text-slate-300">•</span>
                                <div class="meta-item text-primary font-bold">
                                    ₦{{ number_format($course->price) }}
                                </div>
                                @else
                                <span class="text-slate-300">•</span>
                                <div class="meta-item text-green-600 font-bold">Free</div>
                                @endif
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="col-span-full text-center py-16">
                        <span class="material-symbols-outlined text-6xl text-slate-300 mb-4">school</span>
                        <h3 class="text-xl font-bold text-slate-500 mb-2">No courses available</h3>
                        <p class="text-slate-400">Check back later for new courses!</p>
                    </div>
                    @endforelse
                </div>
            </section>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterTabs = document.querySelectorAll('.filter-tab');
    const courseCards = document.querySelectorAll('.course-card');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const filter = this.dataset.filter;
            
            // Update active tab
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Filter cards
            courseCards.forEach(card => {
                if (filter === 'all' || card.dataset.type === filter) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
    
    // Search functionality
    const searchInput = document.getElementById('catalog-search');
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        
        courseCards.forEach(card => {
            const title = card.querySelector('.course-title').textContent.toLowerCase();
            if (title.includes(query)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});
</script>
@endpush
