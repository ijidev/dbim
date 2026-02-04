@extends('layouts.app')

@push('styles')
<style>
    .product-details-container {
        max-width: 1100px;
        margin: 4rem auto;
        padding: 0 1rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 4rem;
    }
    .product-gallery {
        background: #f8fafc;
        border-radius: 1.5rem;
        aspect-ratio: 4 / 5;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .product-gallery img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .badge-type {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        background: #eff6ff;
        color: var(--primary-color);
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1rem;
    }
    .price-tag {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1e293b;
        margin: 1.5rem 0;
    }
</style>
@endpush

@section('content')
<div class="product-details-container">
    <div class="product-gallery">
        @if($product->image)
            <img src="{{ asset('assets/images/products/' . $product->image) }}" alt="{{ $product->title }}">
        @else
            <span style="font-size: 8rem; opacity: 0.1;">📦</span>
        @endif
    </div>

    <div>
        <span class="badge-type">{{ $product->type }}</span>
        <h1 style="font-size: 3rem; font-weight: 800; color: #1e293b; letter-spacing: -0.025em; margin: 0;">{{ $product->title }}</h1>
        
        <div class="price-tag">₦{{ number_format($product->price, 2) }}</div>
        
        <div style="margin-bottom: 3rem; line-height: 1.8; color: #475569; font-size: 1.1rem;">
            {!! nl2br(e($product->description)) !!}
        </div>

        <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            <button type="submit" style="background: var(--primary-color); color: white; border: none; padding: 1.25rem 3rem; border-radius: 0.75rem; font-weight: 700; font-size: 1.125rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                Add to Cart
            </button>
        </form>

        <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #e2e8f0; display: flex; gap: 2rem;">
            <div>
                <span style="display: block; font-size: 0.875rem; color: #94a3b8; font-weight: 600;">Stock</span>
                <span style="font-weight: 700;">{{ $product->stock }} available</span>
            </div>
            <div>
                <span style="display: block; font-size: 0.875rem; color: #94a3b8; font-weight: 600;">Delivery</span>
                <span style="font-weight: 700;">2-4 business days</span>
            </div>
        </div>
    </div>
</div>

<div style="max-width: 1100px; margin: 0 auto 6rem; padding: 0 1rem;">
    <h2 style="font-size: 1.5rem; font-weight: 800; color: #1e293b; margin-bottom: 2rem;">Related Materials</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 2rem;">
        @foreach($relatedProducts as $related)
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 1rem; overflow: hidden;">
                <a href="{{ route('store.show', $related->slug) }}" style="text-decoration: none;">
                    <div style="height: 200px; background: #f8fafc; display: flex; align-items: center; justify-content: center;">
                        <span style="font-size: 3rem; opacity: 0.2;">📦</span>
                    </div>
                    <div style="padding: 1rem;">
                        <h4 style="margin: 0; color: #1e293b; font-weight: 700;">{{ $related->title }}</h4>
                        <p style="margin: 0.25rem 0 0; color: var(--primary-color); font-weight: 700;">₦{{ number_format($related->price, 2) }}</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
