@extends('admin.layouts.app')

@section('title', 'Edit Book')

@section('content')
    <div style="max-width: 900px;">
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('admin.books.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.875rem;">← Back to Books</a>
            <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0.5rem 0 0;">Edit Book</h2>
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
            <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Book Title *</label>
                        <input type="text" name="title" class="form-input" value="{{ old('title', $book->title) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Author *</label>
                        <input type="text" name="author" class="form-input" value="{{ old('author', $book->author) }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-input" rows="3">{{ old('description', $book->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Content (Full Text) *</label>
                    <textarea name="content" class="form-input" rows="15" required>{{ old('content', $book->content) }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <input type="text" name="category" class="form-input" value="{{ old('category', $book->category) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pages</label>
                        <input type="number" name="pages" class="form-input" value="{{ old('pages', $book->pages) }}" min="1">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Cover Image</label>
                    @if($book->cover_image)
                        <div style="margin-bottom: 1rem;">
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Current" style="max-width: 100px; border-radius: 0.5rem;">
                        </div>
                    @endif
                    <input type="file" name="cover_image" class="form-input" accept="image/*">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                            <input type="checkbox" name="is_published" value="1" {{ $book->is_published ? 'checked' : '' }} style="width: 1.25rem; height: 1.25rem;">
                            <span>Published</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                            <input type="checkbox" name="is_free" value="1" {{ $book->is_free ? 'checked' : '' }} style="width: 1.25rem; height: 1.25rem;">
                            <span>Free to read</span>
                        </label>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary">Update Book</button>
                    <a href="{{ route('admin.books.index') }}" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
