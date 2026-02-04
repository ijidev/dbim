@extends('layouts.app')

@section('title', 'Thank You for Your Gift')

@section('content')
<div style="max-width: 600px; margin: 6rem auto; text-align: center; padding: 0 1rem;">
    <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #22c55e, #16a34a); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem; font-size: 3rem;">
        ✓
    </div>
    <h1 style="font-size: 2.5rem; font-weight: 800; color: #1e293b; margin-bottom: 1rem;">Thank You!</h1>
    <p style="font-size: 1.25rem; color: #64748b; margin-bottom: 2rem;">
        Your generous donation has been received. May God bless you abundantly for your support of this ministry.
    </p>
    
    @if(session('donation'))
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1.5rem; text-align: left; margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
            <span style="color: #64748b;">Amount</span>
            <span style="font-weight: 700;">₦{{ number_format(session('donation')->amount, 2) }}</span>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <span style="color: #64748b;">Reference</span>
            <span style="font-weight: 600;">{{ session('donation')->transaction_ref }}</span>
        </div>
    </div>
    @endif
    
    <a href="{{ route('index') }}" style="display: inline-block; background: var(--primary-color); color: white; padding: 1rem 2.5rem; border-radius: 0.75rem; font-weight: 700; text-decoration: none;">Return Home</a>
</div>
@endsection
