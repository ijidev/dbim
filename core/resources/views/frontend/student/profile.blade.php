@extends('layouts.app')

@section('title', 'My Profile - Grace LMS')

@push('styles')
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .fill-1 {
        font-variation-settings: 'FILL' 1;
    }
    
    .profile-header {
        background: linear-gradient(135deg, #0a192f 0%, #112240 100%);
        padding: 40px;
        border-radius: 24px;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .profile-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 100%;
        background: radial-gradient(circle, rgba(23, 84, 207, 0.2) 0%, transparent 70%);
        pointer-events: none;
    }
    
    .stat-card {
        background: white;
        padding: 24px;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
</style>
@endpush

@section('content')
<div class="flex h-[calc(100vh-64px)] overflow-hidden bg-slate-50">
    <!-- Sidebar -->
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
            <a href="{{ route('student.learning') }}" class="sidebar-link flex items-center gap-4 px-4 py-3 text-slate-500 hover:text-primary hover:bg-slate-50 rounded-xl text-sm font-bold transition-all">
                <span class="material-symbols-outlined">school</span>
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
        <!-- Profile Header -->
        <!-- Profile Header -->
        <div class="profile-header mb-8 flex flex-col md:flex-row items-center gap-8 text-center md:text-left relative overflow-hidden">
            <div class="relative group shrink-0">
                <div class="w-32 h-32 rounded-full bg-white/10 flex items-center justify-center text-white font-black text-3xl border-4 border-white/20 shadow-xl overflow-hidden backdrop-blur-sm">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/'.Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                    @else
                        {{ substr(Auth::user()->name, 0, 2) }}
                    @endif
                </div>
                <!-- Edit Avatar Overlay -->
                <a href="{{ route('student.settings') }}" class="absolute bottom-1 right-1 w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center shadow-lg hover:bg-white hover:text-primary transition-all duration-300" title="Change Avatar">
                    <span class="material-symbols-outlined text-sm">edit</span>
                </a>
            </div>
            
            <div class="flex-1 min-w-0 z-10">
                <h1 class="text-3xl md:text-4xl font-black tracking-tight mb-2 text-white drop-shadow-sm">{{ Auth::user()->name }}</h1>
                <p class="text-blue-100 font-medium text-lg mb-6 flex items-center justify-center md:justify-start gap-2">
                    <span class="material-symbols-outlined text-xl">mail</span>
                    {{ Auth::user()->email }}
                </p>
                
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                    <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-lg backdrop-blur-md border border-white/10">
                        <span class="material-symbols-outlined text-blue-300 text-lg">calendar_month</span>
                         <span class="text-sm font-bold text-white/90">Joined {{ Auth::user()->created_at->format('M Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2 bg-emerald-500/20 px-4 py-2 rounded-lg backdrop-blur-md border border-emerald-500/20">
                        <span class="material-symbols-outlined text-emerald-400 text-lg">verified</span>
                         <span class="text-sm font-bold text-emerald-100">Verified Student</span>
                    </div>
                </div>
            </div>
            
            <div class="z-10 mt-4 md:mt-0">
                <a href="{{ route('student.settings') }}" class="group bg-white text-slate-900 hover:bg-blue-50 px-6 py-3 rounded-xl font-bold flex items-center gap-3 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                    <span class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">edit_square</span>
                    <span>Edit Profile</span>
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="stat-card">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-2xl">school</span>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-slate-900">{{ $enrollments->count() }}</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Enrolled</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <span class="material-symbols-outlined text-2xl">check_circle</span>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-slate-900">{{ $enrollments->where('progress', 100)->count() }}</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Completed</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                    <span class="material-symbols-outlined text-2xl fill-1">military_tech</span>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-slate-900">0</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Certificates</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600">
                    <span class="material-symbols-outlined text-2xl">timer</span>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-slate-900">{{ $enrollments->sum('progress') / 100 * 2 }}h</h3> <!-- Mock calculation -->
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Learning Time</p>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Bio -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Bio/About -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">person</span>
                            About Me
                        </h2>
                        @if(!Auth::user()->bio)
                            <a href="{{ route('student.settings') }}" class="text-primary text-sm font-bold hover:underline">Add Bio</a>
                        @endif
                    </div>
                    
                    @if(Auth::user()->bio)
                        <div class="prose text-slate-600">
                            {{ Auth::user()->bio }}
                        </div>
                    @else
                        <div class="text-center py-8 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            <p class="text-slate-500 mb-2">Tell us about yourself!</p>
                            <p class="text-xs text-slate-400">Add a bio to connect with other students and instructors.</p>
                        </div>
                    @endif
                </div>

                <!-- Recent Activity (Mock) -->
                <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
                    <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">history</span>
                        Recent Activity
                    </h2>
                    
                    <div class="space-y-6">
                        @foreach($enrollments->take(3) as $enrollment)
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-slate-500 text-lg">play_arrow</span>
                            </div>
                            <div>
                                <p class="text-slate-900 font-bold text-sm">Resumed <span class="text-primary">{{ $enrollment->course->title }}</span></p>
                                <p class="text-slate-500 text-xs mt-1">{{ $enrollment->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                        
                        @if($enrollments->count() == 0)
                        <p class="text-slate-500 text-center py-4">No recent activity.</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Right: Account Details -->
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Account Details</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-2 border-b border-slate-50">
                            <span class="text-slate-500 text-sm">Status</span>
                            <span class="bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded text-xs font-bold">Active</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-slate-50">
                            <span class="text-slate-500 text-sm">Role</span>
                            <span class="capitalize text-slate-900 font-medium text-sm">{{ Auth::user()->role }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-slate-50">
                            <span class="text-slate-500 text-sm">Language</span>
                            <span class="text-slate-900 font-medium text-sm">English (US)</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-slate-500 text-sm">Timezone</span>
                            <span class="text-slate-900 font-medium text-sm">UTC</span> <!-- Should come from user setting -->
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-primary to-blue-700 p-6 rounded-2xl text-white shadow-lg">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-2xl">stars</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Upgrade to Pro</h3>
                    <p class="text-white/80 text-sm mb-6">Unlock all courses and get unlimited access to mentorship sessions.</p>
                    <button class="w-full bg-white text-primary font-bold py-3 rounded-xl hover:bg-slate-100 transition-colors">
                        View Plans
                    </button>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
