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
        <img src="{{ asset('storage/'.$event->image) }}" onerror="this.src='https://images.unsplash.com/photo-1438232992991-995b7058bbb3?auto=format&fit=crop&q=80&w=1200'" alt="{{ $event->title }}">
    @else
        <div class="w-full h-full flex items-center justify-center bg-slate-200">
            <span class="material-symbols-outlined text-8xl text-slate-400 font-light">calendar_month</span>
        </div>
    @endif
    
    <div style="position: absolute; bottom: 2rem; left: 2rem; display: flex; gap: 0.75rem;">
        @if($event->status == 'comming' || $event->status == 'upcoming')
            <span class="px-5 py-2 bg-emerald-500 text-white rounded-full text-xs font-black uppercase tracking-widest shadow-lg shadow-emerald-500/20">Upcoming</span>
        @else
            <span class="px-5 py-2 bg-slate-500 text-white rounded-full text-xs font-black uppercase tracking-widest shadow-lg shadow-slate-500/20">Passed</span>
        @endif

        @if($event->recurrence && $event->recurrence !== 'none')
            <span class="px-5 py-2 bg-primary text-white rounded-full text-xs font-black uppercase tracking-widest shadow-lg shadow-primary/20 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">sync</span>
                {{ ucfirst($event->recurrence) }}
            </span>
        @endif
    </div>
</div>

<div class="event-container">
    <a href="{{ route('event') }}" class="flex items-center gap-2 text-slate-500 font-black text-xs uppercase tracking-widest hover:text-primary transition-colors mb-6">
        <span class="material-symbols-outlined text-lg">arrow_back</span>
        Back to Events
    </a>

    <div class="event-content-card">
        <div class="event-header">
            <h1 class="event-title">{{ $event->title }}</h1>
            
            <div class="event-meta-grid">
                <div class="meta-item">
                    <span class="meta-label">Date</span>
                    <span class="meta-value">
                        <span class="material-symbols-outlined text-primary">calendar_today</span>
                        {{ $event->date ? \Carbon\Carbon::parse($event->date)->format('l, F j, Y') : 'TBA' }}
                    </span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Time</span>
                    <span class="meta-value">
                        <span class="material-symbols-outlined text-primary">schedule</span>
                        {{ $event->time ?? 'TBA' }}
                    </span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Location</span>
                    <span class="meta-value">
                        <span class="material-symbols-outlined text-primary">location_on</span>
                        {{ $event->location ?? 'Main Sanctuary' }}
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
