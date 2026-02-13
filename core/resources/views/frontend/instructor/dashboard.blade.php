@extends('layouts.instructor')

@section('title', 'Instructor Dashboard')
@section('page_title', 'Dashboard Overview')

@section('instructor_content')
<div class="space-y-12">
    <!-- Welcome Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 leading-tight">Welcome back, {{ Auth::user()->name }}!</h1>
            <p class="text-slate-500 font-medium mt-1">Here's what's happening with your ministry and courses today.</p>
        </div>
        <div class="flex gap-4">
             <button class="h-12 px-6 bg-white border border-slate-200 rounded-xl text-xs font-black text-slate-600 hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-lg">calendar_month</span>
                Schedule Event
            </button>
            <a href="{{ route('instructor.courses.create') }}" class="h-12 px-6 bg-primary text-white rounded-xl text-xs font-black flex items-center gap-2 shadow-lg shadow-primary/20 hover:scale-105 transition-all">
                <span class="material-symbols-outlined text-lg">add_box</span>
                New Course
            </a>
        </div>
    </div>

    <!-- Stat Cards (Stitch Style) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Students -->
        <div class="bg-white p-8 rounded-[2rem] border border-[#dcdfe5] shadow-sm group hover:shadow-xl hover:shadow-primary/5 transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="size-14 rounded-2xl bg-primary/5 text-primary flex items-center justify-center transition-colors group-hover:bg-primary group-hover:text-white">
                    <span class="material-symbols-outlined text-2xl font-bold">groups</span>
                </div>
                <div class="flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black uppercase tracking-wider">
                    <span class="material-symbols-outlined text-xs">trending_up</span>
                    12%
                </div>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Total Students</p>
            <h3 class="text-3xl font-black text-slate-900">{{ $totalStudents ?? 0 }}</h3>
        </div>

        <!-- Active Courses -->
        <div class="bg-white p-8 rounded-[2rem] border border-[#dcdfe5] shadow-sm group hover:shadow-xl hover:shadow-primary/5 transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="size-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center transition-colors group-hover:bg-amber-600 group-hover:text-white">
                    <span class="material-symbols-outlined text-2xl font-bold">book_2</span>
                </div>
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-2.5 py-1 bg-slate-50 rounded-full">
                    Active
                </div>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">My Courses</p>
            <h3 class="text-3xl font-black text-slate-900">{{ $activeCoursesCount ?? 0 }}</h3>
        </div>

        <!-- Total Sessions -->
        <div class="bg-white p-8 rounded-[2rem] border border-[#dcdfe5] shadow-sm group hover:shadow-xl hover:shadow-primary/5 transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="size-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center transition-colors group-hover:bg-blue-600 group-hover:text-white">
                    <span class="material-symbols-outlined text-2xl font-bold">video_call</span>
                </div>
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-2.5 py-1 bg-slate-50 rounded-full text-blue-500">
                    Live
                </div>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Total Sessions</p>
            <h3 class="text-3xl font-black text-slate-900">{{ $totalMeetings ?? 0 }}</h3>
        </div>

        <!-- Engagement Rate (Placeholder) -->
        <div class="bg-white p-8 rounded-[2rem] border border-[#dcdfe5] shadow-sm group hover:shadow-xl hover:shadow-primary/5 transition-all">
            <div class="flex items-center justify-between mb-4">
                <div class="size-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center transition-colors group-hover:bg-rose-600 group-hover:text-white">
                    <span class="material-symbols-outlined text-2xl font-bold">bolt</span>
                </div>
                <div class="flex items-center gap-1.5 px-2.5 py-1 bg-rose-50 text-rose-600 rounded-full text-[10px] font-black uppercase tracking-wider">
                    <span class="material-symbols-outlined text-xs">analytics</span>
                    84%
                </div>
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Engagement</p>
            <h3 class="text-3xl font-black text-slate-900">High</h3>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Upcoming Meetings -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-black text-slate-900 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">event_upcoming</span>
                    Upcoming Live Sessions
                </h3>
                <a href="{{ route('meeting.index') }}" class="text-xs font-black text-primary hover:underline">VIEW SCHEDULE</a>
            </div>
            
            <div class="bg-white rounded-[2.5rem] border border-[#dcdfe5] shadow-sm overflow-hidden min-h-[400px]">
                @forelse($meetings as $meeting)
                <div class="p-8 flex items-center justify-between border-b border-slate-50 hover:bg-slate-50 transition-all group">
                    <div class="flex items-center gap-6">
                        <div class="flex flex-col items-center justify-center size-16 rounded-2xl bg-slate-50 border border-slate-100 group-hover:bg-white transition-all">
                            <span class="text-[10px] font-black text-slate-400 uppercase">{{ $meeting->scheduled_at->format('M') }}</span>
                            <span class="text-xl font-black text-primary">{{ $meeting->scheduled_at->format('d') }}</span>
                        </div>
                        <div>
                            <h4 class="font-black text-slate-900 group-hover:text-primary transition-colors">{{ $meeting->title }}</h4>
                            <div class="flex items-center gap-4 mt-2">
                                <p class="text-xs font-bold text-slate-400 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px]">schedule</span>
                                    {{ $meeting->scheduled_at->format('h:i A') }}
                                </p>
                                <span class="bg-blue-100 text-primary text-[10px] font-black px-2 py-0.5 rounded-full uppercase tracking-widest">
                                    {{ $meeting->type }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('meeting.show', $meeting->id) }}" class="h-12 px-6 bg-white border border-slate-200 rounded-xl text-xs font-black hover:bg-primary hover:text-white hover:border-primary transition-all flex items-center gap-2">
                        Enter Room
                        <span class="material-symbols-outlined text-lg">arrow_forward</span>
                    </a>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center h-[400px] text-center p-12">
                    <div class="size-20 bg-slate-100 rounded-[2rem] flex items-center justify-center text-slate-300 mb-6">
                        <span class="material-symbols-outlined text-4xl">event_busy</span>
                    </div>
                    <h3 class="text-xl font-black text-slate-900">No scheduled sessions</h3>
                    <p class="text-sm text-slate-500 max-w-xs mt-2">Start a new live session or meeting with your students now.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Enrollments & Export (Stitch Style) -->
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-black text-slate-900 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">chat</span>
                    Student Engagement
                </h3>
            </div>
            
            <div class="bg-white p-10 rounded-[2.5rem] border border-[#dcdfe5] shadow-sm space-y-8">
                <div>
                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6 px-2">Recent Enrollments</h4>
                    <div class="space-y-6">
                        @foreach($recentEnrollments as $enrollment)
                        <div class="flex items-center gap-4 px-2">
                            <div class="size-11 rounded-2xl bg-blue-100 text-primary flex items-center justify-center font-black text-xs border border-white shadow-sm overflow-hidden">
                                @if($enrollment->user->profile_picture)
                                    <img src="{{ asset('storage/'.$enrollment->user->profile_picture) }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($enrollment->user->name, 0, 2)) }}
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-black text-slate-900 truncate">{{ $enrollment->user->name }}</p>
                                <p class="text-[10px] font-bold text-slate-400 truncate mt-0.5">{{ $enrollment->course->title }}</p>
                            </div>
                            <span class="text-[10px] font-bold text-slate-300">{{ $enrollment->created_at->diffForHumans() }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-50">
                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6 px-2">Quick Actions</h4>
                    <div class="grid grid-cols-1 gap-3">
                        <a href="{{ route('instructor.students.export') }}" class="w-full h-14 bg-[#f8f9fb] border border-slate-100 rounded-2xl flex items-center justify-center gap-3 text-[10px] font-black text-slate-600 hover:bg-primary hover:text-white hover:border-primary transition-all">
                            <span class="material-symbols-outlined text-lg">download</span>
                            EXPORT STUDENT DATA
                        </a>
                        <button class="w-full h-14 bg-[#f8f9fb] border border-slate-100 rounded-2xl flex items-center justify-center gap-3 text-[10px] font-black text-slate-600 hover:bg-primary hover:text-white hover:border-primary transition-all uppercase">
                            <span class="material-symbols-outlined text-lg">description</span>
                            Generate Reports
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
