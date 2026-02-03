@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Content: {{ $course->title }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('courses.index') }}" class="btn btn-sm btn-outline-secondary me-2">Back to Courses</a>
        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createModuleModal">
            <i class="bi bi-folder-plus"></i> Add Module
        </button>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="accordion" id="accordionModules">
            @forelse($course->modules as $module)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $module->id }}">
                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $module->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse{{ $module->id }}">
                            {{ $module->title }}
                        </button>
                    </h2>
                    <div id="collapse{{ $module->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading{{ $module->id }}" data-bs-parent="#accordionModules">
                        <div class="accordion-body">
                            <div class="d-flex justify-content-end mb-2">
                                <button class="btn btn-sm btn-outline-success me-2" data-bs-toggle="modal" data-bs-target="#createLessonModal" onclick="setModuleId({{ $module->id }})">
                                    <i class="bi bi-file-play"></i> Add Lesson
                                </button>
                                <form action="{{ route('modules.destroy', $module->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete module and all lessons?')">
                                        <i class="bi bi-trash"></i> Delete Module
                                    </button>
                                </form>
                            </div>

                            <ul class="list-group">
                                @forelse($module->lessons as $lesson)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-{{ $lesson->type == 'video' ? 'play-circle' : ($lesson->type == 'live_stream' ? 'broadcast' : 'file-text') }} me-2"></i>
                                            {{ $lesson->title }}
                                            @if($lesson->is_free)
                                                <span class="badge bg-success ms-2">Free Preview</span>
                                            @endif
                                        </div>
                                        <div>
                                            <form action="{{ route('lessons.destroy', $lesson->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm text-danger border-0 bg-transparent p-0" onclick="return confirm('Delete lesson?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @empty
                                    <li class="list-group-item text-muted">No lessons yet.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted my-5">No modules found. Create one to get started!</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Create Module Modal -->
<div class="modal fade" id="createModuleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('modules.store') }}" method="POST">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <div class="modal-header">
                    <h5 class="modal-title">Create Module</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="module_title" class="form-label">Module Title</label>
                        <input type="text" class="form-control" id="module_title" name="title" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Module</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Lesson Modal -->
<div class="modal fade" id="createLessonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('lessons.store') }}" method="POST">
                @csrf
                <input type="hidden" id="lesson_module_id" name="module_id">
                <div class="modal-header">
                    <h5 class="modal-title">Create Lesson</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="lesson_title" class="form-label">Lesson Title</label>
                        <input type="text" class="form-control" id="lesson_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="lesson_type" class="form-label">Type</label>
                        <select class="form-select" id="lesson_type" name="type" onchange="toggleLessonFields()">
                            <option value="video">Video (URL)</option>
                            <option value="text">Text Content</option>
                            <option value="live_stream">Live Stream</option>
                            <option value="zoom_meeting">Zoom/Meeting Link</option>
                        </select>
                    </div>
                    <div class="mb-3 field-video field-zoom_meeting field-live_stream">
                        <label for="lesson_video_url" class="form-label">Video/Meeting URL</label>
                        <input type="text" class="form-control" id="lesson_video_url" name="video_url">
                        <small class="text-muted">YouTube link, Zoom Join URL, etc.</small>
                    </div>
                    <div class="mb-3 field-text" style="display:none;">
                        <label for="lesson_content" class="form-label">Content</label>
                        <textarea class="form-control" id="lesson_content" name="content" rows="4"></textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_free" name="is_free" value="1">
                        <label class="form-check-label" for="is_free">Free Preview?</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Lesson</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function setModuleId(id) {
        document.getElementById('lesson_module_id').value = id;
    }

    function toggleLessonFields() {
        const type = document.getElementById('lesson_type').value;
        document.querySelectorAll('.field-video, .field-text').forEach(el => el.style.display = 'none');
        
        if (type === 'text') {
            document.querySelector('.field-text').style.display = 'block';
        } else {
            document.querySelector('.field-video').style.display = 'block';
        }
    }
</script>
@endsection
