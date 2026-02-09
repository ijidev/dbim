@extends('layouts.app')

@section('title', 'My Learning - Grace LMS')

@push('styles')
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .fill-1 {
        font-variation-settings: 'FILL' 1;
    }
    
    .sidebar-link.active {
        background-color: rgba(23, 84, 207, 0.1);
        color: var(--primary);
    }
    
    .progress-bar {
        transition: width 1s ease-in-out;
    }
</style>
@endpush

@section('content')
<div class="flex h-[calc(100vh-64px)] overflow-hidden bg-slate-50">
    <!-- Sidebar Navigation (Desktop) -->
    <aside class="hidden lg:flex w-72 flex-col border-r border-slate-200 bg-white h-full shrink-0">
        <nav class="flex-1 px-6 py-8 space-y-2">
            <a href="{{ route('student.dashboard') }}" class="sidebar-link flex items-center gap-4 px-4 py-3 text-slate-500 hover:text-primary hover:bg-slate-50 rounded-xl text-sm font-bold transition-all">
                <span class="material-symbols-outlined">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('student.catalog') }}" class="sidebar-link flex items-center gap-4 px-4 py-3 text-slate-500 hover:text-primary hover:bg-slate-50 rounded-xl text-sm font-bold transition-all">
                <span class="material-symbols-outlined">book_2</span>
                <span>Course Catalog</span>
            </a>
            <a href="{{ route('student.learning') }}" class="sidebar-link active flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-black transition-all">
                <span class="material-symbols-outlined fill-1">school</span>
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
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-black text-slate-900">My Learning</h1>
            <button class="bg-primary text-white px-5 py-2.5 rounded-lg font-bold text-sm flex items-center gap-2 shadow-lg shadow-primary/20 hover:bg-primary-dark transition-all">
                <span class="material-symbols-outlined">class</span>
                Go to Classroom
            </button>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5">
                <div class="size-14 bg-blue-50 rounded-xl flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-3xl">pending_actions</span>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-slate-900">{{ $active_courses->count() }}</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Courses in Progress</p>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5">
                <div class="size-14 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                    <span class="material-symbols-outlined text-3xl">check_circle</span>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-slate-900">{{ $completed_courses->count() }}</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Completed</p>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5">
                <div class="size-14 bg-amber-50 rounded-xl flex items-center justify-center text-amber-600">
                    <span class="material-symbols-outlined text-3xl fill-1">workspace_premium</span>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-slate-900">{{ $certificates_count ?? 0 }}</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Certificates Earned</p>
                </div>
            </div>
        </div>

        <!-- Active Courses -->
        <div class="mb-12">
            <h2 class="text-xl font-bold text-slate-900 mb-6">Active Courses</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @forelse($active_courses as $enrollment)
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all group">
                    <div class="flex gap-5 mb-6">
                        <div class="size-16 rounded-xl bg-slate-100 shrink-0 bg-cover bg-center" style="background-image: url('{{ $enrollment->course->thumbnail ? asset('storage/'.$enrollment->course->thumbnail) : 'https://placehold.co/100x100' }}')"></div>
                        <div>
                            <h3 class="font-bold text-lg text-slate-900 leading-tight mb-1 group-hover:text-primary transition-colors">{{ $enrollment->course->title }}</h3>
                            <p class="text-sm text-slate-500">Current Lesson: {{ $enrollment->current_lesson ?? 'Introduction' }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-2 flex justify-between items-end">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Course Progress</span>
                        <span class="text-sm font-black text-primary">{{ $enrollment->progress ?? 0 }}%</span>
                    </div>
                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden mb-6">
                        <div class="h-full bg-primary rounded-full progress-bar" style="width: {{ $enrollment->progress ?? 0 }}%"></div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-400 font-medium">Last activity: {{ $enrollment->updated_at->diffForHumans() }}</span>
                        <a href="{{ route('student.course.learn', $enrollment->course_id) }}" class="bg-primary text-white px-6 py-2 rounded-lg text-sm font-bold hover:bg-primary-dark transition-colors flex items-center gap-2">
                            Resume
                            <span class="material-symbols-outlined text-lg">arrow_forward</span>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-dashed border-slate-200">
                    <div class="size-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                        <span class="material-symbols-outlined text-3xl">school</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">No active courses</h3>
                    <p class="text-slate-500 mb-6">You haven't started any courses yet.</p>
                    <a href="{{ route('student.catalog') }}" class="text-primary font-bold hover:underline">Browse Catalog</a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Completed Courses -->
        @if($completed_courses->count() > 0)
        <div>
            <h2 class="text-xl font-bold text-slate-900 mb-6">Completed Courses</h2>
            <div class="space-y-4">
                @foreach($completed_courses as $enrollment)
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-5">
                        <div class="size-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined">check_circle</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900">{{ $enrollment->course->title }}</h4>
                            <p class="text-xs text-slate-500 font-medium">Completed on {{ $enrollment->updated_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                         <button class="px-4 py-2 border border-slate-200 rounded-lg text-xs font-bold text-slate-600 hover:bg-slate-50 flex items-center gap-2 transition-colors">
                            <span class="material-symbols-outlined text-sm">download</span>
                            Certificate
                        </button>
                        <button class="size-8 flex items-center justify-center text-slate-400 hover:text-slate-600 rounded-full hover:bg-slate-50">
                            <span class="material-symbols-outlined">more_vert</span>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </main>
</div>
@endsection
