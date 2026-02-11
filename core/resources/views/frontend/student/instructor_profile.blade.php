@extends('layouts.app')

@section('title', $instructor->name . ' - Instructor Profile')

@push('styles')
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
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
    
    .hero-section {
        background: linear-gradient(135deg, #0a192f 0%, #1e3a5f 100%);
        padding: 48px 32px;
        position: relative;
    }
    
    .hero-overlay {
        background: linear-gradient(to top, rgba(10, 25, 47, 0.95) 0%, rgba(10, 25, 47, 0.4) 100%);
    }
    
    .profile-avatar {
        width: 140px;
        height: 140px;
        border-radius: 16px;
        border: 4px solid white;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    .profile-badge {
        background: rgba(184, 134, 11, 0.2);
        color: #b8860b;
        border: 1px solid rgba(184, 134, 11, 0.3);
        padding: 6px 12px;
        border-radius: 9999px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .online-indicator {
        position: absolute;
        bottom: -6px;
        right: -6px;
        width: 32px;
        height: 32px;
        background: #22c55e;
        border-radius: 50%;
        border: 4px solid #0a192f;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .stat-card {
        background: #f8fafc;
        padding: 16px;
        border-radius: 12px;
        text-align: center;
        border: 1px solid #f1f5f9;
    }
    
    .session-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        transition: all 0.2s;
    }
    
    @media (min-width: 640px) {
        .session-card {
            flex-direction: row;
        }
    }
    
    .session-card:hover {
        border-color: rgba(23, 84, 207, 0.3);
    }
    
    .book-item {
        display: flex;
        gap: 16px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .book-item:hover .book-title {
        color: var(--primary);
    }
    
    .mentor-cta {
        background: linear-gradient(135deg, var(--primary) 0%, #0a192f 100%);
        border-radius: 16px;
        padding: 24px;
        color: white;
    }
    
    .booking-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #e5e7eb;
    }
    
    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        font-family: inherit;
        transition: all 0.2s;
    }
    
    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(23, 84, 207, 0.1);
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
            <a href="{{ route('student.learning') }}" class="nav-item">
                <span class="material-symbols-outlined">school</span>
                My Learning
            </a>
            <div class="nav-item active">
                <span class="material-symbols-outlined">groups</span>
                Instructors
            </div>
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
    
    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center md:items-end gap-8">
                <!-- Avatar -->
                <div class="relative">
                    <img src="{{ $instructor->avatar_url }}" alt="{{ $instructor->name }}" class="profile-avatar object-cover">
                    <div class="online-indicator">
                        <span class="material-symbols-outlined text-sm">videocam</span>
                    </div>
                </div>
                
                <!-- Info -->
                <div class="flex-1 text-center md:text-left mb-2">
                    <div class="flex flex-col md:flex-row md:items-center gap-3 mb-2 justify-center md:justify-start">
                        <h1 class="text-3xl md:text-4xl font-black text-white">{{ $instructor->name }}</h1>
                        <span class="profile-badge w-fit mx-auto md:mx-0">{{ $instructor->title ?? 'Instructor' }}</span>
                    </div>
                    <p class="text-gray-400 text-lg max-w-2xl mx-auto md:mx-0">
                        {{ $instructor->bio ?? 'Empowering leaders through biblical wisdom and practical theology. Specializing in community building and servant leadership.' }}
                    </p>
                    <div class="flex items-center justify-center md:justify-start gap-4 mt-4 text-sm text-gray-400">
                        @if($instructor->location)
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[#b8860b] text-lg">location_on</span>
                            {{ $instructor->location }}
                        </div>
                        @endif
                        @if($instructor->website)
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[#b8860b] text-lg">language</span>
                            <a href="{{ $instructor->website }}" target="_blank" class="hover:text-white">{{ parse_url($instructor->website, PHP_URL_HOST) }}</a>
                        </div>
                        @endif
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[#b8860b] text-lg">mail</span>
                            <button class="hover:text-white">Contact</button>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex gap-3">
                    <button class="bg-primary hover:bg-primary/90 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg shadow-primary/20 flex items-center gap-2">
                        <span class="material-symbols-outlined">add</span>
                        Follow
                    </button>
                    <button class="bg-white/10 hover:bg-white/20 text-white px-4 py-3 rounded-xl font-bold transition-all border border-white/10">
                        <span class="material-symbols-outlined">more_horiz</span>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Content Grid -->
        <div class="px-8 py-10 w-full max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Welcome Video -->
                @if($instructor->welcome_video_url)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200">
                    <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">play_circle</span>
                        Welcome Message
                    </h2>
                    <div class="relative aspect-video rounded-xl overflow-hidden bg-gray-900 group">
                        @if(Str::contains($instructor->welcome_video_url, 'youtube.com') || Str::contains($instructor->welcome_video_url, 'youtu.be'))
                            <iframe class="w-full h-full" src="{{ $instructor->welcome_video_url }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @else
                            <video class="w-full h-full object-cover" controls>
                                <source src="{{ asset($instructor->welcome_video_url) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @endif
                    </div>
                </div>
                @endif
                
                <!-- About Me -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200">
                    <h2 class="text-lg font-bold mb-4">About Me</h2>
                    <div class="prose max-w-none text-slate-600 leading-relaxed text-sm">
                        <p>{{ $instructor->bio ?? 'Empowering leaders through biblical wisdom and practical theology. Specializing in community building and servant leadership.' }}</p>
                    </div>
                </div>
                
                <!-- Upcoming Live Sessions -->
                @if($upcoming_sessions->count() > 0)
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold flex items-center gap-2">
                            <span class="material-symbols-outlined text-red-500 animate-pulse">sensors</span>
                            Upcoming Live Sessions
                        </h2>
                        <a href="{{ route('student.schedule') }}" class="text-sm font-bold text-primary hover:underline">View All</a>
                    </div>
                    <div class="space-y-4">
                        @foreach($upcoming_sessions as $session)
                        @php
                            $isPaid = $session->isPaid(auth()->user());
                            $isLive = $session->isLive();
                            $hasExpired = $session->hasExpired();
                            $wasAttended = $session->wasAttended(auth()->user());
                        @endphp
                        <div class="session-card group" x-data="{ 
                            countdown: '',
                            targetDate: '{{ $session->scheduled_at->toIso8601String() }}',
                            init() {
                                if(!{{ $isLive ? 'true' : 'false' }} && !{{ $hasExpired ? 'true' : 'false' }}) {
                                    this.updateCountdown();
                                    setInterval(() => this.updateCountdown(), 1000);
                                }
                            },
                            updateCountdown() {
                                const target = new Date(this.targetDate).getTime();
                                const now = new Date().getTime();
                                const diff = target - now;
                                
                                if (diff < 0) {
                                    this.countdown = 'Started';
                                    return;
                                }
                                
                                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                                const secs = Math.floor((diff % (1000 * 60)) / 1000);
                                
                                this.countdown = (days > 0 ? days + 'd ' : '') + hours + 'h ' + mins + 'm ' + secs + 's';
                            }
                        }">
                            <div class="flex-shrink-0 w-full sm:w-48 h-32 rounded-xl bg-slate-100 flex items-center justify-center relative overflow-hidden">
                                @if($session->thumbnail)
                                <img src="{{ asset($session->thumbnail) }}" alt="{{ $session->title }}" class="w-full h-full object-cover">
                                @else
                                <span class="material-symbols-outlined text-slate-300 text-4xl">video_camera_front</span>
                                @endif
                                <div class="absolute top-2 left-2 bg-black/60 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-1 rounded">
                                    {{ $session->scheduled_at->format('M d') }}
                                </div>
                            </div>
                            <div class="flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start">
                                        <h3 class="font-bold text-lg group-hover:text-primary transition-colors">{{ $session->title }}</h3>
                                        
                                        @if($isLive)
                                            <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider animate-pulse">Now Live</span>
                                        @elseif($hasExpired)
                                            @if($wasAttended)
                                                <span class="bg-slate-200 text-slate-600 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Ended</span>
                                            @else
                                                <span class="bg-amber-100 text-amber-700 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Expired</span>
                                            @endif
                                        @elseif($isPaid)
                                            <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Paid</span>
                                        @else
                                            <span class="bg-primary/10 text-primary text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">Upcoming</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">{{ Str::limit($session->description, 100) }}</p>
                                    <div class="flex items-center gap-4 mt-3 text-xs text-gray-400 font-medium">
                                        <span class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">schedule</span>
                                            {{ $session->scheduled_at->format('g:i A') }} ({{ $session->type ?? 'Live' }})
                                        </span>
                                        @if(!$isLive && !$hasExpired && $isPaid)
                                        <span class="text-primary font-bold" x-text="'Starts in: ' + countdown"></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-3">
                                    <span class="font-bold text-lg {{ $session->price > 0 && !$isPaid ? 'text-slate-900' : 'text-emerald-600' }}">
                                        @if($isPaid)
                                            <span class="text-xs uppercase text-slate-400">Access Granted</span>
                                        @else
                                            {{ $session->price > 0 ? '₦' . number_format($session->price) : 'Free' }}
                                        @endif
                                    </span>

                                    @if($isLive)
                                        <a href="{{ route('meeting.room', $session->room_code) }}" class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold px-6 py-2 rounded-lg transition-all shadow-md shadow-red-600/20 flex items-center gap-2">
                                            <span class="material-symbols-outlined text-sm">play_circle</span>
                                            Join Now
                                        </a>
                                    @elseif($hasExpired)
                                        <button disabled class="bg-slate-100 text-slate-400 text-sm font-bold px-6 py-2 rounded-lg cursor-not-allowed">
                                            Session Ended
                                        </button>
                                    @elseif($isPaid)
                                        <button disabled class="bg-emerald-50 text-emerald-600 text-sm font-bold px-6 py-2 rounded-lg">
                                            Enrolled
                                        </button>
                                    @else
                                        <a href="{{ route('meeting.checkout', $session->id) }}" class="bg-primary hover:bg-primary/90 text-white text-sm font-bold px-6 py-2 rounded-lg transition-all shadow-md shadow-primary/10">
                                            {{ $session->price > 0 ? 'Gain Access' : 'Join Session' }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Courses by Instructor -->
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold">Courses by {{ explode(' ', $instructor->name)[0] }}</h2>
                        <span class="text-sm font-bold text-slate-400">{{ $courses->count() }} courses</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($courses as $course)
                        <a href="{{ route('course.show', $course) }}" class="bg-white rounded-2xl p-5 border border-gray-200 hover:border-primary/30 transition-colors group">
                            <div class="flex gap-4">
                                <div class="w-20 h-20 rounded-xl bg-slate-100 flex-shrink-0 relative overflow-hidden">
                                    @if($course->thumbnail)
                                    <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                                    @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <span class="material-symbols-outlined text-3xl">menu_book</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold leading-tight mb-1 group-hover:text-primary transition-colors text-sm">{{ $course->title }}</h4>
                                    <p class="text-[10px] text-slate-400 mb-2 font-bold uppercase tracking-wider">{{ $course->modules_count }} Modules</p>
                                    @if($course->price > 0)
                                    <span class="text-sm font-black text-primary">₦{{ number_format($course->price) }}</span>
                                    @else
                                    <span class="text-sm font-black text-emerald-600">Free</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Instructor Stats -->
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                    <h4 class="text-sm font-bold uppercase tracking-wider text-gray-400 mb-4">Instructor Stats</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="stat-card">
                            <p class="text-2xl font-black text-slate-900">{{ number_format($total_students) }}</p>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">Students</p>
                        </div>
                        <div class="stat-card">
                            <p class="text-2xl font-black text-slate-900">{{ $courses->count() }}</p>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">Courses</p>
                        </div>
                        <div class="stat-card">
                            <p class="text-2xl font-black text-slate-900">{{ $instructor->years_ministry ?? '0' }}</p>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">Yrs Ministry</p>
                        </div>
                        <div class="stat-card">
                            <p class="text-2xl font-black text-slate-900">{{ number_format($instructor->rating ?? 5.0, 1) }}</p>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-1">Rating</p>
                        </div>
                    </div>
                    <button class="w-full mt-6 bg-white border border-gray-200 text-sm font-bold py-3 rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
                        Send Message
                    </button>
                </div>
                
                <!-- Books by Author -->
                @if($books->count() > 0)
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-bold uppercase tracking-wider text-gray-400">Books by Author</h4>
                        <a href="{{ route('library.index', ['search' => $instructor->name]) }}" class="text-[10px] font-bold text-primary hover:underline uppercase tracking-widest">View All</a>
                    </div>
                    <div class="space-y-4">
                        @foreach($books as $book)
                        <a href="{{ route('library.read', $book->slug) }}" class="book-item group flex gap-3">
                            <div class="w-14 h-20 bg-slate-50 rounded-lg flex-shrink-0 overflow-hidden border border-slate-100 flex items-center justify-center">
                                @if($book->cover_image)
                                <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                <span class="material-symbols-outlined text-slate-300">import_contacts</span>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h5 class="book-title text-sm font-bold leading-tight truncate group-hover:text-primary transition-colors">{{ $book->title }}</h5>
                                <p class="text-[10px] text-gray-500 mt-1 line-clamp-2 leading-relaxed">{{ $book->description }}</p>
                                <p class="text-xs font-black text-primary mt-2">
                                    {{ $book->price > 0 ? '₦' . number_format($book->price) : 'Free' }}
                                </p>
                            </div>
                        </a>
                        @if(!$loop->last)
                        <div class="border-t border-slate-50"></div>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Mentorship CTA -->
                <div class="mentor-cta text-center">
                    <div class="size-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6 backdrop-blur-md">
                        <span class="material-symbols-outlined text-white text-3xl">workspace_premium</span>
                    </div>
                    <h4 class="text-xl font-black mb-2">Need a Mentor?</h4>
                    <p class="text-sm text-white/70 mb-8 leading-relaxed">Book a 1-on-1 mentorship session with {{ explode(' ', $instructor->name)[0] }} to discuss your ministry path.</p>
                    <a href="{{ route('instructor.book', $instructor->id) }}" 
                       class="block w-full bg-white text-primary text-sm font-black py-4 rounded-xl hover:bg-slate-50 transition-all shadow-xl shadow-black/10">
                        Request Session
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
