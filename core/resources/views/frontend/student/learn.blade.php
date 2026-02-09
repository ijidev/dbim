@extends('layouts.app')

@push('styles')
<link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
<style>
    .learn-container {
        display: flex;
        height: calc(100vh - 64px); /* Subtract navbar height */
        overflow: hidden;
        background: #0f172a;
    }
    .learn-sidebar {
        width: 350px;
        background: white;
        border-right: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
    }
    .learn-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        background: #f8fafc;
    }
    .video-wrapper {
        background: black;
        width: 100%;
        aspect-ratio: 16 / 9;
        max-height: 70vh;
    }
    .module-header {
        padding: 1rem 1.5rem;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        font-weight: 700;
        color: #1e293b;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .lesson-item {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        cursor: pointer;
        transition: background 0.2s;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .lesson-item:hover {
        background: #f1f5f9;
    }
    .lesson-item.active {
        background: #eff6ff;
        border-left: 4px solid var(--primary-color);
    }
    .lesson-icon {
        font-size: 1.25rem;
        color: #94a3b8;
    }
    .active .lesson-icon {
        color: var(--primary-color);
    }
    .lesson-title {
        font-size: 0.9375rem;
        font-weight: 500;
        color: #334155;
    }
    .active .lesson-title {
        color: #1e293b;
        font-weight: 600;
    }
    .content-area {
        padding: 3rem;
        max-width: 900px;
        margin: 0 auto;
        width: 100%;
    }
    .course-title-nav {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    @media (max-width: 1024px) {
        .learn-container {
            flex-direction: column;
            height: auto;
            overflow: visible;
        }
        .learn-sidebar {
            width: 100%;
            max-height: 400px;
            border-right: none;
            border-bottom: 1px solid #e2e8f0;
        }
    }
</style>
@endpush

@section('content')
<div class="learn-container">
    <!-- Sidebar -->
    <div class="learn-sidebar">
        <div class="course-title-nav">
            <h2 style="font-size: 1rem; font-weight: 800; margin: 0; color: #1e293b;">{{ $course->title }}</h2>
        </div>
        
        @foreach($course->modules as $module)
            <div class="module-header">{{ $module->title }}</div>
            @foreach($module->lessons as $lesson)
                <div class="lesson-item {{ $loop->parent->first && $loop->first ? 'active' : '' }}" 
                     data-lesson-id="{{ $lesson->id }}"
                     data-title="{{ $lesson->title }}"
                     data-type="{{ $lesson->type }}"
                     data-video="{{ $lesson->video_url }}"
                     data-live="{{ $lesson->live_url }}"
                     data-content="{{ $lesson->content }}">
                    <span class="lesson-icon">
                        @if($lesson->type == 'video') 🎬 @elseif($lesson->type == 'live_stream') 📡 @elseif($lesson->type == 'audio') 🎵 @else 📄 @endif
                    </span>
                    <span class="lesson-title">{{ $lesson->title }}</span>
                </div>
            @endforeach
        @endforeach
    </div>

    <!-- Main Content -->
    <div class="learn-main">
        <div class="video-wrapper" id="player-container">
            {{-- Default state or first lesson --}}
            <div style="height: 100%; display: flex; align-items: center; justify-content: center; color: #64748b; flex-direction: column;">
                <span style="font-size: 4rem; margin-bottom: 1rem;">▶️</span>
                <p>Select a lesson to start learning</p>
            </div>
        </div>

        <div class="content-area">
            <div class="flex items-center justify-between mb-8">
                <h1 id="lesson-title-display" style="font-size: 2.5rem; font-weight: 800; color: #1e293b; margin: 0; letter-spacing: -0.025em;">Course Overview</h1>
                @if($course->instructor)
                <a href="{{ $course->instructor ? route('instructor.profile', $course->instructor->id) : '#' }}" class="flex items-center gap-3 px-4 py-2 bg-white border border-slate-100 rounded-xl text-xs font-black shadow-sm hover:bg-slate-50 transition-all {{ !$course->instructor ? 'pointer-events-none opacity-50' : '' }}">
                    <span class="material-symbols-outlined text-primary text-lg">person</span>
                    <span>By {{ explode(' ', $course->instructor->name)[0] }}</span>
                </a>
                @endif
            </div>
            <div id="lesson-content-display" style="line-height: 1.8; color: #334155; font-size: 1.1rem;">
                <p>{{ $course->description }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lessonItems = document.querySelectorAll('.lesson-item');
        const playerContainer = document.getElementById('player-container');
        const titleDisplay = document.getElementById('lesson-title-display');
        const contentDisplay = document.getElementById('lesson-content-display');

        lessonItems.forEach(item => {
            item.addEventListener('click', function() {
                // UI updates
                lessonItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');

                const data = this.dataset;
                titleDisplay.innerText = data.title;
                
                // Clear container
                playerContainer.innerHTML = '';

                if (data.type === 'video' || data.type === 'live_stream' || data.type === 'audio') {
                    const url = data.video || data.live;
                    if (url) {
                        if (data.type === 'audio') {
                            playerContainer.innerHTML = `
                                <div style="height:100%; display:flex; flex-direction:column; align-items:center; justify-content:center; background:#f8fafc; gap:2rem;">
                                    <div class="size-32 rounded-3xl bg-primary/5 text-primary flex items-center justify-center">
                                        <span class="material-symbols-outlined text-6xl animate-pulse">mic</span>
                                    </div>
                                    <audio controls class="w-2/3 shadow-xl rounded-full" style="accent-color: var(--primary-color)">
                                        <source src="${url}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                            `;
                        } else if (url.includes('youtube.com') || url.includes('youtu.be')) {
                            const videoId = url.includes('v=') ? url.split('v=')[1].split('&')[0] : url.split('/').pop();
                            playerContainer.innerHTML = `<iframe width="100%" height="100%" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe>`;
                        } else {
                            // Video.js for direct links
                            playerContainer.innerHTML = `
                                <video id="my-video" class="video-js vjs-big-play-centered" controls preload="auto" width="640" height="264" style="width:100%; height:100%">
                                    <source src="${url}" type="video/mp4" />
                                </video>
                            `;
                            videojs('my-video');
                        }
                    } else {
                        playerContainer.innerHTML = '<div style="height:100%; display:flex; align-items:center; justify-content:center; color:white">No source provided</div>';
                    }
                    contentDisplay.innerHTML = data.content || '<p>No additional content for this lesson.</p>';
                } else {
                    // Text lesson
                    playerContainer.innerHTML = '<div style="height:100%; display:flex; align-items:center; justify-content:center; color:#64748b; font-size: 3rem;">📄</div>';
                    contentDisplay.innerHTML = data.content || '<p>No content provided.</p>';
                }

                // Scroll to top on mobile
                if (window.innerWidth <= 1024) {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });
        });
    });
</script>
@endpush
