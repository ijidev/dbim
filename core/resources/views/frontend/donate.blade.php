@extends('layouts.app')

@section('title', 'Give - Support Our Ministry')

@section('content')
<!-- Hero -->
<div style="background-color: white; border-bottom: 1px solid #e2e8f0; padding: 4rem 1rem; text-align: center; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50%; left: 20%; width: 60%; height: 200%; background: radial-gradient(circle, rgba(239, 68, 68, 0.05) 0%, transparent 70%); z-index: 0;"></div>
    
    <div class="container" style="position: relative; z-index: 1;">
        <div style="width: 80px; height: 80px; background: #fee2e2; color: #dc2626; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 2.5rem;">❤️</div>
        <h1 style="font-size: clamp(2rem, 5vw, 3rem); font-weight: 800; color: #1e293b; letter-spacing: -0.05em; margin-bottom: 1rem;">Support Our Ministry</h1>
        <p style="color: #64748b; max-width: 600px; margin: 0 auto; font-size: 1.25rem;">Your generous giving helps us spread the gospel and impact lives.</p>
    </div>
</div>

<div class="container" style="padding: 4rem 1rem;">
    <div style="max-width: 600px; margin: 0 auto; background: white; border-radius: 1.5rem; padding: 2.5rem; box-shadow: var(--shadow-xl); border: 1px solid #e2e8f0;">
        <form action="{{ route('donate.store') }}" method="POST">
            @csrf
            
            <label class="form-label">Select Amount</label>
            <div class="amount-grid">
                <button type="button" class="amount-btn" data-amount="1000">₦1,000</button>
                <button type="button" class="amount-btn" data-amount="5000">₦5,000</button>
                <button type="button" class="amount-btn" data-amount="10000">₦10,000</button>
                <button type="button" class="amount-btn" data-amount="25000">₦25,000</button>
                <button type="button" class="amount-btn" data-amount="50000">₦50,000</button>
                <button type="button" class="amount-btn" data-amount="100000">₦100,000</button>
            </div>
            
            <div class="form-group">
                <label class="form-label">Custom Amount (₦)</label>
                <input type="number" name="amount" id="amount-input" class="form-input" placeholder="Enter amount" min="100" required>
            </div>
            
            <div class="form-group">
                <label class="form-label">Your Name (Optional)</label>
                <input type="text" name="donor_name" class="form-input" placeholder="Enter your name" value="{{ auth()->user()?->name }}">
            </div>
            
            <div class="form-group">
                <label class="form-label">Email (Optional)</label>
                <input type="email" name="donor_email" class="form-input" placeholder="Enter your email" value="{{ auth()->user()?->email }}">
            </div>
            
            <div class="form-group">
                <label class="form-label">Note (Optional)</label>
                <textarea name="note" class="form-input" rows="3" placeholder="Leave a note with your donation..."></textarea>
            </div>
            
            <button type="submit" class="donate-btn">Give Now</button>
            
            <p style="text-align: center; margin-top: 1.5rem; color: #94a3b8; font-size: 0.875rem;">
                <span style="display: block; margin-bottom: 0.25rem;">🔒 Secure Payment</span>
                Powered by Paystack
            </p>
        </form>
    </div>
</div>

<style>
    .amount-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }
    .amount-btn {
        padding: 0.875rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        background: white;
        font-size: 1rem;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s;
    }
    .amount-btn:hover, .amount-btn.active {
        border-color: #ef4444;
        background: #fef2f2;
        color: #ef4444;
    }

    .form-group { margin-bottom: 1.5rem; }
    .form-label {
        display: block;
        font-weight: 600;
        font-size: 0.9375rem;
        margin-bottom: 0.5rem;
        color: #334155;
    }
    .form-input {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        font-size: 1rem;
        font-family: inherit;
        transition: all 0.2s;
    }
    .form-input:focus {
        outline: none;
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .donate-btn {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #ef4444, #b91c1c);
        color: white;
        border: none;
        border-radius: 0.75rem;
        font-size: 1.125rem;
        font-weight: 700;
        cursor: pointer;
        transition: transform 0.2s;
        box-shadow: 0 4px 6px -1px rgba(220, 38, 38, 0.3);
    }
    .donate-btn:hover { transform: translateY(-2px); }
</style>

@push('scripts')
<script>
    document.querySelectorAll('.amount-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.amount-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('amount-input').value = this.dataset.amount;
        });
    });
</script>
@endpush
@endsection
