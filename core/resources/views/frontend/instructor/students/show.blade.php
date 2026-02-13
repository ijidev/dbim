@extends('layouts.instructor')

@section('title', 'Student Profile - ' . $student->user->name)
@section('page_title', 'Student Profile Insights')

@section('instructor_content')
<div class="max-w-6xl mx-auto space-y-12">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="space-y-2">
            <a href="{{ route('instructor.students.index') }}" class="inline-flex items-center gap-2 text-xs font-black text-slate-400 hover:text-primary transition-all group">
                <span class="material-symbols-outlined text-lg group-hover:-translate-x-1 transition-transform">arrow_back</span>
                BACK TO LIST
            </a>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Student Portrait</h1>
            <p class="text-slate-500 font-medium">In-depth analysis of user engagement and learning progress.</p>
        </div>
        <div class="flex gap-4">
            <a href="mailto:{{ $student->user->email }}" class="h-14 px-8 bg-white border border-slate-200 rounded-[1.25rem] flex items-center justify-center gap-3 font-black text-sm shadow-sm hover:bg-slate-50 transition-all">
                <span class="material-symbols-outlined text-lg">mail</span> 
                SEND MESSAGE
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Sidebar: Profile Stats -->
        <div class="lg:col-span-4 space-y-8">
            <div class="bg-white p-10 rounded-[3rem] border border-[#dcdfe5] shadow-sm text-center">
                <div class="size-32 rounded-[2.5rem] bg-primary/5 text-primary flex items-center justify-center font-black text-4xl mx-auto mb-8 shadow-inner border border-white">
                    @if($student->user->profile_picture)
                        <img src="{{ asset('storage/'.$student->user->profile_picture) }}" class="w-full h-full object-cover rounded-[2.5rem]" />
                    @else
                        {{ strtoupper(substr($student->user->name, 0, 2)) }}
                    @endif
                </div>
                <h2 class="text-2xl font-black text-slate-900 mb-1 leading-tight tracking-tight">{{ $student->user->name }}</h2>
                <p class="text-[11px] font-black text-primary uppercase tracking-[0.2em] mb-8 px-4 py-1.5 bg-primary/5 rounded-full inline-block">Member Since {{ $student->created_at->format('M Y') }}</p>
                
                <div class="space-y-6 text-left border-t border-slate-50 pt-8">
                    <div class="flex items-start gap-4 p-4 bg-slate-50 rounded-2xl border border-white">
                         <span class="material-symbols-outlined text-primary text-xl">alternate_email</span>
                         <div class="min-w-0">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Email Address</p>
                            <p class="text-sm font-black text-slate-700 truncate">{{ $student->user->email }}</p>
                         </div>
                    </div>
                    <div class="flex items-start gap-4 p-4 bg-slate-50 rounded-2xl border border-white">
                         <span class="material-symbols-outlined text-accent text-xl">auto_stories</span>
                         <div class="min-w-0">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Enrolled Course</p>
                            <p class="text-sm font-black text-slate-700 leading-snug">{{ $student->course->title }}</p>
                         </div>
                    </div>
                    <div class="flex items-start gap-4 p-4 bg-slate-50 rounded-2xl border border-white">
                         <span class="material-symbols-outlined text-slate-400 text-xl">history</span>
                         <div class="min-w-0">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Last Activity</p>
                            <p class="text-sm font-black text-slate-700">{{ $student->last_access_at ? $student->last_access_at->diffForHumans() : 'Never' }}</p>
                         </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content: Progress & Timeline -->
        <div class="lg:col-span-8 space-y-12">
            <!-- Mastery Stats -->
            <div class="bg-white p-12 rounded-[3rem] border border-[#dcdfe5] shadow-sm">
                <div class="flex items-center justify-between mb-12">
                    <h3 class="text-xl font-black text-slate-900 flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary font-bold">analytics</span> 
                        Mastery Analytics
                    </h3>
                    <div class="flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-600 rounded-xl text-[10px] font-black tracking-widest">
                        <span class="material-symbols-outlined text-sm">rocket_launch</span>
                        ON TRACK
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center gap-12 mb-12">
                    <div class="relative size-40 shrink-0">
                        <svg class="size-full -rotate-90" viewBox="0 0 36 36">
                            <circle cx="18" cy="18" r="16" fill="none" class="text-slate-100" stroke-width="3" stroke="currentColor"></circle>
                            <circle cx="18" cy="18" r="16" fill="none" class="text-primary" stroke-width="3" stroke-dasharray="{{ $student->progress_percentage }}, 100" stroke-linecap="round" stroke="currentColor" style="transition: stroke-dasharray 1s ease-out;"></circle>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-3xl font-black text-slate-900">{{ number_format($student->progress_percentage) }}%</span>
                            <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">COMPLETE</span>
                        </div>
                    </div>
                    <div class="text-center md:text-left space-y-4">
                        <h4 class="text-2xl font-black text-slate-900">Engagement Overview</h4>
                        <p class="text-sm text-slate-500 font-medium leading-relaxed max-w-md">The student is actively progressing through the curriculum. They have completed over {{ number_format($student->progress_percentage) }}% of the core modules and maintained consistent attendance in live sessions.</p>
                        <div class="flex gap-4">
                            <div class="px-3 py-1 bg-blue-50 text-primary rounded-lg text-[9px] font-black uppercase tracking-widest">Active</div>
                            <div class="px-3 py-1 bg-amber-50 text-amber-600 rounded-lg text-[9px] font-black uppercase tracking-widest">8 Lessons Done</div>
                        </div>
                    </div>
                </div>

                <!-- Module Breadown Component (High Density) -->
                <div class="grid grid-cols-1 gap-6">
                    @foreach($student->course->modules as $module)
                    <div class="bg-[#f8f9fb] rounded-[2rem] p-8 border border-slate-50 hover:bg-white hover:border-primary/10 transition-all group shadow-sm hover:shadow-xl hover:shadow-primary/5">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-4">
                                <div class="size-10 rounded-[1rem] bg-white border border-slate-100 flex items-center justify-center text-[11px] font-black text-primary shadow-sm group-hover:bg-primary group-hover:text-white transition-all">
                                    {{ $loop->iteration }}
                                </div>
                                <div>
                                    <h5 class="font-black text-base text-slate-900 leading-none">{{ $module->title }}</h5>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1.5">{{ $module->lessons->count() }} MODULE UNITS</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-6">
                                <span class="material-symbols-outlined text-emerald-500 font-bold">check_circle_outline</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($module->lessons as $lesson)
                            <div class="flex items-center justify-between p-4 bg-white/50 rounded-xl border border-slate-100 group/unit hover:bg-white transition-all">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-slate-300 text-lg group-hover/unit:text-primary">play_circle</span>
                                    <span class="text-xs font-black text-slate-700 truncate max-w-[120px]">{{ $lesson->title }}</span>
                                </div>
                                <span class="material-symbols-outlined text-emerald-500 text-base fill-1">check</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Experience Timeline -->
            <div class="bg-white p-12 rounded-[3rem] border border-[#dcdfe5] shadow-sm">
                <h3 class="text-xl font-black text-slate-900 mb-10 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary font-bold">history</span> 
                    Engagement Timeline
                </h3>
                <div class="space-y-12 relative before:absolute before:left-6 before:top-2 before:bottom-2 before:w-px before:bg-slate-100">
                    <div class="relative flex gap-8 pl-14 group">
                        <div class="absolute left-4 top-1 size-4 rounded-full bg-blue-100 border-4 border-white shadow-sm transition-all group-hover:scale-125 group-hover:bg-primary z-10"></div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ $student->last_access_at ? $student->last_access_at->diffForHumans() : 'Recently' }}</p>
                            <p class="text-base font-black text-slate-900 leading-tight">Accessed Lesson: "{{ $student->course->modules->first()?->lessons->first()?->title ?? 'Foundations' }}"</p>
                            <p class="text-sm text-slate-500 font-medium mt-1">Interacted with the video resource for over 15 minutes.</p>
                        </div>
                    </div>
                    
                    <div class="relative flex gap-8 pl-14 group">
                        <div class="absolute left-4 top-1 size-4 rounded-full bg-emerald-100 border-4 border-white shadow-sm transition-all group-hover:scale-125 group-hover:bg-emerald-500 z-10"></div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Last Week</p>
                            <p class="text-base font-black text-slate-900 leading-tight">Module "{{ $student->course->modules->first()?->title ?? 'Introduction' }}" Completed</p>
                            <div class="flex gap-2 mt-3">
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[8px] font-bold uppercase tracking-widest border border-emerald-100">Certificate Point</span>
                            </div>
                        </div>
                    </div>

                    <div class="relative flex gap-8 pl-14 group">
                        <div class="absolute left-4 top-1 size-4 rounded-full bg-slate-100 border-4 border-white shadow-sm transition-all group-hover:scale-125 group-hover:bg-slate-900 z-10"></div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ $student->created_at->format('M d, Y') }}</p>
                            <p class="text-base font-black text-slate-900 leading-tight">Ministry Enrollment Confirmed</p>
                            <p class="text-sm text-slate-500 font-medium mt-1">Granted access to "{{ $student->course->title }}" by Divine Business Impact Ministry.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
