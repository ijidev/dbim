@extends('layouts.app')

@section('title', 'My Bookings - DBIM Academy')

@push('styles')
<style>
    .booking-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #e5e7eb;
        padding: 24px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .booking-card:hover {
        border-color: var(--primary);
        box-shadow: 0 12px 24px -8px rgba(23, 84, 207, 0.15);
        transform: translateY(-2px);
    }
    .status-badge {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 6px 12px;
        border-radius: 9999px;
    }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-scheduled { background: #dcfce7; color: #166534; }
    .status-ended { background: #f1f5f9; color: #475569; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }
</style>
@endpush

@section('content')
<div class="flex min-h-screen bg-[#f6f6f8]">
    <!-- Sidebar Navigation (Desktop) -->
    @include('partials.student_sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <div class="max-w-5xl mx-auto">
            <header class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-black text-slate-900">My Bookings</h1>
                    <p class="text-slate-500 mt-2 font-medium">Manage your mentorship sessions and group masterclasses.</p>
                </div>
                <a href="{{ route('instructors') }}" class="bg-primary text-white px-6 py-3 rounded-xl font-bold flex items-center gap-2 shadow-lg shadow-primary/20 hover:scale-105 transition-all w-fit">
                    <span class="material-symbols-outlined">add</span>
                    Book New Session
                </a>
            </header>

            <div class="space-y-6">
                @forelse($meetings as $meeting)
                <div class="booking-card">
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Date Info -->
                        <div class="md:w-32 flex-shrink-0 flex flex-col items-center justify-center p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <span class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ $meeting->scheduled_at->format('M') }}</span>
                            <span class="text-3xl font-black text-slate-900">{{ $meeting->scheduled_at->format('d') }}</span>
                            <span class="text-xs font-bold text-slate-500 mt-1">{{ $meeting->scheduled_at->format('g:i A') }}</span>
                        </div>

                        <!-- Session Info -->
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-3 mb-2">
                                <span class="status-badge status-{{ $meeting->status }}">{{ $meeting->status }}</span>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">{{ $meeting->visibility === 'private' ? 'lock' : 'public' }}</span>
                                    {{ $meeting->visibility }} Session
                                </span>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 mb-2">{{ $meeting->title }}</h3>
                            <div class="flex items-center gap-4 text-sm text-slate-500 font-medium">
                                <div class="flex items-center gap-2">
                                    <div class="size-6 rounded-full bg-slate-200 overflow-hidden">
                                        @if($meeting->host->avatar)
                                        <img src="{{ asset($meeting->host->avatar) }}" class="w-full h-full object-cover">
                                        @else
                                        <div class="w-full h-full flex items-center justify-center text-[10px] font-black">{{ substr($meeting->host->name, 0, 1) }}</div>
                                        @endif
                                    </div>
                                    <span>With {{ $meeting->host->name }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-3 md:flex-col md:justify-center md:items-end">
                            @if($meeting->status === 'scheduled')
                            <a href="{{ route('meeting.room', $meeting->room_code) }}" class="bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-xl font-black shadow-lg shadow-primary/20 transition-all">
                                Join Room
                            </a>
                            @elseif($meeting->status === 'pending')
                            <a href="{{ route('meeting.checkout', $meeting->id) }}" class="bg-accent hover:bg-accent/90 text-white px-6 py-3 rounded-xl font-black shadow-lg shadow-accent/20 transition-all">
                                Pay Now
                            </a>
                            @endif
                            <button class="p-3 text-slate-400 hover:text-slate-900 transition-colors">
                                <span class="material-symbols-outlined">more_vert</span>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-3xl p-20 text-center border-2 border-dashed border-gray-100">
                    <div class="size-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="material-symbols-outlined text-slate-300 text-4xl">calendar_today</span>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-2">No Bookings Yet</h3>
                    <p class="text-slate-500 max-w-sm mx-auto mb-8">You haven't scheduled any mentorship sessions or masterclasses yet. Start your journey today!</p>
                    <a href="{{ route('instructors') }}" class="bg-primary text-white px-8 py-4 rounded-2xl font-black shadow-xl shadow-primary/20 hover:scale-105 transition-all inline-flex items-center gap-2">
                        Browse Instructors
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </main>
</div>
@endsection
