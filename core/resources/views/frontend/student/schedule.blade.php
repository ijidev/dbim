@extends('layouts.app')

@section('title', 'My Schedule')

@push('styles')
<style>
    .schedule-container {
        max-width: 1000px;
        margin: 3rem auto;
        padding: 0 1rem;
    }
    .schedule-header {
        margin-bottom: 2.5rem;
    }
    .calendar-card {
        background: white;
        border-radius: 2rem;
        padding: 2.5rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    .event-item {
        display: flex;
        gap: 1.5rem;
        padding: 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s;
    }
    .event-item:hover {
        background: #f8fafc;
        transform: translateX(5px);
    }
    .event-date {
        width: 60px;
        text-align: center;
        flex-shrink: 0;
    }
    .date-day {
        font-size: 1.5rem;
        font-weight: 900;
        color: var(--primary-color);
        line-height: 1;
    }
    .date-month {
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }
</style>
@endpush

@section('content')
<div class="schedule-container">
    <div class="schedule-header">
        <h1 class="text-3xl font-black text-slate-900 mb-2">Academic Schedule</h1>
        <p class="text-slate-500 font-medium">Keep track of your upcoming live sessions, meetings, and deadlines.</p>
    </div>

    <div class="calendar-card">
        <div class="flex items-center justify-between mb-8 pb-6 border-bottom border-slate-100">
            <h2 class="text-xl font-bold text-slate-900">Upcoming Events</h2>
            <div class="flex gap-2">
                <span class="px-3 py-1 bg-primary/10 text-primary text-[10px] font-black uppercase rounded-full">Meetings</span>
                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase rounded-full">Classes</span>
            </div>
        </div>

        <div class="space-y-2">
            {{-- This would dynamically fetch from both Meetings and Events/Classes --}}
            <div class="event-item">
                <div class="event-date">
                    <div class="date-day">08</div>
                    <div class="date-month">Feb</div>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <h4 class="font-black text-slate-900">Bible Study Course: Live Session 1</h4>
                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase rounded">Class</span>
                    </div>
                    <p class="text-sm text-slate-500 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">schedule</span> 10:00 AM - 11:30 AM
                    </p>
                </div>
                <div>
                    <a href="{{ route('live') }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg text-xs font-black hover:bg-primary hover:text-white transition-all">Join Room</a>
                </div>
            </div>

            <div class="event-item text-slate-400">
                <div class="event-date">
                    <div class="date-day">12</div>
                    <div class="date-month">Feb</div>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <h4 class="font-black text-slate-900">Spoken Word Ministry Open Forum</h4>
                        <span class="px-2 py-0.5 bg-primary/10 text-primary text-[10px] font-black uppercase rounded">Meeting</span>
                    </div>
                    <p class="text-sm text-slate-500 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">schedule</span> 04:00 PM
                    </p>
                </div>
                <div>
                    <button class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg text-xs font-black" disabled>Pending</button>
                </div>
            </div>
            
            <div class="py-12 text-center">
                <span class="material-symbols-outlined text-4xl text-slate-200 mb-2">event_busy</span>
                <p class="text-slate-400 font-medium">No more events scheduled for this week.</p>
            </div>
        </div>
    </div>
</div>
@endsection
