@php
    $role = Auth::user()->role;
    $isInstructor = $role === 'instructor';
    $isAdmin = $role === 'admin';
    $isStudent = $role === 'student';
@endphp

{{-- Mobile Sidebar Toggle Button (FAB) --}}
<button onclick="openMobileSidebar()" id="mobile-sidebar-toggle" class="lg:hidden fixed bottom-6 left-6 z-[60] size-14 bg-primary text-white rounded-2xl shadow-2xl shadow-primary/30 flex items-center justify-center hover:scale-110 active:scale-95 transition-all">
    <span class="material-symbols-outlined text-2xl">menu</span>
</button>

{{-- Sidebar Overlay --}}
<div id="sidebar-overlay" onclick="closeMobileSidebar()" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-[70] lg:hidden transition-opacity"></div>

{{-- Sidebar --}}
<aside id="mobile-sidebar" class="hidden lg:flex w-72 border-r border-[#dcdfe5] dark:border-gray-800 bg-white dark:bg-[#1a202c] flex-col h-full sticky z-[80] max-lg:fixed max-lg:top-0 max-lg:left-0 max-lg:h-full max-lg:shadow-2xl max-lg:-translate-x-full max-lg:transition-transform max-lg:duration-300">
    <div class="p-8 flex flex-col h-full custom-scrollbar overflow-y-auto">
        <!-- Mobile Close + Logo -->
        <div class="mb-10">
             <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-primary size-10 rounded-xl flex items-center justify-center text-accent shadow-lg">
                        <span class="material-symbols-outlined font-bold">church</span>
                    </div>
                    <div>
                        <h1 class="text-base font-black leading-tight text-primary dark:text-white">{{ config('app.name') }}</h1>
                        <p class="text-[10px] font-bold text-[#636f88] uppercase tracking-widest">{{ ucfirst($role) }} Panel</p>
                    </div>
                </div>
                <button onclick="closeMobileSidebar()" class="lg:hidden size-10 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
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

                <!-- My Library -->
                <a href="{{ route('student.library.index') }}" 
                   class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs('student.library.*') ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('student.library.*') ? 'filled-icon' : '' }}">local_library</span>
                    <span>My Library</span>
                </a>
            @endif

            <!-- Live Sessions / Meetings -->
            <a href="{{ route('meeting.index') }}" 
               class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs('meeting.*') ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('meeting.*') ? 'filled-icon' : '' }}">video_call</span>
                <span>Live Streams</span>
            </a>

            <!-- Library/Resources -->
            @if($isInstructor)
                <a href="{{ route('instructor.library.index') }}" 
                   class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs('instructor.library.*') ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('instructor.library.*') ? 'filled-icon' : '' }}">local_library</span>
                    <span>Resource Library</span>
                </a>
            @else
                <a href="{{ route('library.index') }}" 
                   class="flex items-center gap-4 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all {{ request()->routeIs('library.*') ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('library.*') ? 'filled-icon' : '' }}">local_library</span>
                    <span>Resource Library</span>
                </a>
            @endif
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

<script>
    function openMobileSidebar() {
        const sidebar = document.getElementById('mobile-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggle = document.getElementById('mobile-sidebar-toggle');

        sidebar.classList.remove('hidden');
        overlay.classList.remove('hidden');
        toggle.classList.add('hidden');

        // Trigger animation after display
        requestAnimationFrame(() => {
            sidebar.classList.remove('max-lg:-translate-x-full');
            sidebar.classList.add('max-lg:translate-x-0');
            overlay.classList.add('opacity-100');
        });
    }

    function closeMobileSidebar() {
        const sidebar = document.getElementById('mobile-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggle = document.getElementById('mobile-sidebar-toggle');

        sidebar.classList.remove('max-lg:translate-x-0');
        sidebar.classList.add('max-lg:-translate-x-full');
        overlay.classList.remove('opacity-100');

        setTimeout(() => {
            sidebar.classList.add('hidden');
            overlay.classList.add('hidden');
            toggle.classList.remove('hidden');
        }, 300);
    }
</script>
