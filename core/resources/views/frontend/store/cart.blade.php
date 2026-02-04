@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 4rem auto; padding: 0 1rem;">
    <h1 style="font-size: 2.5rem; font-weight: 800; color: #1e293b; margin-bottom: 2.5rem;">Shopping Cart</h1>

    @if(count($cart) > 0)
        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 1rem; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <tr>
                        <th style="padding: 1.5rem; text-align: left; font-size: 0.75rem; text-transform: uppercase; color: #64748b; letter-spacing: 0.05em;">Product</th>
                        <th style="padding: 1.5rem; text-align: center; font-size: 0.75rem; text-transform: uppercase; color: #64748b; letter-spacing: 0.05em;">Price</th>
                        <th style="padding: 1.5rem; text-align: center; font-size: 0.75rem; text-transform: uppercase; color: #64748b; letter-spacing: 0.05em;">Quantity</th>
                        <th style="padding: 1.5rem; text-align: right; font-size: 0.75rem; text-transform: uppercase; color: #64748b; letter-spacing: 0.05em;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $details)
                        @php $total += $details['price'] * $details['quantity']; @endphp
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 1.5rem;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div style="width: 60px; height: 60px; background: #f8fafc; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">📦</div>
                                    <span style="font-weight: 700; color: #1e293b;">{{ $details['title'] }}</span>
                                </div>
                            </td>
                            <td style="padding: 1.5rem; text-align: center;">₦{{ number_format($details['price'], 2) }}</td>
                            <td style="padding: 1.5rem; text-align: center;">{{ $details['quantity'] }}</td>
                            <td style="padding: 1.5rem; text-align: right; font-weight: 700;">₦{{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div style="padding: 2.5rem; display: flex; justify-content: space-between; align-items: center; background: #fdfdfd;">
                <div>
                    <a href="{{ route('store.index') }}" style="color: #64748b; text-decoration: none; font-weight: 600;">← Continue Shopping</a>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 0.875rem; color: #64748b; margin-bottom: 0.5rem;">Total Amount</div>
                    <div style="font-size: 2rem; font-weight: 800; color: #1e293b; margin-bottom: 1.5rem;">₦{{ number_format($total, 2) }}</div>
                    <a href="{{ route('checkout') }}" style="background: var(--primary-color); color: white; text-decoration: none; padding: 1rem 3rem; border-radius: 0.75rem; font-weight: 700; display: inline-block;">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    @else
        <div style="text-align: center; padding: 6rem 1rem; background: white; border: 1px dashed #cbd5e1; border-radius: 1.5rem;">
            <div style="font-size: 4rem; margin-bottom: 1.5rem;">🛒</div>
            <h3 style="font-size: 1.5rem; color: #1e293b; margin-bottom: 0.5rem;">Your cart is empty</h3>
            <p style="color: #64748b; margin-bottom: 2rem;">Looks like you haven't added any ministry materials yet.</p>
            <a href="{{ route('store.index') }}" style="background: var(--primary-color); color: white; text-decoration: none; padding: 1rem 2.5rem; border-radius: 0.75rem; font-weight: 700; display: inline-block;">Go to Store</a>
        </div>
    @endif
</div>
@endsection
