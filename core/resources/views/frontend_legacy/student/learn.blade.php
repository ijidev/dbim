@extends('frontend.layouts.homelayout')

@section('content')
<div class="d-flex flex-column" style="min-height: 100vh;">
    <!-- Course Header -->
    <div class="bg-dark text-white p-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ $course->title }}</h4>
            <a href="{{ route('student.dashboard') }}" class="btn btn-outline-light btn-sm">Back to Dashboard</a>
        </div>
    </div>

    <div class="flex-grow-1 d-flex">
        <!-- Sidebar Navigation -->
        <div class="bg-light border-end" style="width: 300px; overflow-y: auto; height: calc(100vh - 60px);">
            <div class="p-3">
                <h6 class="text-uppercase text-muted fw-bold small">Course Content</h6>
            </div>
            <div class="accordion accordion-flush" id="courseContentAccordion">
                @foreach($course->modules as $module)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $module->id }}">
                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $module->id }}">
                            {{ $module->title }}
                        </button>
                    </h2>
                    <div id="collapse{{ $module->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#courseContentAccordion">
                        <div class="list-group list-group-flush">
                            @foreach($module->lessons as $lesson)
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center lesson-link" 
                               data-title="{{ $lesson->title }}" 
                               data-type="{{ $lesson->type }}" 
                               data-content="{{ $lesson->content }}" 
                               data-video="{{ $lesson->video_url }}"
                               data-live="{{ $lesson->live_url }}">
                                <i class="bi bi-{{ $lesson->type == 'video' ? 'play-circle' : ($lesson->type == 'live_stream' ? 'broadcast' : 'file-text') }} me-2"></i>
                                <span class="small">{{ $lesson->title }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-grow-1 p-0 bg-black d-flex flex-column">
            <div id="player-container" class="flex-grow-1 position-relative d-flex justify-content-center align-items-center">
                <!-- Content will be injected here via JS -->
                <div class="text-white text-center">
                    <i class="bi bi-play-circle display-1"></i>
                    <h3 class="mt-3">Select a lesson to start learning</h3>
                </div>
            </div>
            
            <div class="bg-white p-3 border-top">
                <h4 id="lesson-title-display">Course Introduction</h4>
                <p id="lesson-desc-display" class="text-muted">Select a lesson from the sidebar.</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const playerContainer = document.getElementById('player-container');
    const titleDisplay = document.getElementById('lesson-title-display');
    const links = document.querySelectorAll('.lesson-link');

    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Highlight active
            links.forEach(l => l.classList.remove('active'));
            this.classList.add('active');

            const title = this.dataset.title;
            const type = this.dataset.type;
            const content = this.dataset.content;
            const video = this.dataset.video;
            const live = this.dataset.live; // For zoom/live links

            titleDisplay.innerText = title;

            playerContainer.innerHTML = ''; // Clear current

            if (type === 'video' || type === 'live_stream' || type === 'zoom_meeting') {
                const url = video || live;
                if(url) {
                   // Simple checks to determine if we can embed (Youtube etc)
                   if(url.includes('youtube.com') || url.includes('youtu.be')) {
                       let videoId = '';
                       if(url.includes('youtube.com/watch?v=')) {
                           videoId = url.split('v=')[1].split('&')[0];
                       } else if(url.includes('youtu.be/')) {
                           videoId = url.split('youtu.be/')[1];
                       }
                       playerContainer.innerHTML = `<iframe width="100%" height="100%" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
                   } else {
                       // Fallback for other links (Zoom etc) -> Show button
                       playerContainer.innerHTML = `
                           <div class="text-center text-white">
                                <h3>External Content</h3>
                                <p>This lesson is hosted externally.</p>
                                <a href="${url}" target="_blank" class="btn btn-primary btn-lg mt-2">Open Content <i class="bi bi-box-arrow-up-right"></i></a>
                           </div>
                       `;
                   }
                } else {
                    playerContainer.innerHTML = '<div class="text-white">No video URL provided.</div>';
                }
            } else if (type === 'text') {
                playerContainer.innerHTML = `
                    <div class="container p-5 text-white bg-dark h-100" style="overflow-y: auto; text-align: left;">
                        ${content || 'No content.'}
                    </div>
                `;
            }
        });
    });
});
</script>
@endsection
