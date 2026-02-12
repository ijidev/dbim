@extends('layouts.app')

@section('title', 'Instructor Dashboard')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<style>
    body { font-family: 'Lexend', sans-serif; }
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .fill-1 { font-variation-settings: 'FILL' 1; }
    
    .instructor-sidebar {
        width: 280px;
        background: white;
        border-right: 1px solid #e2e8f0;
        height: calc(100vh - 64px);
        position: sticky;
        top: 64px;
    }
    .nav-link.active {
        background: rgba(23, 84, 207, 0.05);
        color: var(--primary-color);
        border-right: 3px solid var(--primary-color);
    }
    .stat-card {
        background: white;
        border-radius: 1.5rem;
        padding: 1.5rem;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);
    }
    .course-grid-card {
        background: white;
        border-radius: 1.25rem;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .course-grid-card:hover {
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
    }
</style>
@endpush

@section('content')
@php
    $courses = $courses ?? collect();
    $active_courses_count = $active_courses_count ?? 0;
    $total_students_count = $total_students_count ?? 0;
    $upcoming_meetings = $upcoming_meetings ?? collect();
    $recent_enrollments = $recent_enrollments ?? collect();
@endphp
<div class="flex bg-[#f8fafc] min-h-screen">
    <!-- Sidebar -->
    <aside class="hidden lg:flex flex-col instructor-sidebar">
        <div class="p-8 pb-4">
            <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-6">Instructor Menu</h2>
            <nav class="space-y-1">
                <a href="{{ route('instructor.dashboard') }}" class="nav-link active flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-black transition-all">
                    <span class="material-symbols-outlined text-lg fill-1">dashboard</span>
                    Dashboard
                </a>
                <a href="{{ route('courses.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-primary hover:bg-slate-50 rounded-xl text-sm font-bold transition-all">
                    <span class="material-symbols-outlined text-lg">book_2</span>
                    My Courses
                </a>
                <a href="{{ route('instructor.students.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-primary hover:bg-slate-50 rounded-xl text-sm font-bold transition-all">
                    <span class="material-symbols-outlined text-lg">groups</span>
                    Students
                </a>
                <a href="{{ route('meeting.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-primary hover:bg-slate-50 rounded-xl text-sm font-bold transition-all">
                    <span class="material-symbols-outlined text-lg">video_call</span>
                    Meetings & Live
                </a>
            </nav>
        </div>
        
        <div class="mt-auto p-8 pt-4">
            <a href="{{ route('courses.create') }}" class="w-full h-14 bg-primary text-white rounded-2xl flex items-center justify-center gap-3 text-sm font-black shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                <span class="material-symbols-outlined text-lg">add_circle</span>
                New Course
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 lg:p-12">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 mb-2">Instructor Dashboard</h1>
                    <p class="text-slate-500 font-medium">Greetings, {{ explode(' ', Auth::user()->name)[0] }}. Here is what's happening today.</p>
                </div>
                <div class="flex gap-3">
                    <button class="px-6 py-3 bg-white border border-slate-200 rounded-xl text-xs font-black hover:bg-slate-50 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">file_download</span> Export Data
                    </button>
                    <a href="{{ route('meeting.create') }}" class="px-6 py-3 bg-primary text-white rounded-xl text-xs font-black shadow-lg shadow-primary/20 hover:scale-105 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">bolt</span> Go Live
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="stat-card">
                    <div class="flex items-center justify-between mb-4">
                        <div class="size-14 rounded-2xl bg-blue-50 text-primary flex items-center justify-center">
                            <span class="material-symbols-outlined text-3xl">groups</span>
                        </div>
                        <span class="text-emerald-500 text-xs font-black flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">trending_up</span> +12%
                        </span>
                    </div>
                    <p class="text-4xl font-black text-slate-900 mb-1">{{ number_format($total_students_count) }}</p>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest font-display">Total Students</p>
                </div>

                <div class="stat-card">
                    <div class="flex items-center justify-between mb-4">
                        <div class="size-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-3xl">menu_book</span>
                        </div>
                        <span class="text-slate-400 text-[10px] font-black uppercase">Active now</span>
                    </div>
                    <p class="text-4xl font-black text-slate-900 mb-1">{{ $active_courses_count }}</p>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest font-display">Published Courses</p>
                </div>

                <div class="stat-card">
                    <div class="flex items-center justify-between mb-4">
                        <div class="size-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-3xl">podcasts</span>
                        </div>
                    </div>
                    @php
                        $active_meetings = $upcoming_meetings->where('status', 'active')->count();
                    @endphp
                    <p class="text-4xl font-black text-slate-900 mb-1">{{ $active_meetings }}</p>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest font-display">Live Sessions</p>
                </div>
            </div>

            <!-- Content Split -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Recent Courses -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-black text-slate-900">Recent Projects</h2>
                        <a href="{{ route('courses.index') }}" class="text-primary text-xs font-black underline decoration-2 underline-offset-4">View All</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($courses->take(4) as $course)
                        <div class="course-grid-card group">
                            <div class="h-44 relative bg-slate-200">
                                <img src="{{ $course->thumbnail ? asset('storage/'.$course->thumbnail) : 'https://placehold.co/600x400?text=Course' }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                                <div class="absolute bottom-4 left-4">
                                    <span class="bg-primary px-2 py-0.5 rounded text-[10px] font-black text-white uppercase tracking-wider mb-2 inline-block">DBIM Academy</span>
                                    <h4 class="text-white font-black leading-tight">{{ $course->title }}</h4>
                                </div>
                            </div>
                            <div class="p-5">
                                <div class="flex items-center justify-between mb-5">
                                    <div class="flex items-center gap-2 text-slate-500 text-[10px] font-black uppercase">
                                        <span class="material-symbols-outlined text-sm">groups</span>
                                        {{ $course->students->count() }} Students
                                    </div>
                                    <div class="flex items-center gap-2 text-slate-500 text-[10px] font-black uppercase">
                                        <span class="material-symbols-outlined text-sm">history</span>
                                        {{ $course->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('courses.edit', $course->id) }}" class="flex-1 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-[10px] font-black uppercase hover:bg-primary hover:text-white transition-all">Manage Course</a>
                                    <button class="size-10 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 hover:text-primary transition-all">
                                        <span class="material-symbols-outlined text-lg">more_horiz</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Upload Placeholder -->
                    <div class="bg-white border-2 border-dashed border-slate-200 rounded-[2rem] p-12 text-center">
                        <div class="size-16 bg-blue-50 text-primary rounded-full flex items-center justify-center mx-auto mb-6">
                            <span class="material-symbols-outlined text-4xl">cloud_upload</span>
                        </div>
                        <h3 class="text-lg font-black text-slate-900 mb-2">Upload New Content</h3>
                        <p class="text-slate-500 max-w-sm mx-auto mb-8">Drag & drop your sermons, video lessons, or PDF guides here to quickly add to a course module.</p>
                        <div class="flex justify-center gap-4">
                            <button class="px-8 py-3 bg-primary text-white rounded-xl text-sm font-black shadow-lg shadow-primary/20">Browse Files</button>
                            <button class="px-8 py-3 bg-white border border-slate-200 rounded-xl text-sm font-black">External URL</button>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity & Meetings -->
                <div class="space-y-12">
                    <section>
                        <h2 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">calendar_month</span> Next Meetings
                        </h2>
                        <div class="space-y-4">
                            @forelse($upcoming_meetings as $meeting)
                            <div class="bg-primary/5 border border-primary/20 rounded-2xl p-5 flex items-start gap-4">
                                <div class="bg-primary text-white py-2 px-3 rounded-xl text-center min-w-[55px]">
                                    <span class="text-[10px] uppercase font-black block leading-none mb-1">{{ $meeting->scheduled_at ? $meeting->scheduled_at->format('M') : 'Now' }}</span>
                                    <span class="text-xl font-black block leading-none">{{ $meeting->scheduled_at ? $meeting->scheduled_at->format('d') : '⚡' }}</span>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-black text-slate-900 text-sm mb-0.5 line-clamp-1">{{ $meeting->title }}</h4>
                                    <p class="text-xs text-slate-500 font-bold mb-3">{{ $meeting->scheduled_at ? $meeting->scheduled_at->format('h:i A') : 'Ongoing Session' }}</p>
                                    <a href="{{ route('meeting.room', $meeting->room_code) }}" class="inline-flex items-center gap-2 px-3 py-1.5 bg-primary text-white text-[10px] font-black uppercase rounded-lg">Join Room</a>
                                </div>
                            </div>
                            @empty
                            <div class="p-8 text-center bg-white rounded-2xl border border-slate-100">
                                <p class="text-slate-400 italic text-sm">No upcoming meetings.</p>
                            </div>
                            @endforelse
                        </div>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">notifications_active</span> Recent Students
                        </h2>
                        <div class="bg-white rounded-[2rem] border border-slate-100 overflow-hidden shadow-sm">
                            <div class="divide-y divide-slate-50">
                                @foreach($recent_enrollments as $enrollment)
                                <div class="p-5 flex items-center gap-4 hover:bg-slate-50 transition-all cursor-pointer">
                                    <div class="size-10 rounded-full bg-blue-100 text-primary flex items-center justify-center font-black text-[10px]">
                                        {{ substr($enrollment->user->name, 0, 2) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-black text-slate-900 line-clamp-1">{{ $enrollment->user->name }}</p>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter line-clamp-1">{{ $enrollment->course->title }}</p>
                                    </div>
                                    <span class="text-[10px] font-black text-slate-300">{{ $enrollment->created_at->diffForHumans() }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
