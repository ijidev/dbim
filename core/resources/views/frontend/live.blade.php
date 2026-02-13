@extends('layouts.app')

@section('title', 'Live Stream & Community')

@push('styles')
<link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
<style>
    .fill-1 { font-variation-settings: 'FILL' 1; }
    
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    
    .video-js {
        width: 100%;
        height: 100%;
    }
</style>
@endpush

@section('content')
<main class="mx-auto flex w-full max-w-[1440px] flex-1 flex-col gap-8 p-6 lg:p-10 lg:flex-row bg-slate-50 min-h-screen">
    <!-- Left Side: Streaming Player & Content -->
    <div class="flex flex-1 flex-col gap-6">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 px-1 py-1 text-sm font-bold uppercase tracking-widest text-slate-400">
            <a class="hover:text-primary transition-colors" href="{{ route('home') }}">Home</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-primary font-black">Live Stream</span>
        </nav>

        <!-- Media Player Wrapper -->
        <div class="overflow-hidden rounded-3xl bg-black shadow-2xl relative shadow-primary/10 border border-slate-200/50 group">
            <div class="aspect-video w-full bg-slate-900 relative">
                @if(isset($is_live->value) && $is_live->value == '1')
                    <div class="absolute left-6 top-6 z-20 flex items-center gap-3">
                        <span class="flex items-center gap-2 rounded-full bg-red-600 px-4 py-1.5 text-[10px] font-black uppercase tracking-widest text-white shadow-lg shadow-red-600/20">
                            <span class="size-2 animate-pulse rounded-full bg-white"></span>
                            Live Now
                        </span>
                        <span class="flex items-center gap-2 rounded-full bg-black/40 px-4 py-1.5 text-[10px] font-black text-white backdrop-blur-md border border-white/10 uppercase tracking-widest">
                            <span class="material-symbols-outlined text-[16px]">visibility</span>
                            Online Congregation
                        </span>
                    </div>

                    @if(($source_type->value ?? 'embed') == 'embed')
                        <div class="w-full h-full">
                            @if(isset($live_settings->value) && $live_settings->value)
                                {!! $live_settings->value !!}
                            @else
                                <div class="h-full flex flex-col items-center justify-center gap-4 text-slate-500">
                                    <span class="material-symbols-outlined text-6xl opacity-20">videocam_off</span>
                                    <p class="font-black text-sm uppercase tracking-widest">Embed not configured</p>
                                </div>
                            @endif
                        </div>
                    @else
                        @if(isset($playback_url->value) && $playback_url->value)
                            <video id="live-video" class="video-js vjs-big-play-centered vjs-fluid" controls preload="auto">
                                <source src="{{ $playback_url->value }}" type="application/x-mpegURL">
                            </video>
                        @else
                            <div class="h-full flex flex-col items-center justify-center gap-4 text-slate-500">
                                <span class="material-symbols-outlined text-6xl opacity-20">cloud_off</span>
                                <p class="font-black text-sm uppercase tracking-widest">Direct stream not configured</p>
                            </div>
                        @endif
                    @endif
                @else
                    <!-- Offline State -->
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-12 bg-slate-950">
                        <div class="size-32 rounded-full bg-primary/5 mb-8 flex items-center justify-center border border-primary/10">
                            <span class="material-symbols-outlined text-7xl text-primary opacity-50 font-light">podcasts</span>
                        </div>
                        <h2 class="text-white text-4xl font-black mb-4 tracking-tight">Broadcast Offline</h2>
                        <p class="text-slate-400 max-w-md font-medium text-lg leading-relaxed">We aren't broadcasting right now. Join us for our next scheduled service.</p>
                        <a href="{{ route('events.index') }}" class="mt-10 bg-primary text-white px-10 h-14 rounded-2xl font-black flex items-center gap-3 transition-all hover:scale-105 shadow-xl shadow-primary/20">
                            <span class="material-symbols-outlined">history</span>
                            Explore Archives
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Reactions & Share Bar -->
        <div class="flex flex-wrap items-center justify-between rounded-3xl bg-white p-4 shadow-sm border border-slate-100 px-6">
            <div class="flex flex-wrap items-center gap-2 lg:gap-6">
                <!-- Reactions (Functional in V2) -->
                <button class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-slate-500 font-black text-xs uppercase tracking-widest transition-all hover:bg-primary/10 hover:text-primary">
                    <span class="material-symbols-outlined text-[20px]">front_hand</span>
                    <span>Amen</span>
                </button>
                <button class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-slate-500 font-black text-xs uppercase tracking-widest transition-all hover:bg-red-50 hover:text-red-500">
                    <span class="material-symbols-outlined text-[20px] fill-1">favorite</span>
                    <span>Love</span>
                </button>
                <button class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-slate-500 font-black text-xs uppercase tracking-widest transition-all hover:bg-blue-50 hover:text-blue-500">
                    <span class="material-symbols-outlined text-[20px]">volunteer_activism</span>
                    <span>Pray</span>
                </button>
                <button class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-slate-500 font-black text-xs uppercase tracking-widest transition-all hover:bg-amber-50 hover:text-amber-500">
                    <span class="material-symbols-outlined text-[20px]">auto_awesome</span>
                    <span>Praise</span>
                </button>
            </div>
            <button class="flex items-center gap-3 rounded-xl bg-slate-100 px-6 py-2.5 text-xs font-black text-slate-900 uppercase tracking-widest transition-colors hover:bg-slate-200">
                <span class="material-symbols-outlined text-[18px]">share</span>
                <span>Share</span>
            </button>
        </div>

        <!-- Sermon Info -->
        <div class="rounded-3xl bg-white p-8 lg:p-10 shadow-sm border border-slate-100">
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-2">
                    <span class="h-px w-8 bg-primary"></span>
                    <span class="text-xs font-black uppercase tracking-[0.2em] text-primary">
                        @if(isset($is_live->value) && $is_live->value == '1')
                            Live Broadcast
                        @else
                            Previous Message
                        @endif
                    </span>
                </div>
                <h1 class="text-3xl lg:text-5xl font-black text-slate-900 leading-tight tracking-tight">
                    @if(isset($is_live->value) && $is_live->value == '1')
                        {{ $latest_sermon->title ?? 'Sunday Service: Worship & Word' }}
                    @else
                        {{ $latest_sermon->title ?? 'Welcome to DBIM Online' }}
                    @endif
                </h1>
            </div>
            
            <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between border-t border-slate-50 pt-8">
                <div class="flex items-center gap-5">
                    <div class="size-14 rounded-2xl bg-primary/10 border-2 border-primary/20 flex items-center justify-center text-primary font-black">
                        {{ isset($latest_sermon) ? substr($latest_sermon->location ?? 'DBIM', 0, 2) : 'DB' }}
                    </div>
                    <div>
                        <p class="font-black text-slate-900">Divine Business Impact Ministry</p>
                        <p class="text-sm font-bold text-slate-400">Transforming Lives Globally</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4">
                    <button class="flex items-center gap-3 rounded-xl border border-slate-200 px-6 h-12 text-sm font-black text-slate-900 hover:bg-slate-50 transition-all">
                        <span class="material-symbols-outlined text-[20px]">description</span>
                        <span>Notes</span>
                    </button>
                    <a href="{{ route('donate') }}" class="flex items-center gap-3 rounded-xl bg-primary px-8 h-12 text-sm font-black text-white shadow-lg shadow-primary/20 hover:shadow-xl transition-all">
                        <span class="material-symbols-outlined fill-1">volunteer_activism</span>
                        <span>Give Online</span>
                    </a>
                </div>
            </div>
            
            <div class="mt-8 prose prose-slate max-w-none">
                <p class="text-slate-500 font-medium text-lg leading-relaxed">
                    @if(isset($is_live->value) && $is_live->value == '1')
                        Join us as we worship and learn from the Word of God together.
                    @else
                        {{ $latest_sermon->description ?? 'Explore our library of sermons and teachings to grow in your faith.' }}
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Right Side: Community Chat -->
    <aside class="flex w-full flex-col gap-6 lg:w-[420px] shrink-0">
        <div class="flex h-[800px] flex-col rounded-3xl bg-white shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <!-- Chat Header -->
            <div class="flex items-center justify-between border-b border-slate-50 p-6 bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-sm">Community Chat</h3>
                    <span class="flex items-center gap-1.5 rounded-full bg-primary/10 px-3 py-1 text-[10px] font-black text-primary border border-primary/10">LIVE</span>
                </div>
                <button class="material-symbols-outlined text-[20px] text-slate-400 hover:text-primary transition-colors">group</button>
            </div>

            <!-- Pinned message -->
            <div class="bg-primary/5 p-5 flex items-start gap-4 border-b border-primary/10">
                <span class="material-symbols-outlined text-primary !text-[18px] mt-0.5 animate-bounce">push_pin</span>
                <div class="text-xs">
                    <p class="font-black text-primary mb-1 uppercase tracking-widest">Welcome to DBIM Online!</p>
                    <p class="text-slate-600 font-medium leading-relaxed">Join the conversation below. Be respectful and let's grow together!</p>
                </div>
            </div>

            <!-- Messages Area -->
            <div class="custom-scrollbar flex-1 overflow-y-auto p-6 space-y-8">
                <div class="flex justify-center">
                    <span class="rounded-full bg-slate-100 px-5 py-1.5 text-[9px] font-black uppercase tracking-[0.2em] text-slate-400">Service Started</span>
                </div>
                
                <div class="flex flex-col items-center justify-center py-12 text-center opacity-40">
                    <span class="material-symbols-outlined text-4xl mb-2">chat_bubble</span>
                    <p class="text-xs font-bold uppercase tracking-widest">Chat is empty</p>
                    <p class="text-[10px] mt-1">Be the first to say something!</p>
                </div>
            </div>

            <!-- Chat Input -->
            <div class="border-t border-slate-50 p-6 bg-slate-50/30">
                <div class="relative">
                    <textarea class="w-full resize-none rounded-2xl border-slate-100 bg-white p-4 pr-16 text-sm font-medium focus:border-primary/30 focus:ring-0 placeholder-slate-300 shadow-sm" placeholder="Type your message..." rows="2"></textarea>
                    <button class="absolute bottom-3 right-3 flex size-10 items-center justify-center rounded-xl bg-primary text-white hover:bg-primary-dark transition-all shadow-lg shadow-primary/20">
                        <span class="material-symbols-outlined !text-[20px] translate-x-0.5">send</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Upcoming Promo -->
        <div class="group relative overflow-hidden rounded-3xl bg-slate-900 p-8 text-white shadow-2xl transition-all hover:scale-[1.02]">
            <div class="relative z-10">
                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-primary">Next Session</span>
                <h4 class="mt-2 text-xl font-black tracking-tight">{{ $next_event->title ?? 'Ministry Academy' }}</h4>
                <p class="mt-1 text-sm text-slate-400 font-bold uppercase tracking-widest">
                    @if(isset($next_event))
                        {{ \Carbon\Carbon::parse($next_event->date)->format('l, g:i A') }}
                    @else
                        Coming Soon
                    @endif
                </p>
                <a href="{{ isset($next_event) ? route('event.single', $next_event->id) : route('events.index') }}" class="mt-6 w-full rounded-xl bg-white/10 py-3 text-xs font-black text-white transition-all hover:bg-white hover:text-slate-900 uppercase tracking-widest flex items-center justify-center">Register Now</a>
            </div>
            <div class="absolute -right-8 -top-8 size-40 rounded-full bg-primary/20 blur-3xl transition-all group-hover:bg-primary/40"></div>
        </div>
    </aside>
</main>
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
