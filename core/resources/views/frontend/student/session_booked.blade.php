@extends('layouts.app')

@section('title', 'Session Confirmed - Grace LMS')

@push('styles')
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .success-gradient {
        background: radial-gradient(circle at center, rgba(184, 134, 11, 0.1) 0%, transparent 70%);
    }
    
    .profile-sidebar {
        width: 260px;
        background: white;
        border-right: 1px solid #e5e7eb;
        position: sticky;
        top: 72px;
        height: calc(100vh - 72px);
        display: none;
    }
    
    @media (min-width: 1024px) {
        .profile-sidebar {
            display: flex;
            flex-direction: column;
        }
    }
    
    .nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        color: #64748b;
        transition: all 0.2s;
    }
    
    .nav-item:hover {
        background: #f1f5f9;
        color: var(--primary);
    }
    
    .nav-item.active {
        background: rgba(23, 84, 207, 0.1);
        color: var(--primary);
    }
</style>
@endpush

@section('content')
<div class="flex min-h-screen bg-[#f6f6f8]">
    <!-- Sidebar -->
    <aside class="profile-sidebar">
        <div class="p-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-white shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined">school</span>
                </div>
                <div>
                    <h1 class="text-base font-bold leading-tight">DBIM Academy</h1>
                    <p class="text-slate-400 text-xs uppercase tracking-wider">Spiritual Growth</p>
                </div>
            </div>
        </div>
        
        <nav class="flex-1 px-4 space-y-1">
            <a href="{{ route('student.dashboard') }}" class="nav-item">
                <span class="material-symbols-outlined">dashboard</span>
                Dashboard
            </a>
            <a href="{{ route('student.catalog') }}" class="nav-item">
                <span class="material-symbols-outlined">book_2</span>
                Course Catalog
            </a>
            <a href="{{ route('student.dashboard') }}" class="nav-item">
                <span class="material-symbols-outlined">school</span>
                My Learning
            </a>
            <a href="{{ route('student.catalog') }}" class="nav-item">
                <span class="material-symbols-outlined">groups</span>
                Instructors
            </a>
        </nav>
        
        <div class="p-4 border-t border-slate-200">
            <div class="flex items-center gap-3 p-2">
                <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary font-bold text-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-400">Member since {{ Auth::user()->created_at->format('Y') }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <div class="max-w-3xl mx-auto px-6 py-12 lg:py-20">
            <div class="text-center mb-12 relative">
                <div class="success-gradient absolute inset-0 -top-20 -z-10"></div>
                <div class="inline-flex items-center justify-center size-24 bg-[#b8860b]/10 rounded-full mb-6">
                    <div class="size-16 bg-[#b8860b] text-white rounded-full flex items-center justify-center shadow-xl shadow-[#b8860b]/20">
                        <span class="material-symbols-outlined text-4xl font-bold">check_circle</span>
                    </div>
                </div>
                <h1 class="text-4xl font-black text-[#0a192f] mb-2">Your Session is Confirmed!</h1>
                <p class="text-lg text-gray-500">We've sent a confirmation email to {{ Auth::user()->email }}</p>
            </div>

            <div class="bg-white rounded-3xl shadow-xl shadow-[#0a192f]/5 border border-gray-100 overflow-hidden mb-8">
                <div class="p-8">
                    @if(isset($meeting))
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10 pb-10 border-b border-gray-100">
                        <div class="flex flex-col gap-1">
                            <p class="text-xs font-bold uppercase tracking-widest text-[#b8860b]">Date</p>
                            <p class="text-xl font-bold text-[#0a192f]">{{ \Carbon\Carbon::parse($meeting->scheduled_at)->format('l, M d') }}</p>
                            <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($meeting->scheduled_at)->format('Y') }}</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="text-xs font-bold uppercase tracking-widest text-[#b8860b]">Time</p>
                            <p class="text-xl font-bold text-[#0a192f]">{{ \Carbon\Carbon::parse($meeting->scheduled_at)->format('g:i A') }}</p>
                            <p class="text-sm text-gray-500">{{ config('app.timezone') }}</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="text-xs font-bold uppercase tracking-widest text-[#b8860b]">Mentor</p>
                            <div class="flex items-center gap-3">
                                <div class="size-10 rounded-full bg-cover bg-center border border-gray-200" 
                                     style="background-image: url('{{ $meeting->host->avatar ? asset('storage/'.$meeting->host->avatar) : 'https://placehold.co/100x100?text='.substr($meeting->host->name,0,1) }}');">
                                </div>
                                <div>
                                    <p class="text-base font-bold text-[#0a192f] leading-tight">{{ $meeting->host->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $meeting->host->bio ?? 'Instructor' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <!-- Fallback if no meeting data -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10 pb-10 border-b border-gray-100">
                         <div class="flex flex-col gap-1">
                            <p class="text-xs font-bold uppercase tracking-widest text-[#b8860b]">Date</p>
                            <p class="text-xl font-bold text-[#0a192f]">Thursday, Oct 31</p>
                            <p class="text-sm text-gray-500">2024</p>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="text-xs font-bold uppercase tracking-widest text-[#b8860b]">Time</p>
                            <p class="text-xl font-bold text-[#0a192f]">2:00 PM - 3:00 PM</p>
                            <p class="text-sm text-gray-500">EST</p>
                        </div>
                    </div>
                    @endif

                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                                <div class="flex items-center gap-4">
                                    <div class="size-12 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                                        <span class="material-symbols-outlined text-2xl">video_call</span>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-[#0a192f]">Video Call Link</h3>
                                        <p class="text-sm text-gray-500">Session via Grace Connect Video</p>
                                    </div>
                                </div>
                                @if(isset($meeting->room_code))
                                <a href="{{ route('meeting.room', $meeting->room_code) }}" class="w-full md:w-auto bg-primary text-white px-8 py-3.5 rounded-xl font-bold flex items-center justify-center gap-2 group transition-all hover:bg-primary/90">
                                    <span class="material-symbols-outlined">link</span>
                                    Join Meeting Link
                                </a>
                                @else
                                <button class="w-full md:w-auto bg-gray-200 text-gray-400 px-8 py-3.5 rounded-xl font-bold cursor-not-allowed flex items-center justify-center gap-2 group transition-all">
                                    <span class="material-symbols-outlined">link</span>
                                    Join Meeting Link
                                    <span class="text-xs font-medium bg-gray-300 px-2 py-0.5 rounded ml-2">Active soon</span>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8">
                        <button class="flex items-center justify-center gap-2 px-4 py-3 border border-gray-200 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">
                            <img alt="Google" class="size-4" src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Google_Calendar_icon_%282020%29.svg"/>
                            Google Calendar
                        </button>
                        <button class="flex items-center justify-center gap-2 px-4 py-3 border border-gray-200 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">
                            <span class="material-symbols-outlined text-lg text-blue-600">calendar_month</span>
                            Add to Outlook
                        </button>
                        <button class="flex items-center justify-center gap-2 px-4 py-3 border border-gray-200 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">
                            <span class="material-symbols-outlined text-lg">download</span>
                            Download Receipt
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-[#b8860b]/5 border border-[#b8860b]/10 rounded-2xl p-8">
                <h3 class="text-[#0a192f] font-bold text-lg flex items-center gap-2 mb-6">
                    <span class="material-symbols-outlined text-[#b8860b]">lightbulb</span>
                    Preparation Tips
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                    <div class="flex gap-3">
                        <span class="material-symbols-outlined text-[#b8860b] text-sm mt-1">check_circle</span>
                        <p class="text-sm text-[#636f88]">Prepare 2-3 specific questions about your ministry challenges.</p>
                    </div>
                    <div class="flex gap-3">
                        <span class="material-symbols-outlined text-[#b8860b] text-sm mt-1">check_circle</span>
                        <p class="text-sm text-[#636f88]">Find a quiet space with a stable internet connection for the video call.</p>
                    </div>
                    <div class="flex gap-3">
                        <span class="material-symbols-outlined text-[#b8860b] text-sm mt-1">check_circle</span>
                        <p class="text-sm text-[#636f88]">Have a notebook ready to capture key insights and next steps.</p>
                    </div>
                    <div class="flex gap-3">
                        <span class="material-symbols-outlined text-[#b8860b] text-sm mt-1">check_circle</span>
                        <p class="text-sm text-[#636f88]">Review instructor's materials for context.</p>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                @if(isset($meeting->host))
                <a class="text-primary font-bold text-sm hover:underline inline-flex items-center gap-2" href="{{ route('instructor.profile', $meeting->host->id) }}">
                    <span class="material-symbols-outlined text-lg">arrow_back</span>
                    Back to Instructor Profile
                </a>
                @else
                <a class="text-primary font-bold text-sm hover:underline inline-flex items-center gap-2" href="{{ route('student.catalog') }}">
                    <span class="material-symbols-outlined text-lg">arrow_back</span>
                    Back to Catalog
                </a>
                @endif
            </div>
        </div>
    </main>
</div>
@endsection
