@extends('layouts.app')

@push('styles')
<style>
    .event-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        transition: all 0.2s ease-in-out;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .event-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        border-color: #cbd5e1;
    }
    .event-image {
        height: 200px;
        width: 100%;
        object-fit: cover;
        background-color: #f1f5f9;
        position: relative;
    }
    .date-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        text-align: center;
        box-shadow: 0 2px 4px rgb(0 0 0 / 0.1);
        color: var(--primary-color);
        font-weight: 700;
        line-height: 1.1;
        min-width: 60px;
    }
    .date-badge .day {
        font-size: 1.5rem;
        display: block;
    }
    .date-badge .month {
        font-size: 0.75rem;
        text-transform: uppercase;
        display: block;
    }
    .event-content {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .event-meta {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: #64748b;
        margin-bottom: 0.5rem;
    }
    .event-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.75rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .event-desc {
        color: #64748b;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex-grow: 1;
    }
    .read-more-btn {
        display: inline-flex;
        align-items: center;
        color: var(--primary-color);
        font-weight: 600;
        font-size: 0.925rem;
        text-decoration: none;
        transition: color 0.2s;
        margin-top: auto;
    }
    .read-more-btn:hover {
        color: #1a4ebd;
    }
    .pagination-wrapper {
        margin-top: 3rem;
        display: flex;
        justify-content: center;
    }
</style>
@endpush

@section('content')
<div style="background-color: #fff; border-bottom: 1px solid #e2e8f0; padding: 3rem 1rem; text-align: center;">
    <h1 style="font-size: 2.25rem; font-weight: 800; color: #1e293b; letter-spacing: -0.05em; margin-bottom: 0.5rem;">Upcoming Events</h1>
    <p style="color: #64748b; max-width: 600px; margin: 0 auto;">Join us in our upcoming gatherings, workshops, and community celebrations.</p>
</div>

<div style="padding: 3rem 1rem; max-width: 1200px; margin: 0 auto;">
    @if($events->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem;">
            @foreach($events as $event)
            <div class="event-card">
                <div class="event-image">
                    @if($event->image)
                        <img src="{{ asset('assets/images/thumbs/events/' . $event->image) }}" alt="{{ $event->title }}">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #cbd5e1; font-size: 3rem;">
                            📅
                        </div>
                    @endif
                    <div class="date-badge">
                        <span class="day">{{ $event->date ? \Carbon\Carbon::parse($event->date)->format('d') : 'TBA' }}</span>
                        <span class="month">{{ $event->date ? \Carbon\Carbon::parse($event->date)->format('M') : '' }}</span>
                    </div>
                </div>
                <div class="event-content">
                    <div class="event-meta">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span>{{ $event->time ?? 'Time TBA' }}</span>
                    </div>
                    <div class="event-meta">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <span>{{ $event->location ?? 'Location TBA' }}</span>
                    </div>
                    <a href="{{ route('event.single', $event->id) }}" style="text-decoration: none;">
                        <h3 class="event-title">{{ $event->title }}</h3>
                    </a>
                    <p class="event-desc">{{ Str::limit($event->description, 100) }}</p>
                    <a href="{{ route('event.single', $event->id) }}" class="read-more-btn">
                        Get Details 
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 0.25rem;"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $events->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 4rem 1rem; color: #64748b;">
            <p style="font-size: 1.1rem;">No upcoming events found.</p>
        </div>
    @endif
</div>
@endsection
