@extends('layouts.app')

@section('content')
<div style="max-width: 1000px; margin: 4rem auto; padding: 0 1rem;">
    <h1 style="font-size: 2.5rem; font-weight: 800; color: #1e293b; margin-bottom: 2.5rem;">Checkout</h1>

    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 4rem;">
        <div>
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem;">Default Shipping / Billing</h3>
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 2rem; border-radius:1rem;">
                <p style="color: #64748b; margin-bottom: 1.5rem;">The order will be processed using your account details.</p>
                <div style="display: grid; gap: 1rem;">
                    <div>
                        <strong>Name:</strong> {{ Auth::user()->name }}
                    </div>
                    <div>
                        <strong>Email:</strong> {{ Auth::user()->email }}
                    </div>
                </div>
            </div>

            <h3 style="font-size: 1.25rem; font-weight: 700; margin-top: 3rem; margin-bottom: 1.5rem;">Payment Method</h3>
            <div style="padding: 2rem; border: 2px solid var(--primary-color); background: #eff6ff; border-radius: 1rem; display: flex; align-items: center; gap: 1rem;">
                <div style="width: 24px; height: 24px; background: var(--primary-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">✓</div>
                <div>
                    <strong style="display: block;">Pay with Card / Bank Transfer</strong>
                    <span style="font-size: 0.875rem; color: #64748b;">Secure payment gateway integration.</span>
                </div>
            </div>
        </div>

        <div>
            <div style="background: white; border: 1px solid #e2e8f0; padding: 2rem; border-radius: 1rem; position: sticky; top: 2rem;">
                <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 1.5rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 1rem;">Order Summary</h3>
                
                @php $total = 0; @endphp
                @foreach($cart as $id => $details)
                    @php $total += $details['price'] * $details['quantity']; @endphp
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; font-size: 0.9375rem;">
                        <span style="color: #64748b;">{{ $details['title'] }} x {{ $details['quantity'] }}</span>
                        <span style="font-weight: 600;">₦{{ number_format($details['price'] * $details['quantity'], 2) }}</span>
                    </div>
                @endforeach

                <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; margin-bottom: 2rem;">
                    <span style="font-weight: 700;">Total Amount</span>
                    <span style="font-weight: 800; color: var(--primary-color); font-size: 1.25rem;">₦{{ number_format($total, 2) }}</span>
                </div>

                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <button type="submit" style="width: 100%; background: var(--primary-color); color: white; border: none; padding: 1rem; border-radius: 0.75rem; font-weight: 700; cursor: pointer;">
                        Complete Purchase
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
