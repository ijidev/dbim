@extends('admin.layouts.app')

@section('title', 'LMS Management')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<style>
    body { font-family: 'Inter', sans-serif; } /* Keeping Inter for admin but with Lexend for headings */
    .heading-lexend { font-family: 'Lexend', sans-serif; }
    
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    
    .instructor-stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .instructor-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@section('content')
@php
    $role = Auth::user()->role ?? 'student';
    $isAdmin = $role === 'admin';
    $isInstructor = in_array($role, ['admin', 'instructor']);
    $isMedia = in_array($role, ['admin', 'media']);

    // Dynamic Stats
    $totalStudents = \App\Models\User::count();
    $thisMonthStudents = \App\Models\User::whereMonth('created_at', now()->month)->count();
    $lastMonthStudents = \App\Models\User::whereMonth('created_at', now()->subMonth()->month)->count();
    $studentTrend = $lastMonthStudents > 0 ? round((($thisMonthStudents) / $lastMonthStudents) * 100) : 100;
    $trendIcon = $studentTrend >= 0 ? 'trending_up' : 'trending_down';
    $trendColor = $studentTrend >= 0 ? 'text-emerald-600' : 'text-red-600';

    $activeCourses = \App\Models\Course::count();
    $lastCourse = \App\Models\Course::latest()->first();
    $courseStatus = $lastCourse ? 'Added ' . $lastCourse->created_at->diffForHumans() : 'No courses';

    $liveEvents = \App\Models\Event::count();
    $nextEvent = \App\Models\Event::whereDate('date', '>=', now()->toDateString())
        ->whereTime('time', '>=', now()->toTimeString())
        ->orderBy('date')
        ->orderBy('time')
        ->first();
    
    if ($nextEvent) {
        $eventDateTime = \Carbon\Carbon::parse($nextEvent->date . ' ' . $nextEvent->time);
        $diffHours = now()->diffInHours($eventDateTime);
        $diffMinutes = now()->diffInMinutes($eventDateTime) % 60;
        $nextEventStatus = $diffHours > 0 ? "In {$diffHours}h" : "In {$diffMinutes}m";
    } else {
        $nextEventStatus = "No Upcoming";
    }
@endphp

<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
        <div>
            <h2 class="text-3xl font-black tracking-tight text-slate-900 heading-lexend">
                @if($isAdmin) Ministry Management @elseif($isInstructor) Instructor Dashboard @elseif($isMedia) Media Control @else Dashboard @endif
            </h2>
            <p class="text-slate-500 font-medium">
                @if($isAdmin) Oversee your community's educational content and spiritual growth.
                @elseif($isInstructor) Manage your courses and track student progress.
                @elseif($isMedia) Monitor live streams and manage event broadcasts.
                @else Welcome back to your dashboard. @endif
            </p>
        </div>
        <div class="flex gap-4">
            @if($isInstructor)
            <button class="px-6 h-12 border border-slate-200 rounded-xl text-sm font-black flex items-center gap-2 hover:bg-slate-50 transition-all">
                <span class="material-symbols-outlined text-lg text-primary">file_download</span> 
                <span>Export Reports</span>
            </button>
            @endif
            @if($isMedia)
            <a href="{{ route('livestream.index') }}" class="px-8 h-12 bg-primary text-white rounded-xl text-sm font-black flex items-center gap-2 hover:shadow-xl hover:shadow-primary/20 transition-all">
                <span class="material-symbols-outlined text-lg">bolt</span> 
                <span>Go Live</span>
            </a>
            @endif
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @if($isInstructor)
        <div class="bg-white p-8 rounded-3xl border border-slate-100 flex flex-col gap-4 instructor-stat-card shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Total Students</p>
                <div class="size-10 rounded-xl bg-primary/5 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined">groups</span>
                </div>
            </div>
            <p class="text-4xl font-black text-slate-900 heading-lexend">{{ $totalStudents }}</p>
            <div class="flex items-center gap-2 {{ $trendColor }} font-black text-xs uppercase tracking-widest">
                <span class="material-symbols-outlined text-sm">{{ $trendIcon }}</span> 
                <span>{{ $studentTrend >= 0 ? '+' : '' }}{{ $studentTrend }}% This Month</span>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-slate-100 flex flex-col gap-4 instructor-stat-card shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Active Courses</p>
                <div class="size-10 rounded-xl bg-primary/5 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined">menu_book</span>
                </div>
            </div>
            <p class="text-4xl font-black text-slate-900 heading-lexend">{{ $activeCourses }}</p>
            <div class="flex items-center gap-2 text-primary font-black text-xs uppercase tracking-widest">
                <span class="material-symbols-outlined text-sm">add_circle</span> 
                <span>{{ $courseStatus }}</span>
            </div>
        </div>
        @endif

        @if($isMedia)
        <div class="bg-white p-8 rounded-3xl border border-slate-100 flex flex-col gap-4 instructor-stat-card shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Live Events</p>
                <div class="size-10 rounded-xl bg-primary/5 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined">calendar_today</span>
                </div>
            </div>
            <p class="text-4xl font-black text-slate-900 heading-lexend">{{ $liveEvents }}</p>
            <div class="flex items-center gap-2 text-amber-600 font-black text-xs uppercase tracking-widest">
                <span class="material-symbols-outlined text-sm">schedule</span> 
                <span>{{ $nextEventStatus }}</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Quick Actions Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-5 border-b border-slate-50 bg-slate-50/30">
            <h3 class="font-black text-slate-900 uppercase tracking-widest text-xs">Quick Management</h3>
        </div>
        <div class="p-8 flex flex-wrap gap-4">
            @if($isMedia)
            <a href="{{ route('events.create') }}" class="h-14 px-8 bg-slate-900 text-white rounded-2xl flex items-center justify-center gap-3 font-black text-sm hover:scale-105 transition-all">
                <span class="material-symbols-outlined">add_circle</span> New Event
            </a>
            @endif
            @if($isInstructor)
            <a href="{{ route('courses.create') }}" class="h-14 px-8 bg-primary text-white rounded-2xl flex items-center justify-center gap-3 font-black text-sm hover:scale-105 transition-all shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined">library_add</span> New Course
            </a>
            @endif
            @if($isMedia)
            <a href="{{ route('livestream.index') }}" class="h-14 px-8 border border-slate-200 rounded-2xl flex items-center justify-center gap-3 font-black text-sm hover:bg-slate-50 transition-all">
                <span class="material-symbols-outlined">podcasts</span> Control Room
            </a>
            @endif
            @if($isAdmin)
            <a href="{{ route('users.index') }}" class="h-14 px-8 border border-slate-200 rounded-2xl flex items-center justify-center gap-3 font-black text-sm hover:bg-slate-50 transition-all">
                <span class="material-symbols-outlined">group_add</span> Manage Faculty
            </a>
            @endif
        </div>
    </div>

    <!-- Recent Activity Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Student Table -->
        @if($isInstructor)
        <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between">
                <h3 class="font-black text-slate-900 heading-lexend text-xl">Recent Training Activity</h3>
                <a href="{{ route('users.index') }}" class="text-primary font-black text-xs uppercase tracking-widest hover:underline">Manage All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Student</th>
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Course Enrollment</th>
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recent_enrollments as $enrollment)
                        <tr class="group hover:bg-slate-50/80 transition-all">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="size-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 font-black">
                                        {{ substr($enrollment->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-900 mb-0.5">{{ $enrollment->user->name ?? 'Unknown User' }}</p>
                                        <p class="text-xs font-medium text-slate-400">{{ $enrollment->user->email ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="block font-bold text-slate-700 text-sm mb-1">{{ $enrollment->course->title ?? 'N/A' }}</span>
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest rounded-full border border-emerald-100">
                                    Enrolled
                                </span>
                            </td>
                            <td class="px-8 py-6 text-sm font-bold text-slate-500">
                                {{ $enrollment->created_at->diffForHumans() }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-8 py-10 text-center text-slate-400 font-medium italic">
                                No recent activity found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Sidebar Actions -->
        @if($isInstructor || $isAdmin)
        <div class="lg:col-span-4 space-y-8">
            <div class="bg-primary p-8 rounded-3xl text-white shadow-xl shadow-primary/20 relative overflow-hidden group">
                <div class="relative z-10">
                    <span class="material-symbols-outlined text-4xl mb-4 opacity-50 font-light">tips_and_updates</span>
                    <h4 class="text-xl font-black mb-2 heading-lexend">Module Builder</h4>
                    <p class="text-white/70 font-medium text-sm leading-relaxed mb-6">Create structured learning materials with the new builder interface.</p>
                    <button class="w-full h-12 bg-white text-primary rounded-xl font-black text-xs uppercase tracking-widest hover:bg-slate-50 transition-all">Launch Builder</button>
                </div>
                <div class="absolute -right-10 -bottom-10 size-40 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition-all"></div>
            </div>

            <div class="bg-slate-900 p-8 rounded-3xl text-white shadow-xl relative overflow-hidden group">
                <div class="relative z-10">
                    <span class="material-symbols-outlined text-4xl mb-4 opacity-50 font-light text-primary">analytics</span>
                    <h4 class="text-xl font-black mb-2 heading-lexend">Analytics Pro</h4>
                    <p class="text-white/50 font-medium text-sm leading-relaxed mb-6">Track engagement and course completion rates across all modules.</p>
                    <button class="w-full h-12 bg-primary text-white rounded-xl font-black text-xs uppercase tracking-widest hover:shadow-xl hover:shadow-primary/20 transition-all">View Insights</button>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
