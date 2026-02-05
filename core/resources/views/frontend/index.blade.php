@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<!-- Hero Section -->
<section style="position: relative; min-height: 80vh; display: flex; align-items: center; justify-content: center; background: radial-gradient(circle at center, #1e293b 0%, #0f172a 100%); color: white; overflow: hidden;">
    
    <!-- Background Elements -->
    <div style="position: absolute; top: -10%; right: -10%; width: 50%; height: 50%; background: var(--primary); opacity: 0.15; filter: blur(100px); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -10%; left: -10%; width: 40%; height: 40%; background: var(--accent); opacity: 0.1; filter: blur(100px); border-radius: 50%;"></div>

    <div class="container" style="position: relative; z-index: 2; text-align: center; max-width: 800px;">
        @if(($is_live->value ?? '0') == '1')
            <a href="{{ route('live') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); padding: 0.5rem 1rem; border-radius: 100px; color: #fca5a5; font-weight: 700; font-size: 0.875rem; margin-bottom: 2rem; transition: transform 0.2s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                <span class="live-dot" style="width: 8px; height: 8px; background: #ef4444; border-radius: 50%; animation: pulse-red 2s infinite;"></span>
                WE ARE LIVE NOW &rarr;
            </a>
        @endif

        <h1 style="font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 800; line-height: 1.1; margin-bottom: 1.5rem; background: linear-gradient(to right, #ffffff, #94a3b8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            Empowering Believers for Kingdom Impact
        </h1>
        
        <p style="font-size: 1.5rem; font-style: italic; color: #f8fafc; margin-bottom: 2.5rem; line-height: 1.6; font-weight: 500;">
            "Raising gods from amongst men on earth for Christ"
        </p>
        
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('live') }}" class="btn btn-primary" style="padding: 1rem 2rem; font-size: 1rem;">
                Watch Live Service
            </a>
            <a href="{{ route('event') }}" class="btn btn-outline" style="padding: 1rem 2rem; font-size: 1rem; border-color: rgba(255,255,255,0.2); color: white;">
                Upcoming Events
            </a>
        </div>
    </div>
</section>

<!-- Ministry Grid -->
<section style="padding: 5rem 0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
            <!-- Card 1 -->
            <a href="{{ route('event') }}" class="feature-card">
                <div class="icon-box" style="background: #e0f2fe; color: #0284c7;">
                    📅
                </div>
                <h3>Events & Calendar</h3>
                <p>Stay updated with our latest conferences, services, and gatherings.</p>
            </a>

            <!-- Card 2 -->
            <a href="{{ route('store.index') }}" class="feature-card">
                <div class="icon-box" style="background: #fef3c7; color: #d97706;">
                    🛒
                </div>
                <h3>Ministry Store</h3>
                <p>Browse our collection of books, merchandise, and spiritual resources.</p>
            </a>

            <!-- Card 3 -->
            <a href="{{ route('library.index') }}" class="feature-card">
                <div class="icon-box" style="background: #dcfce7; color: #16a34a;">
                    📚
                </div>
                <h3>Digital Library</h3>
                <p>Read impactful books and articles directly in your browser.</p>
            </a>

            <!-- Card 4 -->
            <a href="{{ route('donate') }}" class="feature-card">
                <div class="icon-box" style="background: #fee2e2; color: #dc2626;">
                    ❤️
                </div>
                <h3>Give & Support</h3>
                <p>Partner with us to advance the Kingdom through your generosity.</p>
            </a>
        </div>
    </div>
</section>

<!-- Latest Events -->
<section style="padding: 5rem 0; background: white;">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: end; margin-bottom: 3rem;">
            <div>
                <h2 style="font-size: 2rem; color: var(--text-main); margin-bottom: 0.5rem;">Ongoing & Upcoming</h2>
                <p style="color: var(--text-muted);">Don't miss out on what God is doing.</p>
            </div>
            <a href="{{ route('event') }}" style="color: var(--primary); font-weight: 600;">View All &rarr;</a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            @foreach($events as $event)
            <div class="event-card">
                <div class="event-date">
                    <span style="font-size: 1.5rem; font-weight: 700;">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                    <span style="font-size: 0.875rem; text-transform: uppercase;">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</span>
                </div>
                <div style="padding: 1.5rem; padding-left: 5rem;">
                    <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem;">{{ $event->title }}</h3>
                    <p style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 1rem;">
                        ⏰ {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }} &nbsp;|&nbsp; 📍 {{ $event->location ?? 'Main Sanctuary' }}
                    </p>
                    <a href="{{ route('event.single', $event->id) }}" class="btn btn-ghost" style="padding: 0; color: var(--primary);">Details &rarr;</a>
                </div>
            </div>
            @endforeach
            
            @if($events->count() == 0)
            <div style="grid-column: 1/-1; text-align: center; padding: 3rem; background: #f8fafc; border-radius: 1rem; color: var(--text-muted);">
                No upcoming events scheduled at the moment.
            </div>
            @endif
        </div>
    </div>
</section>

<style>
    .feature-card {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        border: 1px solid transparent;
        display: block;
    }
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: rgba(23, 84, 207, 0.1);
    }
    .icon-box {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .feature-card h3 {
        font-size: 1.125rem;
        margin-bottom: 0.5rem;
        color: var(--text-main);
    }
    .feature-card p {
        color: var(--text-muted);
        font-size: 0.9375rem;
        margin: 0;
    }

    /* Event Card */
    .event-card {
        background: white;
        border-radius: 1rem;
        border: 1px solid #e2e8f0;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .event-card:hover {
        border-color: var(--primary);
        box-shadow: var(--shadow-md);
    }
    .event-date {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 4rem;
        background: #f1f5f9;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-right: 1px solid #e2e8f0;
        color: var(--primary);
    }
</style>
@endsection
