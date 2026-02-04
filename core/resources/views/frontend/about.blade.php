@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<!-- Hero Section -->
<div style="background-color: white; border-bottom: 1px solid #e2e8f0; padding: 5rem 1rem; text-align: center; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50%; left: -10%; width: 50%; height: 200%; background: radial-gradient(circle, rgba(23, 84, 207, 0.05) 0%, transparent 70%); z-index: 0;"></div>
    
    <div class="container" style="position: relative; z-index: 1;">
        <h1 style="font-size: clamp(2.5rem, 5vw, 3.5rem); font-weight: 800; color: #1e293b; letter-spacing: -0.05em; margin-bottom: 1rem; line-height: 1.1;">
            We Are <span style="color: var(--primary);">DBIM</span>
        </h1>
        <p style="color: #64748b; max-width: 800px; margin: 0 auto; font-size: 1.25rem; line-height: 1.6;">
            Producing Mighty People and Nations For Christ, raising gods among men for God's Kingdom and Dominion on Earth.
        </p>
    </div>
</div>

<div class="container" style="padding: 5rem 1.5rem;">
    <!-- Quote Section -->
    <div style="margin-bottom: 5rem; text-align: center;">
        <blockquote style="font-size: 1.5rem; font-style: italic; color: #334155; border-left: 4px solid var(--primary); padding: 1rem 2rem; margin: 0 auto; display: inline-block; text-align: left; background: #f8fafc; border-radius: 0 1rem 1rem 0;">
            "be thou the mother of thousands of millions, and let thy seed possess the gate of those which hate them."
            <footer style="margin-top: 1rem; font-size: 0.875rem; color: var(--text-muted); font-weight: 600; font-style: normal; text-transform: uppercase; letter-spacing: 0.05em;">— Genesis 24:60b KJV</footer>
        </blockquote>
    </div>

    <!-- Mission & Purpose -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 3rem; margin-bottom: 5rem;">
        <div style="padding: 2rem; background: white; border-radius: 1rem; border: 1px solid #e2e8f0; box-shadow: var(--shadow-sm);">
            <div style="width: 48px; height: 48px; background: #e0f2fe; color: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1.5rem;">🎯</div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Our Purpose</h2>
            <p style="color: #475569; line-height: 1.7;">To establish a divine mandate and vision that empowers believers to walk in their true identity in Christ, fostering a culture of kingdom dominion and spiritual growth.</p>
        </div>
        <div style="padding: 2rem; background: white; border-radius: 1rem; border: 1px solid #e2e8f0; box-shadow: var(--shadow-sm);">
            <div style="width: 48px; height: 48px; background: #fef3c7; color: #d97706; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1.5rem;">🚀</div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Our Mission</h2>
            <p style="color: #475569; line-height: 1.7;">Raising a generation of fire-branded believers equipped with the word and spirit to transform societies and impact generations for the glory of God.</p>
        </div>
    </div>

    <!-- Core Values -->
    <div style="margin-bottom: 5rem;">
        <h2 style="text-align: center; font-size: 2rem; font-weight: 800; color: #1e293b; margin-bottom: 3rem;">Our Core Values</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 2rem;">
            <div class="value-card">
                <div class="value-icon">✝️</div>
                <h3>Identity in Christ</h3>
                <p>Understanding who we are in Him.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🏠</div>
                <h3>Church Is Family</h3>
                <p>Bound by love and shared purpose.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🌍</div>
                <h3>Kingdom Culture</h3>
                <p>Living heaven's principles on earth.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🕊️</div>
                <h3>Spirit Led Life</h3>
                <p>Walking in the power of the Holy Spirit.</p>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div>
        <h2 style="text-align: center; font-size: 2rem; font-weight: 800; color: #1e293b; margin-bottom: 3rem;">Meet Our Team</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
            @php
                $team = [
                    ['name' => 'Jonathan Doe', 'role' => 'Lead Pastor', 'image' => 'user-01.jpg'],
                    ['name' => 'Jane Doe', 'role' => 'Lead Pastor', 'image' => 'user-02.jpg'],
                    ['name' => 'Charles Spurgeon', 'role' => 'Associate Pastor', 'image' => 'user-03.jpg'],
                    ['name' => 'Martin Luther', 'role' => 'Associate Pastor', 'image' => 'user-04.jpg'],
                ];
            @endphp
            @foreach($team as $member)
            <div class="team-card">
                <div class="team-avatar">
                    <span>{{ substr($member['name'], 0, 1) }}</span>
                </div>
                <h4>{{ $member['name'] }}</h4>
                <p>{{ $member['role'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .value-card {
        text-align: center;
        padding: 2rem;
        background: white;
        border-radius: 1rem;
        transition: transform 0.3s ease;
    }
    .value-card:hover { transform: translateY(-5px); }
    .value-icon { font-size: 3rem; margin-bottom: 1rem; }
    .value-card h3 { font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem; }
    .value-card p { font-size: 0.9rem; color: #64748b; margin: 0; }

    .team-card {
        background: white;
        border: 1px solid #e2e8f0;
        padding: 2rem;
        border-radius: 1rem;
        text-align: center;
        transition: all 0.3s ease;
    }
    .team-card:hover { border-color: var(--primary); box-shadow: var(--shadow-md); }
    .team-avatar {
        width: 80px;
        height: 80px;
        background: #f1f5f9;
        color: var(--primary);
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
    }
    .team-card h4 { margin: 0; font-size: 1.1rem; font-weight: 700; color: #1e293b; }
    .team-card p { margin: 0.5rem 0 0; color: var(--primary); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; }
</style>
@endsection
