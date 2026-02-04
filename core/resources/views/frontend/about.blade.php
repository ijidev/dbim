@extends('layouts.app')

@section('content')
<div style="background-color: #fff; border-bottom: 1px solid #e2e8f0; padding: 4rem 1rem; text-align: center;">
    <h1 style="font-size: 3rem; font-weight: 800; color: #1e293b; letter-spacing: -0.05em; margin-bottom: 1rem;">We Are DBIM</h1>
    <p style="color: #64748b; max-width: 800px; margin: 0 auto; font-size: 1.25rem; line-height: 1.6;">Producing Mighty People and Nations For Christ, raising gods among men for God's Kingdom and Dominion on Earth.</p>
</div>

<div style="padding: 4rem 1rem; max-width: 1000px; margin: 0 auto;">
    <div style="margin-bottom: 4rem; text-align: center;">
        <blockquote style="font-size: 1.5rem; font-style: italic; color: #334155; border-left: 4px solid var(--primary-color); padding-left: 2rem; margin: 0; display: inline-block; text-align: left;">
            "be thou the mother of thousands of millions, and let thy seed possess the gate of those which hate them."
            <footer style="margin-top: 0.5rem; font-size: 1rem; color: #64748b; font-weight: 600;">— Genesis 24:60b KJV</footer>
        </blockquote>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem; margin-bottom: 4rem;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Our Purpose</h2>
            <p style="color: #475569; line-height: 1.7;">To establish a divine mandate and vision that empowers believers to walk in their true identity in Christ, fostering a culture of kingdom dominion and spiritual growth.</p>
        </div>
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Our Mission</h2>
            <p style="color: #475569; line-height: 1.7;">Raising a generation of fire-branded believers equipped with the word and spirit to transform societies and impact generations for the glory of God.</p>
        </div>
    </div>

    <div style="background: #f8fafc; border-radius: 1.5rem; padding: 3rem; margin-bottom: 4rem;">
        <h2 style="text-align: center; font-size: 2rem; font-weight: 800; color: #1e293b; margin-bottom: 3rem;">Our Core Values</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem;">
            <div style="text-align: center;">
                <div style="font-size: 2rem; margin-bottom: 1rem;">✝️</div>
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">Identity in Christ</h3>
                <p style="font-size: 0.9rem; color: #64748b;">Understanding who we are in Him.</p>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 2rem; margin-bottom: 1rem;">🏠</div>
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">Church Is Family</h3>
                <p style="font-size: 0.9rem; color: #64748b;">Bound by love and shared purpose.</p>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 2rem; margin-bottom: 1rem;">🌍</div>
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">Kingdom Culture</h3>
                <p style="font-size: 0.9rem; color: #64748b;">Living heaven's principles on earth.</p>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 2rem; margin-bottom: 1rem;">🕊️</div>
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">Spirit Led Life</h3>
                <p style="font-size: 0.9rem; color: #64748b;">Walking in the power of the Holy Spirit.</p>
            </div>
        </div>
    </div>

    <div style="text-align: center;">
        <h2 style="font-size: 2rem; font-weight: 800; color: #1e293b; margin-bottom: 3rem;">Meet Our Team</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
            {{-- This would eventually come from a database --}}
            @php
                $team = [
                    ['name' => 'Jonathan Doe', 'role' => 'Lead Pastor', 'image' => 'user-01.jpg'],
                    ['name' => 'Jane Doe', 'role' => 'Lead Pastor', 'image' => 'user-02.jpg'],
                    ['name' => 'Charles Spurgeon', 'role' => 'Associate Pastor', 'image' => 'user-03.jpg'],
                    ['name' => 'Martin Luther', 'role' => 'Associate Pastor', 'image' => 'user-04.jpg'],
                ];
            @endphp
            @foreach($team as $member)
            <div style="background: white; border: 1px solid #e2e8f0; padding: 1.5rem; border-radius: 1rem;">
                <div style="width: 80px; height: 80px; background: #f1f5f9; border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">👤</div>
                <h4 style="margin: 0; font-size: 1.1rem; font-weight: 700;">{{ $member['name'] }}</h4>
                <p style="margin: 0.25rem 0 0; color: var(--primary-color); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">{{ $member['role'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
