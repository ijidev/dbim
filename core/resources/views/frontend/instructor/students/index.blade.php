@extends('layouts.app')

@section('title', 'Student Body Management')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<style>
    body { font-family: 'Lexend', sans-serif; }
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .fill-1 { font-variation-settings: 'FILL' 1; }
</style>
@endpush

@section('content')
<div class="flex bg-[#f8fafc] min-h-screen">
    <!-- Sidebar -->
    <aside class="hidden lg:flex flex-col w-64 bg-white border-r border-gray-200 sticky top-16 h-[calc(100vh-64px)]">
        <div class="p-8 pb-4">
            <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-6">Instructor Menu</h2>
            <nav class="space-y-1">
                <a href="{{ route('instructor.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-primary hover:bg-slate-50 rounded-xl text-sm font-bold transition-all">
                    <span class="material-symbols-outlined text-lg">dashboard</span>
                    Dashboard
                </a>
               <a href="{{ route('courses.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-primary hover:bg-slate-50 rounded-xl text-sm font-bold transition-all">
                    <span class="material-symbols-outlined text-lg">book_2</span>
                    Courses
                </a>
                <a href="{{ route('instructor.students.index') }}" class="flex items-center gap-3 px-4 py-3 bg-primary text-white rounded-xl text-sm font-black">
                    <span class="material-symbols-outlined text-lg fill-1">group</span>
                    Students
                </a>
                <a href="{{ route('meeting.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-primary hover:bg-slate-50 rounded-xl text-sm font-bold transition-all">
                    <span class="material-symbols-outlined text-lg">video_call</span>
                    Live Sessions
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-primary hover:bg-slate-50 rounded-xl text-sm font-bold transition-all">
                    <span class="material-symbols-outlined text-lg">analytics</span>
                    Reports
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1">
        <!-- Header -->
        <header class="h-16 border-b border-gray-200 bg-white sticky top-16 z-10 flex items-center justify-between px-8">
            <h2 class="text-lg font-bold">Student Body Management</h2>
            <div class="flex items-center gap-4">
                <button class="p-2 rounded-lg bg-gray-100 text-gray-700 relative hover:bg-gray-200 transition-colors">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-2 right-2 size-2 bg-amber-500 rounded-full border-2 border-white"></span>
                </button>
                <a href="{{ route('courses.create') }}" class="flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-primary/90 transition-all shadow-sm">
                    <span class="material-symbols-outlined text-lg">person_add</span>
                    Enroll Student
                </a>
            </div>
        </header>

        <div class="p-8 max-w-7xl mx-auto">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Enrolled</p>
                        <div class="bg-primary/10 p-2 rounded-lg">
                            <span class="material-symbols-outlined text-primary">groups</span>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-900">{{ $total_enrolled }}</p>
                    <div class="mt-2 flex items-center gap-1.5 text-emerald-600 font-semibold text-xs">
                        <span class="material-symbols-outlined text-sm">trending_up</span> +5.2% from last month
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Avg. Course Progress</p>
                        <div class="bg-amber-500/10 p-2 rounded-lg">
                            <span class="material-symbols-outlined text-amber-600">auto_graph</span>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-900">{{ number_format($avg_progress, 1) }}%</p>
                    <div class="mt-2 w-full bg-gray-100 h-1 rounded-full">
                        <div class="bg-amber-500 h-1 rounded-full" style="width: {{ $avg_progress }}%"></div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Engagement Rate</p>
                        <div class="bg-emerald-50 p-2 rounded-lg">
                            <span class="material-symbols-outlined text-emerald-600">bolt</span>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-900">{{ $engagement_rate }}%</p>
                    <div class="mt-2 flex items-center gap-1.5 text-primary font-semibold text-xs">
                        <span class="material-symbols-outlined text-sm">check_circle</span> {{ $active_this_week }} active this week
                    </div>
                </div>
            </div>

            <!-- Student Table -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-200 flex flex-col gap-6">
                    <!-- Search and Actions -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="relative flex-1 max-w-md">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-xl">search</span>
                            <input 
                                type="text" 
                                id="search-input"
                                class="w-full bg-gray-50 border-gray-200 rounded-lg py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all outline-none" 
                                placeholder="Search student name or email..."
                                value="{{ request('search') }}"
                            />
                        </div>
                        <div class="flex items-center gap-2">
                            <button id="filter-toggle" class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-gray-50 transition-colors">
                                <span class="material-symbols-outlined text-lg">filter_list</span> Filters
                            </button>
                            <a href="{{ route('instructor.students.export', request()->query()) }}" class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-gray-50 transition-colors">
                                <span class="material-symbols-outlined text-lg">download</span> Export List
                            </a>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div id="filters" class="grid grid-cols-1 md:grid-cols-4 gap-4 {{ request()->hasAny(['course', 'status', 'progress']) ? '' : 'hidden' }}">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-tighter">Course</label>
                            <select id="course-filter" class="w-full bg-gray-50 border-gray-200 rounded-lg text-sm font-medium focus:ring-primary/20">
                                <option value="all" {{ request('course') == 'all' ? 'selected' : '' }}>All Courses</option>
                                @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ request('course') == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-tighter">Status</label>
                            <select id="status-filter" class="w-full bg-gray-50 border-gray-200 rounded-lg text-sm font-medium focus:ring-primary/20">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' :  '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-tighter">Progress Range</label>
                            <select id="progress-filter" class="w-full bg-gray-50 border-gray-200 rounded-lg text-sm font-medium focus:ring-primary/20">
                                <option value="all" {{ request('progress') == 'all' ? 'selected' : '' }}>Any Progress</option>
                                <option value="0-25" {{ request('progress') == '0-25' ? 'selected' : '' }}>0% - 25%</option>
                                <option value="26-50" {{ request('progress') == '26-50' ? 'selected' : '' }}>26% - 50%</option>
                                <option value="51-75" {{ request('progress') == '51-75' ? 'selected' : '' }}>51% - 75%</option>
                                <option value="76-100" {{ request('progress') == '76-100' ? 'selected' : '' }}>76% - 100%</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button id="clear-filters" class="w-full py-2 text-primary font-bold text-sm hover:underline">Clear all filters</button>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-widest border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-bold">Student Name</th>
                                <th class="px-6 py-4 font-bold">Course Enrolled</th>
                                <th class="px-6 py-4 font-bold">Join Date</th>
                                <th class="px-6 py-4 font-bold">Last Active</th>
                                <th class="px-6 py-4 font-bold">Progress</th>
                                <th class="px-6 py-4 font-bold text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($students as $student)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="size-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-black text-xs overflow-hidden">
                                            @if($student->user->profile_picture)
                                                <img src="{{ asset('storage/'.$student->user->profile_picture) }}" class="w-full h-full object-cover" alt="{{ $student->user->name }}" />
                                            @else
                                                {{ strtoupper(substr($student->user->name, 0, 2)) }}
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-bold text-sm group-hover:text-primary transition-colors">{{ $student->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $student->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium">{{ $student->course->title }}</span>
                                        <span class="text-[10px] text-amber-600 font-bold uppercase">{{ $student->course->category ?? 'General' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $student->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @if($student->last_access_at)
                                        @php
                                            $daysDiff = now()->diffInDays($student->last_access_at);
                                            $isInactive = $daysDiff > 7;
                                        @endphp
                                        @if($isInactive)
                                            <span class="text-amber-600 font-medium">Inactive ({{ $daysDiff }}d)</span>
                                        @else
                                            <div class="flex items-center gap-1.5">
                                                <span class="size-2 rounded-full bg-emerald-500"></span>
                                                {{ $student->last_access_at->diffForHumans() }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-gray-400">Never</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 min-w-[180px]">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-primary rounded-full" style="width: {{ $student->progress_percentage }}%;"></div>
                                        </div>
                                        <span class="text-xs font-bold w-8">{{ number_format($student->progress_percentage) }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="mailto:{{ $student->user->email }}" class="p-2 hover:bg-primary/10 text-gray-500 hover:text-primary rounded-lg transition-colors" title="Send Message">
                                            <span class="material-symbols-outlined text-lg">mail</span>
                                        </a>
                                        <a href="{{ route('student.profile') }}" class="p-2 hover:bg-primary/10 text-gray-500 hover:text-primary rounded-lg transition-colors" title="View Profile">
                                            <span class="material-symbols-outlined text-lg">visibility</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                    <div class="flex flex-col items-center gap-3">
                                        <span class="material-symbols-outlined text-5xl text-gray-300">group_off</span>
                                        <p class="font-medium">No students found</p>
                                        <p class="text-sm">Try adjusting your search or filters</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($students->hasPages())
                <div class="p-6 border-t border-gray-200 flex items-center justify-between">
                    <p class="text-sm text-gray-500">
                        Showing <span class="font-bold text-slate-900">{{ $students->firstItem() }} - {{ $students->lastItem() }}</span> of <span class="font-bold text-slate-900">{{ $students->total() }}</span> students
                    </p>
                    <div class="flex items-center gap-2">
                        @if($students->onFirstPage())
                            <button class="size-8 flex items-center justify-center rounded border border-gray-200 text-gray-400 cursor-not-allowed" disabled>
                                <span class="material-symbols-outlined text-lg">chevron_left</span>
                            </button>
                        @else
                            <a href="{{ $students->previousPageUrl() }}" class="size-8 flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 text-gray-600">
                                <span class="material-symbols-outlined text-lg">chevron_left</span>
                            </a>
                        @endif

                        @foreach($students->getUrlRange(1, min(3, $students->lastPage())) as $page => $url)
                            <a href="{{ $url }}" class="size-8 flex items-center justify-center rounded {{ $page == $students->currentPage() ? 'bg-primary text-white' : 'border border-gray-200 hover:bg-gray-50 text-gray-600' }} font-bold text-sm">
                                {{ $page }}
                            </a>
                        @endforeach

                        @if($students->hasMorePages())
                            <a href="{{ $students->nextPageUrl() }}" class="size-8 flex items-center justify-center rounded border border-gray-200 hover:bg-gray-50 text-gray-600">
                                <span class="material-symbols-outlined text-lg">chevron_right</span>
                            </a>
                        @else
                            <button class="size-8 flex items-center justify-center rounded border border-gray-200 text-gray-400 cursor-not-allowed" disabled>
                                <span class="material-symbols-outlined text-lg">chevron_right</span>
                            </button>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script>
    // Filter toggle
    document.getElementById('filter-toggle').addEventListener('click', function() {
        document.getElementById('filters').classList.toggle('hidden');
    });
    
    // Live search
    let searchTimeout;
    document.getElementById('search-input').addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            applyFilters();
        }, 500);
    });
    
    // Filter selects
    document.querySelectorAll('#course-filter, #status-filter, #progress-filter').forEach(select => {
        select.addEventListener('change', applyFilters);
    });
    
    // Clear filters
    document.getElementById('clear-filters').addEventListener('click', function() {
        window.location.href = '{{ route("instructor.students.index") }}';
    });
    
    function applyFilters() {
        const params = new URLSearchParams();
        const search = document.getElementById('search-input').value;
        const course = document.getElementById('course-filter').value;
        const status = document.getElementById('status-filter').value;
        const progress = document.getElementById('progress-filter').value;
        
        if (search) params.set('search', search);
        if (course && course !== 'all') params.set('course', course);
        if (status && status !== 'all') params.set('status', status);
        if (progress && progress !== 'all') params.set('progress', progress);
        
        window.location.href = '{{ route("instructor.students.index") }}?' + params.toString();
    }
</script>
@endpush
@endsection
