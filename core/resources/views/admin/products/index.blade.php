@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0;">All Products</h2>
            <p style="color: #64748b; margin: 0.25rem 0 0;">Manage store products</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Add Product</a>
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
                        <th>Product</th>
                        <th>Price</th>
                        <th class="hide-mobile">Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 0.5rem;">
                                @else
                                    <div style="width: 40px; height: 40px; background: #f1f5f9; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">🛍️</div>
                                @endif
                                <div>
                                    <div style="font-weight: 600;">{{ $product->name }}</div>
                                    <div style="font-size: 0.8125rem; color: #64748b;">{{ $product->category ?? 'Uncategorized' }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-weight: 600;">₦{{ number_format($product->price, 2) }}</td>
                        <td class="hide-mobile">{{ $product->stock ?? '∞' }}</td>
                        <td>
                            @if($product->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge" style="background: #f1f5f9; color: #64748b;">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-outline" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem;">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem; color: #ef4444; border-color: #fecaca;" onclick="return confirm('Delete product?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 3rem; color: #94a3b8;">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">🛍️</div>
                            No products found. <a href="{{ route('admin.products.create') }}" style="color: var(--primary-color); font-weight: 600;">Add your first product</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div style="margin-top: 1.5rem;">
        {{ $products->links() }}
    </div>
@endsection
