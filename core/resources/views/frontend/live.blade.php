@extends('layouts.app')

@push('styles')
<link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
<style>
    .live-hub-container {
        background: #0f172a;
        min-height: calc(100vh - 64px);
        color: white;
        padding: 2rem 0;
    }
    .cinema-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    .player-section {
        background: black;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        aspect-ratio: 16 / 9;
        position: relative;
    }
    .status-badge {
        position: absolute;
        top: 1.5rem;
        left: 1.5rem;
        z-index: 10;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .status-live {
        background: #ef4444;
        color: white;
        animation: pulse 2s infinite;
    }
    .status-offline {
        background: #475569;
        color: #cbd5e1;
    }
    .live-details {
        margin-top: 2rem;
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }
    .chat-placeholder {
        background: #1e293b;
        border-radius: 1rem;
        padding: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #94a3b8;
        border: 1px solid #334155;
    }
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.7; }
        100% { opacity: 1; }
    }
    @media (max-width: 1024px) {
        .live-details {
            grid-template-columns: 1fr;
        }
        .live-hub-container {
            padding: 1rem 0;
        }
    }
</style>
@endpush

@section('content')
<div class="live-hub-container">
    <div class="cinema-wrapper">
        <div class="player-section">
            @if(isset($is_live->value) && $is_live->value == '1')
                <div class="status-badge status-live">
                    <span style="width: 8px; height: 8px; background: white; border-radius: 50%;"></span>
                    Live Now
                </div>
                
                @if(($source_type->value ?? 'embed') == 'embed')
                    {{-- Social Media Embed --}}
                    @if(isset($live_settings->value) && $live_settings->value)
                        <div style="width: 100%; height: 100%;">
                            {!! $live_settings->value !!}
                        </div>
                    @else
                        <div style="height: 100%; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                            <span style="font-size: 3rem;">📹</span>
                            <p style="color: #94a3b8; margin-top: 1rem;">Embed not configured</p>
                        </div>
                    @endif
                @else
                    {{-- Direct HLS Stream --}}
                    @if(isset($playback_url->value) && $playback_url->value)
                        <video id="live-video" class="video-js vjs-big-play-centered vjs-fluid" controls preload="auto" width="auto" height="auto">
                            <source src="{{ $playback_url->value }}" type="application/x-mpegURL">
                        </video>
                    @else
                        <div style="height: 100%; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                            <span style="font-size: 3rem;">📡</span>
                            <p style="color: #94a3b8; margin-top: 1rem;">Direct stream not configured</p>
                        </div>
                    @endif
                @endif
            @else
                <div class="status-badge status-offline">Offline</div>
                <div style="height: 100%; display: flex; align-items: center; justify-content: center; flex-direction: column; text-align: center; padding: 2rem;">
                    <span style="font-size: 4rem; margin-bottom: 1.5rem; opacity: 0.5;">📡</span>
                    <h2 style="font-size: 2rem; font-weight: 800; color: white; margin-bottom: 0.5rem;">Join us for our next service</h2>
                    <p style="color: #94a3b8; max-width: 500px;">We aren't broadcasting right now, but you can always catch up on previous messages on our Events page.</p>
                    <a href="{{ route('event') }}" style="margin-top: 2rem; background: var(--primary-color); color: white; padding: 0.75rem 2rem; border-radius: 0.5rem; font-weight: 600; text-decoration: none;">Watch Previous Services</a>
                </div>
            @endif
        </div>

        <div class="live-details">
            <div>
                <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 1rem;">Live Service Broadcast</h1>
                <p style="color: #94a3b8; font-size: 1.125rem; line-height: 1.6;">Experience the glory of God from wherever you are. Join us in worship, prayer, and the transforming word of God. Our live stream connects the global DBIM family in one spirit.</p>
                
                <div style="margin-top: 2.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                    <div style="background: #1e293b; padding: 1.5rem; border-radius: 1rem; flex: 1; min-width: 200px;">
                        <h4 style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--primary-color); margin-bottom: 0.5rem;">Next Broadcast</h4>
                        <p style="font-weight: 700; margin: 0;">Sunday Morning Service</p>
                        <p style="font-size: 0.875rem; color: #94a3b8; margin: 0.25rem 0 0;">8:00 AM WAT</p>
                    </div>
                    <div style="background: #1e293b; padding: 1.5rem; border-radius: 1rem; flex: 1; min-width: 200px;">
                        <h4 style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--primary-color); margin-bottom: 0.5rem;">Ways to Watch</h4>
                        <div style="display: flex; gap: 0.75rem;">
                            <span title="YouTube">📺</span>
                            <span title="Facebook">🌐</span>
                            <span title="TikTok">📱</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="chat-placeholder">
                <div style="font-size: 2rem; margin-bottom: 1rem;">💬</div>
                <h3 style="color: white; font-size: 1.125rem; font-weight: 700; margin-bottom: 0.5rem;">Live Chat</h3>
                <p style="font-size: 0.875rem;">Join the conversation and fellowship with other believers during the live broadcast.</p>
                <div style="width: 100%; height: 1px; background: #334155; margin: 1.5rem 0;"></div>
                <p style="font-size: 0.75rem; color: #64748b;">Chat will be active during the live service.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('live-video')) {
            videojs('live-video');
        }
    });
</script>
@endpush
