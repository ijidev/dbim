@extends('layouts.app')

@push('styles')
<style>
    .library-hero {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 4rem 1rem;
        text-align: center;
    }
    .book-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        overflow: hidden;
        transition: transform 0.2s;
        display: flex;
        flex-direction: column;
    }
    .book-card:hover {
        transform: scale(1.02);
    }
    .book-cover {
        aspect-ratio: 2 / 3;
        background: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .book-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .book-info {
        padding: 1rem;
    }
    .btn-read {
        background: var(--primary-color);
        color: white;
        text-align: center;
        padding: 0.5rem;
        border-radius: 0.25rem;
        display: block;
        font-weight: 600;
        margin-top: 1rem;
        text-decoration: none;
    }
</style>
@endpush

@section('content')
<div class="library-hero">
    <h1 style="font-size: 3.5rem; font-weight: 800; color: #1e293b; letter-spacing: -0.05em; margin-bottom: 1rem;">DBIM Library</h1>
    <p style="color: #64748b; max-width: 600px; margin: 0 auto; font-size: 1.25rem;">Explore spiritual resources, books, and articles to feed your soul.</p>
</div>

<div style="max-width: 1000px; margin: 4rem auto; padding: 0 1rem;">
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 2.5rem;">
        @forelse($books as $book)
            <div class="book-card">
                <div class="book-cover">
                    @if($book->cover_image)
                        <img src="{{ asset('assets/images/books/' . $book->cover_image) }}" alt="{{ $book->title }}">
                    @else
                        <span style="font-size: 3rem; opacity: 0.2;">📚</span>
                    @endif
                </div>
                <div class="book-info">
                    <h3 style="font-size: 1rem; font-weight: 700; color: #1e293b; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $book->title }}</h3>
                    <p style="font-size: 0.85rem; color: #64748b; margin: 0.25rem 0;">{{ $book->author }}</p>
                    <a href="{{ route('library.read', $book->slug) }}" class="btn-read">Read Now</a>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 4rem;">
                <p style="color: #64748b;">The library is currently being stocked. Check back soon!</p>
            </div>
        @endforelse
    </div>

    <div style="margin-top: 4rem;">
        {{ $books->links() }}
    </div>
</div>
@endsection
