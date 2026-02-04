@extends('layouts.app')

@section('title', 'Give - Support Our Ministry')

@push('styles')
<style>
    .donate-container {
        max-width: 600px;
        margin: 4rem auto;
        padding: 0 1rem;
    }
    .donate-card {
        background: white;
        border-radius: 1.5rem;
        padding: 3rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .donate-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    .donate-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #f87171, #ef4444);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2.5rem;
    }
    .donate-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }
    .donate-subtitle {
        color: #64748b;
        font-size: 1rem;
    }
    .amount-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .amount-btn {
        padding: 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 0.75rem;
        background: white;
        font-size: 1.125rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }
    .amount-btn:hover, .amount-btn.active {
        border-color: var(--primary-color);
        background: #eff6ff;
        color: var(--primary-color);
    }
    .form-group { margin-bottom: 1.5rem; }
    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #374151;
    }
    .form-input {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        font-size: 1rem;
        font-family: inherit;
    }
    .form-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(23, 84, 207, 0.1);
    }
    .donate-btn {
        width: 100%;
        padding: 1.25rem;
        background: linear-gradient(135deg, var(--primary-color), #1e40af);
        color: white;
        border: none;
        border-radius: 0.75rem;
        font-size: 1.125rem;
        font-weight: 700;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .donate-btn:hover { transform: scale(1.02); }
</style>
@endpush

@section('content')
<div class="donate-container">
    <div class="donate-card">
        <div class="donate-header">
            <div class="donate-icon">❤️</div>
            <h1 class="donate-title">Support Our Ministry</h1>
            <p class="donate-subtitle">Your generous giving helps us spread the gospel and impact lives.</p>
        </div>
        
        <form action="{{ route('donate.store') }}" method="POST">
            @csrf
            
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
        </form>
    </div>
</div>
@endsection

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
