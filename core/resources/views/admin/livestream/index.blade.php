@extends('admin.layouts.app')

@section('title', 'Control Room')

@push('styles')
<style>
    .fill-1 { font-variation-settings: 'FILL' 1; }
    
    .broadcast-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 2rem;
    }
    
    @media (max-width: 1280px) {
        .broadcast-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .animate-pulse-slow {
        animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }
</style>
@endpush

@section('content')
<div class="max-w-[1400px] mx-auto space-y-8">
    <!-- Header: Professional Control Room Style -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 bg-slate-900 p-8 rounded-[2rem] text-white shadow-2xl relative overflow-hidden">
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-2">
                <span class="size-2 rounded-full {{ ($live_status->value ?? '0') == '1' ? 'bg-red-500 animate-pulse' : 'bg-slate-500' }}"></span>
                <span class="text-[10px] font-black uppercase tracking-[0.3em] {{ ($live_status->value ?? '0') == '1' ? 'text-red-500' : 'text-slate-400' }}">
                    {{ ($live_status->value ?? '0') == '1' ? 'Broadcasting Live' : 'Studio Offline' }}
                </span>
            </div>
            <h2 class="text-4xl font-black tracking-tight flex items-center gap-4">
                Global Control Room
                <span class="px-3 py-1 bg-white/10 rounded-lg text-xs font-black uppercase tracking-widest text-primary border border-white/5">v2.1</span>
            </h2>
            <p class="text-slate-400 font-medium mt-1">Configure and monitor your ministry's digital presence across all platforms.</p>
        </div>
        
        <div class="flex items-center gap-3 relative z-10">
            <div class="flex flex-col items-end mr-4">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Community Reach</p>
                <p class="font-black text-primary text-xl">{{ number_format($total_users ?? 0) }} <span class="text-xs text-slate-400">Members</span></p>
            </div>
            <button class="size-14 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-white/10 transition-all">
                <span class="material-symbols-outlined">settings</span>
            </button>
        </div>
        
        <!-- Abstract Background Pattern -->
        <div class="absolute right-0 top-0 w-1/2 h-full bg-gradient-to-l from-primary/10 to-transparent pointer-events-none"></div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 p-6 rounded-2xl flex items-center gap-4 font-black text-sm uppercase tracking-widest animate-in fade-in slide-in-from-top-4">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <div class="broadcast-grid">
        <!-- Main Configuration Area -->
        <div class="space-y-8">
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-10 py-8 border-b border-slate-50 bg-slate-50/30 flex items-center justify-between">
                    <div>
                        <h3 class="font-black text-slate-900 uppercase tracking-widest text-sm mb-1">Source Configuration</h3>
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-widest">Select your delivery protocol</p>
                    </div>
                    <span class="material-symbols-outlined text-slate-300">hub</span>
                </div>
                
                <div class="p-10">
                    <form action="{{ route('livestream.update') }}" method="POST" class="space-y-8">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <label class="relative group cursor-pointer">
                                <input type="radio" name="live_source_type" value="embed" class="peer sr-only" {{ ($source_type->value ?? 'embed') == 'embed' ? 'checked' : '' }} onchange="toggleSource('embed')">
                                <div class="p-8 rounded-3xl border-2 border-slate-100 bg-white transition-all peer-checked:border-primary peer-checked:bg-primary/5 group-hover:border-slate-200">
                                    <div class="size-14 rounded-2xl bg-slate-50 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                                        <span class="material-symbols-outlined text-3xl text-slate-400 group-peer-checked:text-primary">integration_instructions</span>
                                    </div>
                                    <h4 class="font-black text-slate-900 text-lg mb-2">Social Embed</h4>
                                    <p class="text-xs text-slate-400 font-medium leading-relaxed">Best for YouTube, Facebook, or TikTok live integrations.</p>
                                </div>
                                <div class="absolute top-6 right-6 opacity-0 peer-checked:opacity-100 transition-opacity">
                                    <span class="material-symbols-outlined text-primary fill-1">check_circle</span>
                                </div>
                            </label>

                            <label class="relative group cursor-pointer">
                                <input type="radio" name="live_source_type" value="direct" class="peer sr-only" {{ ($source_type->value ?? 'embed') == 'direct' ? 'checked' : '' }} onchange="toggleSource('direct')">
                                <div class="p-8 rounded-3xl border-2 border-slate-100 bg-white transition-all peer-checked:border-primary peer-checked:bg-primary/5 group-hover:border-slate-200">
                                    <div class="size-14 rounded-2xl bg-slate-50 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                                        <span class="material-symbols-outlined text-3xl text-slate-400 group-peer-checked:text-primary">settings_input_antenna</span>
                                    </div>
                                    <h4 class="font-black text-slate-900 text-lg mb-2">Direct Studio</h4>
                                    <p class="text-xs text-slate-400 font-medium leading-relaxed">Direct OBS/vMix integration via RTMP protocols.</p>
                                </div>
                                <div class="absolute top-6 right-6 opacity-0 peer-checked:opacity-100 transition-opacity">
                                    <span class="material-symbols-outlined text-primary fill-1">check_circle</span>
                                </div>
                            </label>
                        </div>

                        <!-- Embed Input -->
                        <div id="embed_section" class="space-y-4 pt-4 border-t border-slate-50" style="display: {{ ($source_type->value ?? 'embed') == 'embed' ? 'block' : 'none' }};">
                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Embed Payload (iFrame Code)</label>
                                <textarea name="embed_code" class="w-full rounded-2xl border-slate-100 bg-slate-50/50 p-6 text-sm font-medium focus:border-primary/30 focus:ring-0 placeholder-slate-300 min-h-[200px]" placeholder="Paste embed code from YouTube/Facebook...">{{ $live_settings->value ?? '' }}</textarea>
                            </div>
                        </div>

                        <!-- Direct RTMP Input -->
                        <div id="direct_section" class="space-y-8 pt-4 border-t border-slate-50" style="display: {{ ($source_type->value ?? 'embed') == 'direct' ? 'block' : 'none' }};">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="flex flex-col gap-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Ingest Endpoint (RTMP)</label>
                                    <div class="relative">
                                        <input type="text" id="rtmp_url" value="{{ $stream_url->value ?? $default_url }}" readonly class="w-full h-14 rounded-2xl border-slate-100 bg-slate-50 p-4 pr-16 text-sm font-bold text-slate-600 focus:outline-none">
                                        <button type="button" onclick="copyToClipboard('rtmp_url')" class="absolute top-2 right-2 size-10 flex items-center justify-center hover:bg-slate-200 rounded-xl transition-colors text-slate-400">
                                            <span class="material-symbols-outlined text-[18px]">content_copy</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Streaming Token</label>
                                    <div class="relative">
                                        <input type="password" id="stream_key" value="{{ $stream_key->value ?? '' }}" readonly class="w-full h-14 rounded-2xl border-slate-100 bg-slate-50 p-4 pr-16 text-sm font-bold text-slate-600 focus:outline-none">
                                        <button type="button" onclick="copyToClipboard('stream_key')" class="absolute top-2 right-2 size-10 flex items-center justify-center hover:bg-slate-200 rounded-xl transition-colors text-slate-400">
                                            <span class="material-symbols-outlined text-[18px]">key</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">HLS Playback Target</label>
                                <input type="text" name="playback_url" value="{{ $playback_url->value ?? '' }}" class="w-full h-14 rounded-2xl border-slate-100 bg-slate-50 p-4 text-sm font-bold placeholder-slate-300" placeholder="https://studio.dbim.org/hls/master.m3u8">
                            </div>
                        </div>

                        <!-- Live Status Toggle -->
                        <div class="p-8 rounded-[2rem] {{ ($live_status->value ?? '0') == '1' ? 'bg-red-50 border-red-100' : 'bg-slate-50 border-slate-100' }} border-2 flex items-center justify-between transition-colors">
                            <div class="flex items-center gap-6">
                                <div class="size-16 rounded-3xl {{ ($live_status->value ?? '0') == '1' ? 'bg-white text-red-500' : 'bg-white text-slate-400' }} flex items-center justify-center shadow-sm">
                                    <span class="material-symbols-outlined text-3xl font-light {{ ($live_status->value ?? '0') == '1' ? 'animate-pulse' : '' }}">sensors</span>
                                </div>
                                <div>
                                    <h4 class="font-black text-slate-900 text-lg">Broadcast Master Switch</h4>
                                    <p class="text-xs text-slate-500 font-medium uppercase tracking-widest">Toggle visibility for your global audience</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer scale-125 mr-4">
                                <input type="checkbox" name="is_live" value="1" {{ ($live_status->value ?? '0') == '1' ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-14 h-8 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-red-500"></div>
                            </label>
                        </div>

                        <button type="submit" class="w-full h-16 bg-primary text-white rounded-[1.5rem] font-black text-sm uppercase tracking-[0.2em] shadow-2xl shadow-primary/30 hover:shadow-primary/40 hover:scale-[1.01] transition-all flex items-center justify-center gap-3">
                            <span class="material-symbols-outlined">save</span>
                            Push Changes to Production
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Monitoring -->
        <div class="space-y-8">
            <!-- Studio Preview -->
            <div class="bg-slate-900 rounded-[2rem] overflow-hidden shadow-2xl border border-white/5">
                <div class="px-8 py-6 border-b border-white/5 bg-white/5 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="size-2 rounded-full bg-red-500"></span>
                        <h3 class="font-black text-white uppercase tracking-widest text-[10px]">Studio Preview</h3>
                    </div>
                    <span class="text-[9px] font-black text-white/30 uppercase tracking-[0.2em]">HD Monitor 01</span>
                </div>
                <div class="aspect-video bg-black relative flex items-center justify-center group">
                    @if(($source_type->value ?? 'embed') == 'embed')
                        @if(isset($live_settings->value) && $live_settings->value)
                            <div class="w-full h-full scale-[1.01]">
                                {!! $live_settings->value !!}
                            </div>
                        @else
                            <div class="text-center group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-6xl text-white/10 font-light mb-4">linked_camera</span>
                                <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.3em]">No Signal Detected</p>
                            </div>
                        @endif
                    @else
                        <div class="text-center p-8">
                            <span class="material-symbols-outlined text-5xl text-primary font-light mb-4 animate-pulse-slow">satellite_alt</span>
                            <p class="text-[10px] font-black text-white/40 uppercase tracking-[0.3em] leading-relaxed">Direct Link Monitoring<br><span class="text-white/20 mt-1 block">Inspect HLS endpoint for signal validation</span></p>
                        </div>
                    @endif
                    
                    <!-- Scanline Overlay -->
                    <div class="absolute inset-0 pointer-events-none bg-[linear-gradient(rgba(18,16,16,0)_50%,rgba(0,0,0,0.25)_50%),linear-gradient(90deg,rgba(255,0,0,0.06),rgba(0,255,0,0.02),rgba(0,0,255,0.06))] bg-[length:100%_4px,3px_100%] opacity-10"></div>
                </div>
            </div>

            <!-- Health Stats -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Latency</p>
                    <p class="text-xl font-black text-slate-900">42ms</p>
                    <div class="mt-2 h-1 w-full bg-slate-50 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 w-[85%]"></div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Dropped</p>
                    <p class="text-xl font-black text-slate-900">0.0%</p>
                    <div class="mt-2 h-1 w-full bg-slate-50 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 w-0"></div>
                    </div>
                </div>
            </div>

            <!-- Global Distribution -->
            <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm">
                <h4 class="font-black text-slate-900 uppercase tracking-widest text-xs mb-6">Distribution Map</h4>
                <div class="size-full aspect-[4/3] bg-slate-50 rounded-2xl flex flex-col items-center justify-center p-6 text-center border border-dashed border-slate-200">
                    <span class="material-symbols-outlined text-4xl text-slate-200 mb-2">language</span>
                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Global Analytics Integration Coming Soon</p>
                </div>
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
        
        // Custom notification could go here
        alert('Credentials copied to clipboard!');
    }
</script>
@endsection
