@extends('layouts.app')

@section('title', 'Secure Checkout - DBIM Academy')

@push('styles')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 32px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
    }
    .payment-option {
        border: 2px solid #f1f5f9;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .payment-option.active {
        border-color: var(--primary);
        background: rgba(23, 84, 207, 0.05);
    }
</style>
@endpush

@php
    $item = isset($course) ? $course : $meeting;
    $typeLabel = isset($course) ? 'Course' : 'Session';
    $host = isset($course) ? $course->instructor : $meeting->host;
    $payRoute = isset($course) ? route('student.course.pay', $course->id) : route('meeting.pay', $meeting->id);
    $price = $item->price;
    $title = $item->title;
@endphp

@section('content')
<main class="min-h-screen bg-[#f6f6f8] py-20 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumbs -->
        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest mb-8">
            <span>Academy</span>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-primary">Checkout</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            <!-- Left: Payment Form -->
            <div class="lg:col-span-7 space-y-8">
                <div class="glass-card p-10">
                    <h1 class="text-3xl font-black text-slate-900 mb-2">Secure Checkout</h1>
                    <p class="text-slate-500 font-medium mb-10">Complete your payment to gain access to this {{ strtolower($typeLabel) }}.</p>

                    <div class="space-y-6">
                        <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Payment Method</h4>
                        
                        <div class="grid grid-cols-1 gap-4">
                            <div class="payment-option active p-5 rounded-2xl flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="size-12 bg-white rounded-xl flex items-center justify-center border border-slate-100 shadow-sm">
                                        <span class="material-symbols-outlined text-primary">credit_card</span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900">Card Payment / Transfer</p>
                                        <p class="text-xs text-slate-500 font-medium">Standard Processing</p>
                                    </div>
                                </div>
                                <div class="size-5 rounded-full border-2 border-primary flex items-center justify-center">
                                    <div class="size-2.5 rounded-full bg-primary"></div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-8 mt-8 border-t border-slate-100">
                             <form action="{{ $payRoute }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white py-5 rounded-2xl font-black shadow-xl shadow-primary/20 hover:scale-[1.01] active:scale-95 transition-all flex items-center justify-center gap-3">
                                    Confirm & Pay ₦{{ number_format($price) }}
                                    <span class="material-symbols-outlined">shield_check</span>
                                </button>
                             </form>
                             <p class="text-center text-[11px] text-slate-400 mt-6 font-medium px-4 leading-relaxed italic">
                                This is a simulated checkout. Clicking pay will confirm your enrollment and grant immediate access.
                             </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div class="lg:col-span-5">
                <div class="glass-card p-8 sticky top-32">
                    <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6">Order Summary</h4>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4 p-4 bg-primary/5 rounded-2xl border border-primary/10">
                            <div class="size-14 rounded-xl bg-white flex-shrink-0 flex items-center justify-center shadow-sm overflow-hidden border border-slate-100">
                                @php
                                    $thumb = isset($course) ? $course->thumbnail : (isset($meeting->thumbnail) ? $meeting->thumbnail : null);
                                    $avatar = $host->avatar ?? null;
                                @endphp
                                @if($thumb)
                                <img src="{{ asset($thumb) }}" class="w-full h-full object-cover">
                                @elseif($avatar)
                                <img src="{{ asset('storage/'.$avatar) }}" class="w-full h-full object-cover">
                                @else
                                <span class="material-symbols-outlined text-primary text-3xl">{{ isset($course) ? 'menu_book' : 'account_circle' }}</span>
                                @endif
                            </div>
                            <div>
                                <h5 class="font-black text-slate-900 text-sm leading-tight">{{ $title }}</h5>
                                <p class="text-[11px] text-slate-500 font-bold uppercase tracking-widest mt-1">By {{ $host->name }}</p>
                            </div>
                        </div>

                        <div class="space-y-4 pt-4">
                            <div class="flex justify-between items-center text-sm font-bold">
                                <span class="text-slate-500">Item Type</span>
                                <span class="text-slate-900">{{ $typeLabel }}</span>
                            </div>
                            @if(isset($meeting))
                            <div class="flex justify-between items-center text-sm font-bold">
                                <span class="text-slate-500">Scheduled For</span>
                                <span class="text-slate-900">{{ $meeting->scheduled_at->format('M d, Y') }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between items-center text-sm font-bold">
                                <span class="text-slate-500">Access</span>
                                <span class="text-slate-900 font-black text-emerald-600">Lifetime</span>
                            </div>
                        </div>

                        <div class="border-t-2 border-dashed border-slate-100 pt-6 mt-6">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-900 font-extrabold text-lg uppercase tracking-tight">Total Due</span>
                                <span class="text-primary font-black text-3xl tracking-tighter">₦{{ number_format($price) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
