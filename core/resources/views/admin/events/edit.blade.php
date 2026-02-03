@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Event</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $event->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ $event->description }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ $event->date }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="time" class="form-label">Time</label>
                            <input type="time" class="form-control" id="time" name="time" value="{{ $event->time }}" required>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">End Date (Optional)</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $event->end_date }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_time" class="form-label">End Time (Optional)</label>
                            <input type="time" class="form-control" id="end_time" name="end_time" value="{{ $event->end_time }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" value="{{ $event->location }}" required>
                    </div>
                     <div class="row">
                        <div class="col-md-6 mb-3">
                           <label for="type" class="form-label">Type</label>
                            <select class="form-select" id="type" name="type">
                                <option value="program" {{ $event->type == 'program' ? 'selected' : '' }}>Program</option>
                                <option value="service" {{ $event->type == 'service' ? 'selected' : '' }}>Service</option>
                                <option value="activity" {{ $event->type == 'activity' ? 'selected' : '' }}>Activity</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="recurrence" class="form-label">Recurrence</label>
                            <select class="form-select" id="recurrence" name="recurrence">
                                <option value="none" {{ $event->recurrence == 'none' ? 'selected' : '' }}>None</option>
                                <option value="daily" {{ $event->recurrence == 'daily' ? 'selected' : '' }}>Daily</option>
                                <option value="weekly" {{ $event->recurrence == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="monthly" {{ $event->recurrence == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="yearly" {{ $event->recurrence == 'yearly' ? 'selected' : '' }}>Yearly</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Image (Leave blank to keep current)</label>
                        @if($event->image)
                            <div class="mb-2">
                                <img src="{{ asset($event->image) }}" alt="Current Image" style="height: 100px;">
                            </div>
                        @endif
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="comming" {{ $event->status == 'comming' ? 'selected' : '' }}>Coming</option>
                            <option value="passed" {{ $event->status == 'passed' ? 'selected' : '' }}>Passed</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Event</button>
                    <a href="{{ route('events.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
