@extends('admin.layouts.app')

@section('title', 'Create Course')

@section('content')
    <div style="max-width: 800px;">
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('instructor.courses.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.875rem; display: inline-flex; align-items: center; gap: 0.5rem;">
                ← Back to Courses
            </a>
            <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0.5rem 0 0;">Create New Course</h2>
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
            <form action="{{ route('instructor.courses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Course Title *</label>
                    <input type="text" name="title" class="form-input" placeholder="e.g., Introduction to Prayer" value="{{ old('title') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Description *</label>
                    <textarea name="description" class="form-input" rows="4" placeholder="Describe what students will learn..." required>{{ old('description') }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Price (₦)</label>
                        <input type="number" name="price" class="form-input" placeholder="0 for free" value="{{ old('price', 0) }}" min="0" step="0.01">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Instructor</label>
                        <select name="instructor_id" class="form-input">
                            <option value="">Select Instructor</option>
                            @foreach(\App\Models\User::where('role', 'instructor')->orWhere('role', 'admin')->get() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Thumbnail Image</label>
                    <input type="file" name="thumbnail" class="form-input" accept="image/*">
                    <p style="font-size: 0.8125rem; color: #64748b; margin-top: 0.5rem;">Recommended size: 800x450px</p>
                </div>

                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                        <input type="checkbox" name="is_published" value="1" style="width: 1.25rem; height: 1.25rem;">
                        <span class="form-label" style="margin: 0;">Publish immediately</span>
                    </label>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary">Create Course</button>
                    <a href="{{ route('instructor.courses.index') }}" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
