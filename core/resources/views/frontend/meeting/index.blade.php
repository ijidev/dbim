@extends('layouts.app')

@section('title', 'Meetings Dashboard')

@push('styles')
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    "primary": "#1754cf",
                    "primary-dark": "#103c96",
                    "primary-light": "#e0e7ff",
                    "accent": "#f59e0b",
                }
            }
        }
    }
</script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .fill-1 { font-variation-settings: 'FILL' 1; }
    
    /* Calendar dots */
    .has-event { position: relative; }
    .has-event::after {
        content: '';
        position: absolute;
        bottom: 4px;
        left: 50%;
        transform: translateX(-50%);
        width: 4px;
        height: 4px;
        background: var(--primary);
        border-radius: 50%;
    }

    @keyframes scale-in {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    .scale-in { animation: scale-in 0.2s ease-out; }
</style>
@endpush

@section('content')
<main class="max-w-[1200px] mx-auto px-4 sm:px-10 py-8">
    <!-- Breadcrumbs -->
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('index') }}" class="text-slate-500 text-sm font-medium hover:text-primary">Home</a>
        <span class="text-slate-400 text-sm material-symbols-outlined !text-xs">chevron_right</span>
        <span class="text-slate-900 text-sm font-semibold">Meetings Dashboard</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Sidebar: Profile & Quick Actions -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex flex-col items-center text-center">
                    <div class="bg-slate-100 rounded-full h-24 w-24 mb-4 flex items-center justify-center text-primary text-3xl font-bold border-4 border-primary/5 shadow-inner">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <h1 class="text-slate-900 text-xl font-bold">{{ auth()->user()->name }}</h1>
                    <p class="text-primary text-sm font-semibold mb-4">Meeting Host</p>
                    
                    <div class="w-full pt-4 border-t border-slate-50 space-y-3">
                        <a href="{{ route('meeting.create') }}" class="w-full bg-primary hover:bg-primary-dark text-white py-3 rounded-xl font-bold shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">add_circle</span>
                            New Meeting
                        </a>
                        <button onclick="document.getElementById('joinModal').style.display='flex'" class="w-full bg-white border-2 border-slate-100 hover:border-primary hover:text-primary text-slate-600 py-3 rounded-xl font-bold transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">key</span>
                            Join by Code
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats Box -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <h3 class="text-slate-900 text-sm font-bold mb-4 uppercase tracking-wider">Session Summary</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">groups</span>
                            <span class="text-sm font-medium text-slate-600">Total Hosted</span>
                        </div>
                        <span class="text-sm font-bold bg-slate-50 px-2 py-1 rounded">{{ $meetings->total() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-green-500">online_prediction</span>
                            <span class="text-sm font-medium text-slate-600">Active Now</span>
                        </div>
                        <span class="text-sm font-bold bg-green-50 text-green-700 px-2 py-1 rounded">{{ $meetings->where('status', 'active')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Dashboard -->
        <div class="lg:col-span-8 space-y-8">
            <!-- Format Chooser (Quick Filter Info) -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center gap-3 mb-6">
                    <span class="size-8 rounded-full bg-primary flex items-center justify-center text-white font-bold text-sm">1</span>
                    <h2 class="text-slate-900 text-lg font-bold">Quick Overview</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl border-2 border-primary bg-primary/5">
                        <div class="flex justify-between items-start mb-3">
                            <span class="material-symbols-outlined text-primary">bolt</span>
                            <span class="text-[10px] font-bold px-2 py-0.5 bg-green-100 text-green-700 rounded uppercase">Ready</span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 mb-1">Instant Sessions</h3>
                        <p class="text-xs text-slate-500 mb-4">Start a room and share the code immediately.</p>
                        <a href="{{ route('meeting.create') }}" class="text-xs font-bold text-primary flex items-center gap-1">Create Now &rarr;</a>
                    </div>
                    <div class="p-4 rounded-xl border-2 border-slate-100">
                        <div class="flex justify-between items-start mb-3">
                            <span class="material-symbols-outlined text-slate-400">calendar_month</span>
                            <span class="text-[10px] font-bold px-2 py-0.5 bg-slate-100 text-slate-600 rounded uppercase">Tracked</span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 mb-1">Scheduled Events</h3>
                        <p class="text-xs text-slate-500 mb-4">Upcoming and planned sessions for the future.</p>
                        <span class="text-xs font-bold text-slate-400">View below</span>
                    </div>
                </div>
            </div>

            <!-- Meeting List & Calendar -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center gap-3 mb-6">
                    <span class="size-8 rounded-full bg-primary flex items-center justify-center text-white font-bold text-sm">2</span>
                    <h2 class="text-slate-900 text-lg font-bold">My Recent & Upcoming Meetings</h2>
                </div>

                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Simple Calendar View (Static shell, logic simplified) -->
                    <div class="w-full md:w-64">
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-sm font-bold text-slate-900">{{ now()->format('F Y') }}</p>
                            <div class="flex gap-1">
                                <button class="size-8 rounded flex items-center justify-center hover:bg-slate-50 text-slate-400"><span class="material-symbols-outlined !text-lg">chevron_left</span></button>
                                <button class="size-8 rounded flex items-center justify-center hover:bg-slate-50 text-slate-400"><span class="material-symbols-outlined !text-lg">chevron_right</span></button>
                            </div>
                        </div>
                        <div class="grid grid-cols-7 text-center mb-2">
                            @foreach(['S','M','T','W','T','F','S'] as $day)
                                <div class="text-[10px] font-bold text-slate-400 uppercase">{{ $day }}</div>
                            @endforeach
                        </div>
                        <div class="grid grid-cols-7 gap-1">
                            @php
                                $startOfMonth = now()->startOfMonth();
                                $daysInMonth = now()->daysInMonth;
                                $startDay = $startOfMonth->dayOfWeek;
                            @endphp
                            
                            @for($i = 0; $i < $startDay; $i++)
                                <div class="aspect-square"></div>
                            @endfor
                            
                            @for($d = 1; $d <= $daysInMonth; $d++)
                                @php $isToday = ($d == now()->day); @endphp
                                <button class="aspect-square flex items-center justify-center text-xs rounded-lg {{ $isToday ? 'bg-primary text-white font-bold ring-4 ring-primary/20' : 'hover:bg-primary/10 text-slate-600' }}">
                                    {{ $d }}
                                </button>
                            @endfor
                        </div>
                    </div>

                    <!-- Meetings Vertical List -->
                    <div class="flex-1 space-y-4">
                        <div class="flex items-center justify-between">
                            <h4 class="text-sm font-bold text-slate-900">Agenda</h4>
                            <span class="text-[10px] text-slate-400 uppercase font-bold tracking-widest">Ordered by date</span>
                        </div>
                        
                        <div class="space-y-3">
                            @forelse($meetings as $meeting)
                            <div class="p-4 rounded-xl border-2 {{ $meeting->status == 'active' ? 'border-primary bg-primary/5' : 'border-slate-50 hover:border-slate-200' }} transition-all flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-10 rounded-lg {{ $meeting->status == 'active' ? 'bg-primary text-white' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined">{{ $meeting->status == 'active' ? 'videocam' : 'calendar_today' }}</span>
                                    </div>
                                    <div>
                                        <h5 class="text-sm font-bold text-slate-900">{{ $meeting->title }}</h5>
                                        <p class="text-[11px] text-slate-500 flex items-center gap-1">
                                            <span class="material-symbols-outlined !text-xs">key</span> {{ $meeting->room_code }}
                                            @if($meeting->scheduled_at)
                                                <span class="mx-1">•</span> {{ $meeting->scheduled_at->format('M d, h:i A') }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    @if($meeting->status != 'ended')
                                        <a href="{{ route('meeting.room', $meeting->room_code) }}" class="px-4 py-2 {{ $meeting->status == 'active' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'bg-slate-100 text-slate-600' }} rounded-lg text-xs font-bold transition-all hover:scale-105 active:scale-95 inline-block">
                                            Join
                                        </a>
                                    @else
                                        <span class="text-[10px] font-bold text-slate-400 uppercase">Ended</span>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8">
                                <span class="material-symbols-outlined text-slate-200 !text-5xl mb-2">videocam_off</span>
                                <p class="text-sm text-slate-500">No meetings found.</p>
                            </div>
                            @endforelse
                        </div>
                        
                        <div class="mt-4">
                            {{ $meetings->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Card -->
            <div class="bg-primary shadow-xl shadow-primary/30 rounded-2xl p-8 text-white relative overflow-hidden">
                <div class="absolute -top-10 -right-10 size-40 bg-white/10 rounded-full blur-3xl"></div>
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="space-y-1">
                        <h3 class="text-white/70 text-sm font-bold uppercase tracking-widest">Need help?</h3>
                        <p class="text-2xl font-black">Spiritual Growth Syllabus</p>
                        <p class="text-white/80 text-sm">Review core concepts before your next live session starts.</p>
                    </div>
                    <a href="{{ route('library.index') }}" class="bg-white text-primary px-8 py-4 rounded-xl font-bold transition-all hover:bg-slate-100 shadow-lg flex items-center gap-2">
                        <span class="material-symbols-outlined">menu_book</span>
                        Library
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Join Modal -->
<div id="joinModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md p-8 shadow-2xl scale-in">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-black text-slate-900">Join a Meeting</h3>
            <button onclick="document.getElementById('joinModal').style.display='none'" class="text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <p class="text-slate-500 text-sm mb-6">Enter the meeting room code provided by the host to join the session.</p>
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Room Code</label>
                <input type="text" id="roomCodeInput" placeholder="e.g. ROOM123" class="w-full bg-slate-50 border-2 border-slate-100 rounded-xl px-4 py-3 text-lg font-bold focus:border-primary focus:ring-0 transition-all outline-none">
            </div>
            <button onclick="joinRoom()" class="w-full bg-primary hover:bg-primary-dark text-white py-4 rounded-xl font-bold shadow-lg shadow-primary/30 transition-all flex items-center justify-center gap-2">
                Join Room
                <span class="material-symbols-outlined">arrow_forward</span>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function joinRoom() {
        const code = document.getElementById('roomCodeInput').value.trim();
        if (code) {
            window.location.href = `{{ url('/meeting/room') }}/${code}`;
        }
    }
</script>
@endpush
@endsection
