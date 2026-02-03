@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Course</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $course->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ $course->description }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Price ($)</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" value="{{ $course->price }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="instructor_id" class="form-label">Instructor</label>
                            <select class="form-select" id="instructor_id" name="instructor_id">
                                @foreach(\App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}" {{ $course->instructor_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->role }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Thumbnail (Leave blank to keep current)</label>
                        @if($course->thumbnail)
                            <div class="mb-2">
                                <img src="{{ asset($course->thumbnail) }}" alt="Current Thumbnail" style="height: 100px;">
                            </div>
                        @endif
                        <input type="file" class="form-control" id="thumbnail" name="thumbnail">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_published" name="is_published" value="1" {{ $course->is_published ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_published">Publish immediately?</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Course</button>
                    <a href="{{ route('courses.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
