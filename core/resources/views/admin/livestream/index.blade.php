@extends('admin.layouts.app')

@section('title', 'Live Stream')

@section('content')
    <div style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0;">Live Stream Management</h2>
        <p style="color: #64748b; margin: 0.25rem 0 0;">Configure your church live stream settings</p>
    </div>

    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem;">
        <div class="data-card" style="padding: 2rem;">
            <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 1.5rem;">Broadcast Settings</h3>
            
            <form action="{{ route('livestream.update') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Live Source Type</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <label style="cursor: pointer; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <input type="radio" name="live_source_type" value="embed" {{ ($source_type->value ?? 'embed') == 'embed' ? 'checked' : '' }} onchange="toggleSource('embed')">
                            <span>Social Media Embed</span>
                        </label>
                        <label style="cursor: pointer; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <input type="radio" name="live_source_type" value="direct" {{ ($source_type->value ?? 'embed') == 'direct' ? 'checked' : '' }} onchange="toggleSource('direct')">
                            <span>Direct OBS Stream</span>
                        </label>
                    </div>
                </div>

                <!-- Embed Section -->
                <div id="embed_section" style="display: {{ ($source_type->value ?? 'embed') == 'embed' ? 'block' : 'none' }};">
                    <div class="form-group">
                        <label class="form-label">Embed Code / Live URL</label>
                        <textarea name="embed_code" class="form-input" rows="6" placeholder="Paste your YouTube or Facebook live embed code here...">{{ $live_settings->value ?? '' }}</textarea>
                        <p style="font-size: 0.8125rem; color: #64748b; margin-top: 0.5rem;">
                            Paste the full &lt;iframe&gt; code from YouTube Live or Facebook Live.
                        </p>
                    </div>
                </div>

                <!-- Direct OBS Section -->
                <div id="direct_section" style="display: {{ ($source_type->value ?? 'embed') == 'direct' ? 'block' : 'none' }};">
                    <div class="form-group">
                        <label class="form-label">Server Ingest URL (RTMP)</label>
                        <div style="display: flex; gap: 0.5rem;">
                            <input type="text" name="stream_server_url" id="rtmp_url" class="form-input" value="{{ $stream_url->value ?? $default_url }}" placeholder="rtmp://yourdomain.com/live">
                            <button type="button" class="btn btn-outline" onclick="copyToClipboard('rtmp_url')" style="white-space: nowrap;">Copy</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Stream Key</label>
                        <div style="display: flex; gap: 0.5rem;">
                            <input type="text" id="stream_key" class="form-input" value="{{ $stream_key->value ?? '' }}" readonly>
                            <button type="button" class="btn btn-outline" onclick="copyToClipboard('stream_key')" style="white-space: nowrap;">Copy</button>
                        </div>
                        <button type="submit" name="regenerate_key" value="1" class="btn btn-outline" style="margin-top: 0.5rem; width: 100%; border-color: #fecaca; color: #ef4444;" onclick="return confirm('Regenerating will disconnect your active stream. Proceed?')">🔄 Regenerate Stream Key</button>
                    </div>

                    <div class="form-group">
                        <label class="form-label">HLS Playback URL</label>
                        <input type="text" name="playback_url" class="form-input" value="{{ $playback_url->value ?? '' }}" placeholder="https://yourdomain.com/hls/stream.m3u8">
                        <p style="font-size: 0.8125rem; color: #64748b; margin-top: 0.5rem;">
                            The URL where the web player can find your HLS stream.
                        </p>
                    </div>
                </div>

                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer; padding: 1rem; background: {{ ($live_status->value ?? '0') == '1' ? '#f0fdf4' : '#f8fafc' }}; border: 1px solid {{ ($live_status->value ?? '0') == '1' ? '#86efac' : '#e2e8f0' }}; border-radius: 0.75rem;">
                        <input type="checkbox" name="is_live" value="1" {{ ($live_status->value ?? '0') == '1' ? 'checked' : '' }} style="width: 1.5rem; height: 1.5rem;">
                        <div>
                            <span style="font-weight: 700; font-size: 1rem;">We are LIVE</span>
                            <p style="margin: 0; font-size: 0.8125rem; color: #64748b;">Toggle this on when streaming</p>
                        </div>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    💾 Save Stream Settings
                </button>
            </form>
        </div>

        <div>
            <div class="data-card" style="padding: 2rem; margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 1rem;">Current Status</h3>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    @if(($live_status->value ?? '0') == '1')
                        <div style="width: 16px; height: 16px; background: #22c55e; border-radius: 50%; animation: pulse 2s infinite;"></div>
                        <span style="font-weight: 700; color: #22c55e; font-size: 1.25rem;">LIVE NOW</span>
                    @else
                        <div style="width: 16px; height: 16px; background: #94a3b8; border-radius: 50%;"></div>
                        <span style="font-weight: 600; color: #64748b; font-size: 1.25rem;">Offline</span>
                    @endif
                </div>
            </div>

            <div class="data-card" style="padding: 2rem;">
                <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 1rem;">Preview</h3>
                <div style="aspect-ratio: 16/9; background: #1e293b; border-radius: 0.75rem; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                    @if(($source_type->value ?? 'embed') == 'embed')
                        @if(isset($live_settings->value) && $live_settings->value)
                            {!! $live_settings->value !!}
                        @else
                            <div style="text-align: center; color: #64748b;">
                                <div style="font-size: 3rem; margin-bottom: 0.5rem;">📹</div>
                                <p>No embed configured</p>
                            </div>
                        @endif
                    @else
                        <div style="text-align: center; color: #64748b; padding: 1rem;">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">📡</div>
                            <p style="font-size: 0.875rem;">Direct Stream Preview is only available on the user-facing side via HLS player.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSource(type) {
            document.getElementById('embed_section').style.display = type === 'embed' ? 'block' : 'none';
            document.getElementById('direct_section').style.display = type === 'direct' ? 'block' : 'none';
        }

        function copyToClipboard(id) {
            const el = document.getElementById(id);
            el.select();
            document.execCommand('copy');
            alert('Copied to clipboard!');
        }
    </script>

    <style>
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
@endsection
