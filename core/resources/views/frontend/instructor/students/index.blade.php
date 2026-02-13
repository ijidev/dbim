@extends('layouts.instructor')

@section('title', 'Student Management')
@section('page_title', 'Student Body Management')

@section('instructor_content')
<div class="space-y-10">
    <!-- Header Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[2rem] border border-[#dcdfe5] shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Total Enrolled</p>
                <div class="bg-primary/10 p-2.5 rounded-xl text-primary">
                    <span class="material-symbols-outlined font-bold">groups</span>
                </div>
            </div>
            <h3 class="text-3xl font-black text-slate-900">{{ $students->total() }}</h3>
            <p class="text-[10px] font-bold text-emerald-600 mt-2 flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">trending_up</span>
                Active community members
            </p>
        </div>

        <div class="bg-white p-8 rounded-[2rem] border border-[#dcdfe5] shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Avg. Progress</p>
                <div class="bg-amber-50 p-2.5 rounded-xl text-amber-600">
                    <span class="material-symbols-outlined font-bold">auto_graph</span>
                </div>
            </div>
            <h3 class="text-3xl font-black text-slate-900">
                @php
                    $avgProgress = $students->count() > 0 ? $students->avg('progress_percentage') : 0;
                @endphp
                {{ number_format($avgProgress, 1) }}%
            </h3>
            <div class="mt-4 w-full bg-slate-50 h-1.5 rounded-full overflow-hidden">
                <div class="bg-amber-500 h-full rounded-full" style="width: {{ $avgProgress }}%"></div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2rem] border border-[#dcdfe5] shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Active Portals</p>
                <div class="bg-blue-50 p-2.5 rounded-xl text-blue-600">
                    <span class="material-symbols-outlined font-bold">bolt</span>
                </div>
            </div>
            <h3 class="text-3xl font-black text-slate-900">{{ $students->where('expires_at', '>', now())->count() }}</h3>
            <p class="text-[10px] font-bold text-primary mt-2 flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">check_circle</span>
                Valid subscriptions
            </p>
        </div>
    </div>

    <!-- Student Table Card -->
    <div class="bg-white border border-[#dcdfe5] rounded-[2.5rem] shadow-sm overflow-hidden">
        <!-- Table Controls -->
        <div class="p-8 border-b border-slate-50 space-y-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <form action="{{ route('instructor.students.index') }}" method="GET" class="relative flex-1 max-w-md group">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary transition-colors">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="w-full bg-[#f8f9fb] border-slate-100 rounded-2xl py-3.5 pl-12 pr-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-primary/5 focus:border-primary/20 transition-all outline-none" 
                           placeholder="Search by name or email...">
                </form>
                <div class="flex items-center gap-3">
                    <a href="{{ route('instructor.students.export') }}" class="h-12 px-6 border border-slate-100 rounded-xl text-xs font-black text-slate-600 hover:bg-slate-50 flex items-center gap-2 transition-all">
                        <span class="material-symbols-outlined text-lg">download</span>
                        EXPORT CSV
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-2">Filter by Course</label>
                    <select class="w-full bg-[#f8f9fb] border-slate-100 rounded-xl text-xs font-black text-slate-600 focus:ring-primary/10">
                        <option>All Courses</option>
                        {{-- Add actual course options here if needed --}}
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-2">Portal Status</label>
                    <select class="w-full bg-[#f8f9fb] border-slate-100 rounded-xl text-xs font-black text-slate-600 focus:ring-primary/10">
                        <option>All Members</option>
                        <option>Active Only</option>
                        <option>Expired Only</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button class="w-full h-11 text-[10px] font-black text-primary hover:bg-primary/5 rounded-xl transition-all">
                        CLEAR ALL FILTERS
                    </button>
                </div>
            </div>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-[#f8f9fb] border-b border-slate-50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Student Information</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Enrolled Course</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Enrollment Date</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Learning Progress</th>
                        <th class="px-8 py-5 text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($students as $student)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="size-12 rounded-2xl bg-blue-100 text-primary flex items-center justify-center font-black text-xs border border-white shadow-sm overflow-hidden group-hover:scale-105 transition-all">
                                    @if($student->user->profile_picture)
                                        <img src="{{ asset('storage/'.$student->user->profile_picture) }}" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr($student->user->name, 0, 2)) }}
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-black text-slate-900 group-hover:text-primary transition-colors truncate">{{ $student->user->name }}</p>
                                    <p class="text-[11px] font-bold text-slate-400 truncate mt-0.5">{{ $student->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-slate-700 leading-tight">{{ $student->course->title }}</span>
                                <span class="text-[10px] font-black text-accent uppercase tracking-widest mt-1">THEOLOGY</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-xs font-black text-slate-500">{{ $student->created_at->format('M d, Y') }}</p>
                        </td>
                        <td class="px-8 py-6 min-w-[200px]">
                            <div class="flex items-center gap-3">
                                <div class="flex-1 h-2 bg-slate-50 rounded-full overflow-hidden">
                                    <div class="h-full bg-primary rounded-full transition-all duration-1000" style="width: {{ $student->progress_percentage }}%"></div>
                                </div>
                                <span class="text-[11px] font-black text-slate-900 w-8">{{ round($student->progress_percentage) }}%</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-center gap-3">
                                <a href="mailto:{{ $student->user->email }}" class="p-2.5 bg-slate-50 text-slate-400 hover:text-primary hover:bg-primary/10 rounded-xl transition-all" title="Send Email">
                                    <span class="material-symbols-outlined text-lg">mail</span>
                                </a>
                                <a href="{{ route('instructor.students.show', $student->user->id) }}" class="p-2.5 bg-slate-50 text-slate-400 hover:text-primary hover:bg-primary/10 rounded-xl transition-all" title="View Profile">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="size-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 mx-auto mb-6">
                                <span class="material-symbols-outlined text-4xl">group_off</span>
                            </div>
                            <h3 class="text-lg font-black text-slate-900">No students found</h3>
                            <p class="text-sm text-slate-500 mt-2">Try adjusting your search or filters to find what you're looking for.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-8 border-t border-slate-50 bg-[#f8f9fb]">
            {{ $students->links() }}
        </div>
    </div>
</div>
@endsection
