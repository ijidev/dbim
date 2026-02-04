@extends('layouts.app')

@push('styles')
<style>
    .event-hero {
        height: 400px;
        width: 100%;
        background-color: #f1f5f9;
        position: relative;
        overflow: hidden;
    }
    .event-hero img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .event-container {
        max-width: 1000px;
        margin: -100px auto 3rem;
        position: relative;
        padding: 0 1rem;
    }
    .event-content-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }
    .event-header {
        padding: 2.5rem;
        border-bottom: 1px solid #e2e8f0;
    }
    .event-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -0.025em;
        line-height: 1.2;
        margin-bottom: 1.5rem;
    }
    .event-meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }
    .meta-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    .meta-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        font-weight: 600;
    }
    .meta-value {
        font-size: 1rem;
        font-weight: 500;
        color: #334155;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .event-body {
        padding: 2.5rem;
        font-size: 1.1rem;
        line-height: 1.8;
        color: #334155;
    }
    .back-btn {
        display: inline-flex;
        align-items: center;
        margin-bottom: 1rem;
        color: #64748b;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }
    .back-btn:hover {
        color: #1e293b;
    }
    @media (max-width: 768px) {
        .event-hero {
            height: 250px;
        }
        .event-container {
            margin-top: -50px;
        }
        .event-header, .event-body {
            padding: 1.5rem;
        }
        .event-title {
            font-size: 1.75rem;
        }
    }
</style>
@endpush

@section('content')
<div class="event-hero">
    @if($event->image)
        <img src="{{ asset('assets/images/thumbs/events/' . $event->image) }}" alt="{{ $event->title }}">
    @else
        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
    @endif
</div>

<div class="event-container">
    <a href="{{ route('event') }}" class="back-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.5rem;"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Back to Events
    </a>

    <div class="event-content-card">
        <div class="event-header">
            <h1 class="event-title">{{ $event->title }}</h1>
            
            <div class="event-meta-grid">
                <div class="meta-item">
                    <span class="meta-label">Date</span>
                    <span class="meta-value">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        {{ $event->date ? \Carbon\Carbon::parse($event->date)->format('l, F j, Y') : 'TBA' }}
                    </span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Time</span>
                    <span class="meta-value">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        {{ $event->time ?? 'TBA' }}
                    </span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Location</span>
                    <span class="meta-value">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        {{ $event->location ?? 'TBA' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="event-body">
            {!! nl2br(e($event->description)) !!}
        </div>
        
        <!-- Registration Section -->
        <div style="padding: 2.5rem; background: #f8fafc; border-top: 1px solid #e2e8f0;">
            <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; color: #1e293b;">Register for this Event</h3>
            
            @if(session('success'))
                <div style="background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
                    {{ session('error') }}
                </div>
            @endif
            
            <form action="{{ route('event.register', $event->id) }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.875rem;">Full Name *</label>
                        <input type="text" name="name" required value="{{ auth()->user()?->name }}" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; font-size: 1rem;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.875rem;">Email Address *</label>
                        <input type="email" name="email" required value="{{ auth()->user()?->email }}" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; font-size: 1rem;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.875rem;">Phone Number</label>
                        <input type="tel" name="phone" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; font-size: 1rem;">
                    </div>
                </div>
                <button type="submit" style="background: var(--primary-color); color: white; border: none; padding: 1rem 2rem; border-radius: 0.75rem; font-weight: 700; font-size: 1rem; cursor: pointer;">
                    Register Now
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
