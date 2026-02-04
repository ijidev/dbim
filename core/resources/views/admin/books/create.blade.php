@extends('admin.layouts.app')

@section('title', 'Add Book')

@section('content')
    <div style="max-width: 900px;">
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('admin.books.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.875rem;">← Back to Books</a>
            <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0.5rem 0 0;">Add New Book</h2>
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
            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Book Title *</label>
                        <input type="text" name="title" class="form-input" placeholder="e.g., The Power of Prayer" value="{{ old('title') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Author *</label>
                        <input type="text" name="author" class="form-input" placeholder="e.g., Pastor John" value="{{ old('author') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-input" rows="3" placeholder="Brief description of the book...">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Content (Full Text) *</label>
                    <textarea name="content" class="form-input" rows="15" placeholder="Paste the full book content here..." required>{{ old('content') }}</textarea>
                    <p style="font-size: 0.8125rem; color: #64748b; margin-top: 0.5rem;">This is the main content that readers will see.</p>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <input type="text" name="category" class="form-input" placeholder="e.g., Devotional" value="{{ old('category') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pages</label>
                        <input type="number" name="pages" class="form-input" placeholder="Approximate page count" value="{{ old('pages') }}" min="1">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Cover Image</label>
                    <input type="file" name="cover_image" class="form-input" accept="image/*">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                            <input type="checkbox" name="is_published" value="1" checked style="width: 1.25rem; height: 1.25rem;">
                            <span>Publish immediately</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                            <input type="checkbox" name="is_free" value="1" checked style="width: 1.25rem; height: 1.25rem;">
                            <span>Free to read</span>
                        </label>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary">Add Book</button>
                    <a href="{{ route('admin.books.index') }}" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
