@extends('admin.layouts.app')

@section('title', 'Books')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0;">All Books</h2>
            <p style="color: #64748b; margin: 0.25rem 0 0;">Manage digital library</p>
        </div>
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">+ Add Book</a>
    </div>

    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="data-card">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Book</th>
                        <th class="hide-mobile">Author</th>
                        <th class="hide-mobile">Category</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" style="width: 30px; height: 40px; object-fit: cover; border-radius: 0.25rem;">
                                @else
                                    <div style="width: 30px; height: 40px; background: #f1f5f9; border-radius: 0.25rem; display: flex; align-items: center; justify-content: center;">📚</div>
                                @endif
                                <div>
                                    <div style="font-weight: 600;">{{ $book->title }}</div>
                                    <div style="font-size: 0.8125rem; color: #64748b;">{{ $book->pages ?? 'N/A' }} pages</div>
                                </div>
                            </div>
                        </td>
                        <td class="hide-mobile">{{ $book->author }}</td>
                        <td class="hide-mobile">{{ $book->category ?? 'General' }}</td>
                        <td>
                            @if($book->is_published)
                                <span class="badge badge-success">Published</span>
                            @else
                                <span class="badge badge-warning">Draft</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-outline" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem;">Edit</a>
                                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem; color: #ef4444; border-color: #fecaca;" onclick="return confirm('Delete book?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 3rem; color: #94a3b8;">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">📚</div>
                            No books found. <a href="{{ route('admin.books.create') }}" style="color: var(--primary-color); font-weight: 600;">Add your first book</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div style="margin-top: 1.5rem;">
        {{ $books->links() }}
    </div>
@endsection
