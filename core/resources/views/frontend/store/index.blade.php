@extends('layouts.app')

@push('styles')
<style>
    .store-hero {
        background: white;
        border-bottom: 1px solid #e2e8f0;
        padding: 4rem 1rem;
        text-align: center;
    }
    .product-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    }
    .product-image {
        height: 250px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .product-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .product-info {
        padding: 1.5rem;
    }
    .product-price {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--primary-color);
        margin-top: 0.5rem;
    }
    .btn-cart {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        width: 100%;
        margin-top: 1rem;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-cart:hover {
        background: #1a4ebd;
    }
</style>
@endpush

@section('content')
<div class="store-hero">
    <h1 style="font-size: 3rem; font-weight: 800; color: #1e293b; letter-spacing: -0.05em; margin-bottom: 1rem;">Church Store</h1>
    <p style="color: #64748b; max-width: 600px; margin: 0 auto; font-size: 1.15rem;">Get your physical and digital ministry materials here.</p>
</div>

<div style="max-width: 1200px; margin: 4rem auto; padding: 0 1rem;">
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem;">
        @forelse($products as $product)
            <div class="product-card">
                <a href="{{ route('store.show', $product->slug) }}">
                    <div class="product-image">
                        @if($product->image)
                            <img src="{{ asset('assets/images/products/' . $product->image) }}" alt="{{ $product->title }}">
                        @else
                            <span style="font-size: 4rem; opacity: 0.2;">📦</span>
                        @endif
                    </div>
                </a>
                <div class="product-info">
                    <span style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em;">{{ $product->type }}</span>
                    <h3 style="font-size: 1.125rem; font-weight: 700; color: #1e293b; margin: 0.25rem 0;">{{ $product->title }}</h3>
                    <div class="product-price">₦{{ number_format($product->price, 2) }}</div>
                    
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-cart">Add to Cart</button>
                    </form>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 4rem;">
                <p style="color: #64748b;">No products available at the moment.</p>
            </div>
        @endforelse
    </div>

    <div style="margin-top: 4rem;">
        {{ $products->links() }}
    </div>
</div>
@endsection
