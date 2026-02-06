@extends('admin.layouts.app')

@section('title', 'Edit Event')

@section('content')
    <div style="max-width: 800px;">
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('events.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.875rem; display: inline-flex; align-items: center; gap: 0.5rem;">
                ← Back to Events
            </a>
            <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0.5rem 0 0;">Edit Event</h2>
        </div>

        @if($errors->any())
            <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
                <ul style="margin: 0; padding-left: 1.25rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="data-card" style="padding: 2rem;">
            <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label class="form-label">Event Title *</label>
                    <input type="text" name="title" class="form-input" value="{{ old('title', $event->title) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Description *</label>
                    <textarea name="description" class="form-input" rows="4" required>{{ old('description', $event->description) }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Start Date *</label>
                        <input type="date" name="date" class="form-input" value="{{ old('date', $event->date) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Start Time *</label>
                        <input type="time" name="time" class="form-input" value="{{ old('time', $event->time) }}" required>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-input" value="{{ old('end_date', $event->end_date) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">End Time</label>
                        <input type="time" name="end_time" class="form-input" value="{{ old('end_time', $event->end_time) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Location *</label>
                    <input type="text" name="location" class="form-input" value="{{ old('location', $event->location) }}" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Event Type</label>
                        <select name="type" class="form-input">
                            <option value="program" {{ $event->type == 'program' ? 'selected' : '' }}>Program</option>
                            <option value="service" {{ $event->type == 'service' ? 'selected' : '' }}>Service</option>
                            <option value="activity" {{ $event->type == 'activity' ? 'selected' : '' }}>Activity</option>
                        </select>
                    </div>
                <div class="form-group">
                    <label class="form-label">Extra Event Dates (Optional)</label>
                    <textarea name="extra_dates" class="form-input" rows="2" placeholder="e.g. 2026-02-15, 2026-02-22 (Comma-separated)">{{ old('extra_dates', $event->extra_dates) }}</textarea>
                    <div style="margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <input type="checkbox" name="loop_extra_dates" value="1" id="loop_extra" {{ $event->loop_extra_dates ? 'checked' : '' }}>
                        <label for="loop_extra" style="font-size: 0.8125rem; color: #64748b; cursor: pointer;">Loop these dates monthly (Treat as day of month)</label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Event Image</label>
                    @if($event->image)
                        <div style="margin-bottom: 1rem;">
                            <img src="{{ asset($event->image) }}" alt="Current Image" style="max-width: 200px; border-radius: 0.5rem;">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-input" accept="image/*">
                    <p style="font-size: 0.8125rem; color: #64748b; margin-top: 0.5rem;">Leave empty to keep current image</p>
                </div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input">
                        <option value="comming" {{ $event->status == 'comming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="passed" {{ $event->status == 'passed' ? 'selected' : '' }}>Passed</option>
                    </select>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary">Update Event</button>
                    <a href="{{ route('events.index') }}" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
