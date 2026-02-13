@extends('admin.layouts.app')

@section('title', 'Course Content')

@push('styles')
<style>
    .module-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        margin-bottom: 1rem;
        overflow: hidden;
    }
    .module-header {
        padding: 1.25rem 1.5rem;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }
    .module-header:hover { background: #f1f5f9; }
    .module-title {
        font-weight: 700;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .module-content { padding: 1rem 1.5rem; }
    .lesson-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        margin-bottom: 0.5rem;
        background: white;
    }
    .lesson-item:hover { background: #fafafa; }
    .lesson-info { display: flex; align-items: center; gap: 0.75rem; }
    .lesson-icon {
        width: 36px;
        height: 36px;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }
    .lesson-icon.video { background: #fef2f2; color: #ef4444; }
    .lesson-icon.text { background: #eff6ff; color: #1754cf; }
    .lesson-icon.live { background: #f0fdf4; color: #22c55e; }
    
    /* Modal Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }
    .modal-overlay.active { display: flex; }
    .modal-box {
        background: white;
        border-radius: 1rem;
        width: 100%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
    }
    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-title { font-weight: 700; font-size: 1.125rem; }
    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #64748b;
    }
    .modal-body { padding: 1.5rem; }
    .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }
</style>
@endpush

@section('content')
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('instructor.courses.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.875rem;">← Back to Courses</a>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0;">{{ $course->title }}</h2>
                <p style="color: #64748b; margin: 0.25rem 0 0;">Manage modules and lessons</p>
            </div>
            <button class="btn btn-primary" onclick="openModal('moduleModal')">+ Add Module</button>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    @forelse($course->modules as $module)
        <div class="module-card">
            <div class="module-header" onclick="this.nextElementSibling.classList.toggle('hidden')">
                <div class="module-title">
                    <span style="font-size: 1.25rem;">📁</span>
                    {{ $module->title }}
                    <span class="badge badge-info">{{ $module->lessons->count() }} lessons</span>
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    <button class="btn btn-outline" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem;" onclick="event.stopPropagation(); currentModuleId = {{ $module->id }}; openModal('lessonModal')">+ Lesson</button>
                    <form action="{{ route('instructor.modules.destroy', $module->id) }}" method="POST" style="display: inline;" onclick="event.stopPropagation();">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem; color: #ef4444; border-color: #fecaca;" onclick="return confirm('Delete this module and all its lessons?')">Delete</button>
                    </form>
                </div>
            </div>
            <div class="module-content">
                @forelse($module->lessons as $lesson)
                    <div class="lesson-item">
                        <div class="lesson-info">
                            <div class="lesson-icon {{ $lesson->type == 'video' ? 'video' : ($lesson->type == 'audio' ? 'text' : ($lesson->type == 'text' ? 'text' : 'live')) }}">
                                @if($lesson->type == 'video')
                                    ▶️
                                @elseif($lesson->type == 'audio')
                                    🎵
                                @elseif($lesson->type == 'text')
                                    📄
                                @elseif($lesson->type == 'live_stream')
                                    🔴
                                @else
                                    📹
                                @endif
                            </div>
                            <div>
                                <div style="font-weight: 600;">{{ $lesson->title }}</div>
                                <div style="font-size: 0.8125rem; color: #64748b;">{{ ucfirst(str_replace('_', ' ', $lesson->type)) }}</div>
                            </div>
                            @if($lesson->is_free)
                                <span class="badge badge-success">Free Preview</span>
                            @endif
                        </div>
                        <form action="{{ route('instructor.lessons.destroy', $lesson->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem; color: #ef4444; border-color: #fecaca;" onclick="return confirm('Delete this lesson?')">Delete</button>
                        </form>
                    </div>
                @empty
                    <p style="text-align: center; color: #94a3b8; padding: 1rem;">No lessons in this module yet.</p>
                @endforelse
            </div>
        </div>
    @empty
        <div class="data-card" style="text-align: center; padding: 4rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">📚</div>
            <h3 style="color: #1e293b; margin-bottom: 0.5rem;">No Modules Yet</h3>
            <p style="color: #64748b; margin-bottom: 1.5rem;">Create your first module to start adding lessons.</p>
            <button class="btn btn-primary" onclick="openModal('moduleModal')">+ Create Module</button>
        </div>
    @endforelse

    <!-- Module Modal -->
    <div class="modal-overlay" id="moduleModal">
        <div class="modal-box">
            <div class="modal-header">
                <div class="modal-title">Create Module</div>
                <button class="modal-close" onclick="closeModal('moduleModal')">&times;</button>
            </div>
            <form action="{{ route('instructor.modules.store') }}" method="POST">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Module Title *</label>
                        <input type="text" name="title" class="form-input" placeholder="e.g., Getting Started" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('moduleModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Module</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lesson Modal -->
    <div class="modal-overlay" id="lessonModal">
        <div class="modal-box">
            <div class="modal-header">
                <div class="modal-title">Create Lesson</div>
                <button class="modal-close" onclick="closeModal('lessonModal')">&times;</button>
            </div>
            <form action="{{ route('instructor.lessons.store') }}" method="POST">
                @csrf
                <input type="hidden" name="module_id" id="lessonModuleId">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Lesson Title *</label>
                        <input type="text" name="title" class="form-input" placeholder="e.g., Introduction to Prayer" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Lesson Type</label>
                        <select name="type" class="form-input" id="lessonType" onchange="toggleLessonFields()">
                            <option value="video">Video (YouTube/URL)</option>
                            <option value="audio">Audio Lesson (MP3/URL)</option>
                            <option value="text">Text Content</option>
                            <option value="live_stream">Live Stream</option>
                            <option value="zoom_meeting">Meeting Link</option>
                        </select>
                    </div>
                    <div class="form-group" id="videoField">
                        <label class="form-label" id="mediaLabel">Video/Audio URL</label>
                        <input type="text" name="video_url" class="form-input" placeholder="https://...">
                    </div>
                    <div class="form-group" id="textField" style="display: none;">
                        <label class="form-label">Content</label>
                        <textarea name="content" class="form-input" rows="4" placeholder="Lesson content..."></textarea>
                    </div>
                    <div class="form-group">
                        <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                            <input type="checkbox" name="is_free" value="1" style="width: 1.25rem; height: 1.25rem;">
                            <span>Free Preview (visible without enrollment)</span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('lessonModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Lesson</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let currentModuleId = null;
    
    function openModal(id) {
        document.getElementById(id).classList.add('active');
        if (id === 'lessonModal') {
            document.getElementById('lessonModuleId').value = currentModuleId;
        }
    }
    
    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
    }
    
    function toggleLessonFields() {
        const type = document.getElementById('lessonType').value;
        document.getElementById('videoField').style.display = type === 'text' ? 'none' : 'block';
        document.getElementById('textField').style.display = type === 'text' ? 'block' : 'none';
    }
    
    // Close modal on outside click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.classList.remove('active');
            }
        });
    });
</script>
@endpush
