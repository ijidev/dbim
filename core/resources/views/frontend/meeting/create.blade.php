@extends('layouts.app')

@section('title', 'Create Meeting')

@push('styles')
<style>
    .create-container {
        max-width: 600px;
        margin: 3rem auto;
        padding: 0 1rem;
    }
    .create-card {
        background: white;
        border-radius: 1.5rem;
        padding: 2.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .form-group { margin-bottom: 1.5rem; }
    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #374151;
    }
    .form-input {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        font-size: 1rem;
        font-family: inherit;
    }
    .form-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(23, 84, 207, 0.1);
    }
    .type-selector {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    .type-option {
        padding: 1.25rem;
        border: 2px solid #e2e8f0;
        border-radius: 0.75rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .type-option:hover { border-color: #cbd5e1; }
    .type-option.active {
        border-color: var(--primary-color);
        background: #eff6ff;
    }
    .type-option input { display: none; }
    .type-icon { font-size: 2rem; margin-bottom: 0.5rem; }
    .type-label { font-weight: 700; color: #1e293b; }
</style>
@endpush

@section('content')
<div class="create-container">
    <div class="create-card">
        <h1 style="font-size: 1.75rem; font-weight: 800; color: #1e293b; margin-bottom: 2rem; text-align: center;">Create a Meeting</h1>
        
        <form action="{{ route('meeting.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Meeting Title</label>
                <input type="text" name="title" class="form-input" placeholder="e.g., Weekly Prayer Session" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Description (Optional)</label>
                <textarea name="description" class="form-input" rows="3" placeholder="Brief description of the meeting..."></textarea>
            </div>
            
            <div class="form-group">
                <label class="form-label">Meeting Type</label>
                <div class="type-selector">
                    <label class="type-option active" id="instant-option">
                        <input type="radio" name="type" value="instant" checked>
                        <div class="type-icon">⚡</div>
                        <div class="type-label">Start Now</div>
                    </label>
                    <label class="type-option" id="scheduled-option">
                        <input type="radio" name="type" value="scheduled">
                        <div class="type-icon">📅</div>
                        <div class="type-label">Schedule</div>
                    </label>
                </div>
            </div>
            
            <div class="form-group" id="schedule-field" style="display: none;">
                <label class="form-label">Schedule Date & Time</label>
                <input type="datetime-local" name="scheduled_at" class="form-input">
            </div>
            
            <button type="submit" style="width: 100%; background: var(--primary-color); color: white; border: none; padding: 1rem; border-radius: 0.75rem; font-weight: 700; font-size: 1rem; cursor: pointer;">
                Create Meeting
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const typeOptions = document.querySelectorAll('.type-option');
    const scheduleField = document.getElementById('schedule-field');
    
    typeOptions.forEach(option => {
        option.addEventListener('click', function() {
            typeOptions.forEach(o => o.classList.remove('active'));
            this.classList.add('active');
            
            if (this.querySelector('input').value === 'scheduled') {
                scheduleField.style.display = 'block';
            } else {
                scheduleField.style.display = 'none';
            }
        });
    });
</script>
@endpush
