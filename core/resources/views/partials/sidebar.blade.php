@php
    $role = Auth::user()->role;
    $isInstructor = $role === 'instructor';
    $isAdmin = $role === 'admin';
    $isStudent = $role === 'student';
@endphp

<aside class="w-72 border-r border-[#dcdfe5] dark:border-gray-800 bg-white dark:bg-[#1a202c] flex flex-col h-full sticky top-[72px] z-20">
    <div class="p-8 flex flex-col h-full custom-scrollbar overflow-y-auto">
        <!-- Dashboard Header Info (Optional, can be role specific) -->
        <div class="mb-10 lg:hidden">
             <div class="flex items-center gap-3">
                <div class="bg-primary size-10 rounded-xl flex items-center justify-center text-accent shadow-lg">
                    <span class="material-symbols-outlined font-bold">church</span>
                </div>
                <div>
                    <h1 class="text-base font-black leading-tight text-primary dark:text-white">{{ config('app.name') }}</h1>
                    <p class="text-[10px] font-bold text-[#636f88] uppercase tracking-widest">{{ ucfirst($role) }} Panel</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 space-y-2">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 px-4">Main Menu</p>
            
            <!-- Dashboard -->
            <a href="{{ $isInstructor ? route('instructor.dashboard') : ($isAdmin ? route('home') : route('student.dashboard')) }}" 
               class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs('*.dashboard') || request()->routeIs('home') ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('*.dashboard') || request()->routeIs('home') ? 'filled-icon' : '' }}">dashboard</span>
                <span>Dashboard</span>
            </a>

            @if($isInstructor || $isAdmin)
                <!-- Courses (Instructor/Admin) -->
                <a href="{{ route('instructor.courses.index') }}" 
                   class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs('instructor.courses.*') ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('instructor.courses.*') ? 'filled-icon' : '' }}">book_2</span>
                    <span>Course Catalog</span>
                </a>

                <!-- Students -->
                <a href="{{ route('instructor.students.index') }}" 
                   class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs('instructor.students.*') ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('instructor.students.*') ? 'filled-icon' : '' }}">group</span>
                    <span>Student Body</span>
                </a>

                <!-- Quizzes -->
                <a href="{{ route('instructor.quizzes.index') }}" 
                   class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs('instructor.quizzes.*') ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('instructor.quizzes.*') ? 'filled-icon' : '' }}">quiz</span>
                    <span>Quiz Hub</span>
                </a>
            @endif

            @if($isStudent)
                <!-- Catalog -->
                <a href="{{ route('student.catalog') }}" 
                   class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs('student.catalog') ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined">explore</span>
                    <span>Browse Courses</span>
                </a>

                <!-- My Learning -->
                <a href="{{ route('student.learning') }}" 
                   class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs('student.learning') ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('student.learning') ? 'filled-icon' : '' }}">school</span>
                    <span>My Academy</span>
                </a>
            @endif

            <!-- Live Sessions / Meetings -->
            <a href="{{ route('meeting.index') }}" 
               class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs('meeting.*') ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('meeting.*') ? 'filled-icon' : '' }}">video_call</span>
                <span>Live Streams</span>
            </a>

            <!-- Library/Resources -->
            <a href="{{ route('library.index') }}" 
               class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs('library.*') ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('library.*') ? 'filled-icon' : '' }}">local_library</span>
                <span>Resource Library</span>
            </a>
        </nav>

        <div class="mt-auto pt-8 border-t border-slate-100">
            <div class="bg-[#f8f9fb] p-4 rounded-[1.5rem] border border-slate-100 shadow-sm group cursor-pointer hover:border-primary/20 transition-all">
                <div class="flex items-center gap-4">
                    <div class="size-12 rounded-2xl bg-white shadow-sm flex items-center justify-center text-primary font-black text-sm border border-slate-100 group-hover:bg-primary group-hover:text-white transition-all overflow-hidden">
                        @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/'.Auth::user()->profile_picture) }}" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-black text-slate-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ Auth::user()->role }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 mt-4">
                    <a href="{{ route('student.profile') }}" class="flex items-center justify-center py-2 bg-white rounded-xl text-[10px] font-black text-slate-500 hover:text-primary hover:shadow-sm border border-transparent hover:border-slate-100 transition-all">
                        PROFILE
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full py-2 bg-white rounded-xl text-[10px] font-black text-red-400 hover:text-red-600 hover:shadow-sm border border-transparent hover:border-red-50 transition-all text-center">
                            LOGOUT
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</aside>
