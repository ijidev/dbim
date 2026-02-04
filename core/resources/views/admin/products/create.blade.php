@extends('admin.layouts.app')

@section('title', 'Add Product')

@section('content')
    <div style="max-width: 800px;">
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('admin.products.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.875rem;">← Back to Products</a>
            <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0.5rem 0 0;">Add New Product</h2>
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
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Product Name *</label>
                    <input type="text" name="name" class="form-input" placeholder="e.g., Prayer Journal" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Description *</label>
                    <textarea name="description" class="form-input" rows="4" placeholder="Product description..." required>{{ old('description') }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Price (₦) *</label>
                        <input type="number" name="price" class="form-input" value="{{ old('price', 0) }}" min="0" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Stock Quantity</label>
                        <input type="number" name="stock" class="form-input" placeholder="Leave empty for unlimited" value="{{ old('stock') }}" min="0">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" class="form-input" placeholder="e.g., Books, Apparel" value="{{ old('category') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Product Image</label>
                    <input type="file" name="image" class="form-input" accept="image/*">
                </div>

                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" checked style="width: 1.25rem; height: 1.25rem;">
                        <span>Active (visible in store)</span>
                    </label>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary">Add Product</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
