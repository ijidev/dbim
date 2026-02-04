@extends('admin.layouts.app')

@section('title', 'Edit Course')

@section('content')
    <div style="max-width: 800px;">
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('courses.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.875rem; display: inline-flex; align-items: center; gap: 0.5rem;">
                ← Back to Courses
            </a>
            <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0.5rem 0 0;">Edit Course</h2>
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
            <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label class="form-label">Course Title *</label>
                    <input type="text" name="title" class="form-input" value="{{ old('title', $course->title) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Description *</label>
                    <textarea name="description" class="form-input" rows="4" required>{{ old('description', $course->description) }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Price (₦)</label>
                        <input type="number" name="price" class="form-input" value="{{ old('price', $course->price) }}" min="0" step="0.01">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Instructor</label>
                        <select name="instructor_id" class="form-input">
                            <option value="">Select Instructor</option>
                            @foreach(\App\Models\User::where('role', 'instructor')->orWhere('role', 'admin')->get() as $user)
                                <option value="{{ $user->id }}" {{ $course->instructor_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Thumbnail Image</label>
                    @if($course->thumbnail)
                        <div style="margin-bottom: 1rem;">
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Current thumbnail" style="max-width: 200px; border-radius: 0.5rem;">
                        </div>
                    @endif
                    <input type="file" name="thumbnail" class="form-input" accept="image/*">
                </div>

                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                        <input type="checkbox" name="is_published" value="1" {{ $course->is_published ? 'checked' : '' }} style="width: 1.25rem; height: 1.25rem;">
                        <span class="form-label" style="margin: 0;">Published</span>
                    </label>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary">Update Course</button>
                    <a href="{{ route('courses.content', $course->id) }}" class="btn btn-outline">Manage Content</a>
                    <a href="{{ route('courses.index') }}" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
