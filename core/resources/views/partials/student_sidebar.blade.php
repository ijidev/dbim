<aside class="hidden lg:flex w-72 flex-col border-r border-slate-200 bg-white h-[calc(100vh-72px)] sticky top-[72px] shrink-0">
    <nav class="flex-1 px-6 py-8 space-y-2">
        <a href="{{ route('student.dashboard') }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-black transition-all {{ request()->routeIs('student.dashboard') ? 'bg-primary/10 text-primary' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">
            <span class="material-symbols-outlined {{ request()->routeIs('student.dashboard') ? 'fill-1' : '' }}">dashboard</span>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('student.catalog') }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-bold transition-all {{ request()->routeIs('student.catalog') ? 'bg-primary/10 text-primary' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">
            <span class="material-symbols-outlined">book_2</span>
            <span>Course Catalog</span>
        </a>
        <a href="{{ route('student.learning') }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-bold transition-all {{ request()->routeIs('student.learning') ? 'bg-primary/10 text-primary' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">
            <span class="material-symbols-outlined">school</span>
            <span>My Learning</span>
        </a>
        <a href="{{ route('student.bookings') }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-bold transition-all {{ request()->routeIs('student.bookings') ? 'bg-primary/10 text-primary' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">
            <span class="material-symbols-outlined">calendar_today</span>
            <span>My Meetings</span>
        </a>
        <a href="{{ route('calendar') }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-xl text-sm font-bold transition-all {{ request()->routeIs('calendar') ? 'bg-primary/10 text-primary' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">
            <span class="material-symbols-outlined">groups</span>
            <span>Community</span>
        </a>
    </nav>
    <div class="p-6 border-t border-slate-100">
        <a href="{{ route('student.profile') }}" class="flex items-center gap-4 p-2 hover:bg-slate-50 rounded-xl transition-colors group">
            <div class="size-11 rounded-full bg-primary/10 flex items-center justify-center text-primary font-black text-xs border border-primary/20 group-hover:bg-primary group-hover:text-white transition-colors">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-black text-slate-900 group-hover:text-primary transition-colors truncate">{{ Auth::user()->name }}</p>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">View Profile</p>
            </div>
        </a>
    </div>
</aside>
