@extends('layouts.app')

@push('styles')
<style>
    .perspective-1000 {
        perspective: 1000px;
    }
    .perspective-1000:hover .book-transform {
        transform: rotateY(-10deg) rotateX(10deg);
    }
</style>
@endpush

@section('content')
<main class="min-h-[80vh] relative overflow-hidden bg-slate-50 dark:bg-slate-900 flex flex-col items-center justify-center p-6">
    <!-- Decorative Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-10 text-primary/20 text-2xl animate-bounce" style="animation-duration: 3s">✨</div>
        <div class="absolute top-20 right-20 text-primary/20 text-xl animate-pulse" style="animation-duration: 2s">✦</div>
        <div class="absolute bottom-32 left-1/4 text-primary/20 text-3xl animate-bounce" style="animation-duration: 4s">✨</div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-primary/5 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-4xl w-full flex flex-col md:flex-row items-center gap-10 md:gap-16">
        <!-- Book Cover Display -->
        <div class="flex-shrink-0 relative group perspective-1000">
            <div class="absolute -inset-4 bg-gradient-to-tr from-primary/20 to-blue-600/20 rounded-full blur-2xl opacity-60"></div>
            <div class="absolute bottom-0 left-4 right-4 h-4 bg-black/10 blur-lg rounded-[100%] transform translate-y-4"></div>
            
            <div class="relative w-48 md:w-64 aspect-[3/4] transition-all duration-500 book-transform">
                @if($book && $book->cover_url)
                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover rounded-lg shadow-2xl border border-white/20">
                @else
                    <div class="w-full h-full bg-slate-200 dark:bg-slate-800 rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-6xl opacity-20">auto_stories</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/10 to-white/0 pointer-events-none rounded-lg"></div>
            </div>
        </div>

        <!-- Success Message -->
        <div class="flex flex-col items-center md:items-start text-center md:text-left space-y-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-[10px] font-black uppercase tracking-widest mb-2">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    Purchase Successful
                </div>
                
                <h1 class="text-3xl md:text-5xl font-black text-slate-900 dark:text-white leading-tight">
                    @if($book)
                        <span class="text-primary tracking-tight">'{{ $book->title }}'</span><br> is now in your collection!
                    @else
                        Your Order<br> is being processed!
                    @endif
                </h1>
                
                <p class="text-slate-500 dark:text-slate-400 text-lg font-medium max-w-lg leading-relaxed">
                    Thank you for your purchase. All chapters and premium features have been unlocked instantly for your spiritual journey.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto pt-2">
                @if($book)
                <a href="{{ route('student.library.read', $book->slug) }}" class="bg-primary hover:bg-blue-700 text-white font-black py-4 px-10 rounded-xl shadow-xl shadow-primary/30 transform transition hover:-translate-y-1 flex items-center justify-center gap-3">
                    <span class="material-symbols-outlined">menu_book</span>
                    Start Reading Now
                </a>
                @endif
                <a href="{{ route('student.library.index') }}" class="bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 font-bold py-4 px-8 rounded-xl shadow-sm transition flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">library_books</span>
                    My Library
                </a>
            </div>

            <!-- Impact Summary -->
            <div class="mt-8 pt-8 border-t border-slate-200 dark:border-slate-800 w-full">
                <div class="flex gap-4">
                    <div class="flex-shrink-0 size-12 rounded-full bg-yellow-100 dark:bg-yellow-900/20 flex items-center justify-center text-yellow-600 dark:text-yellow-500">
                        <span class="material-symbols-outlined text-2xl font-bold">volunteer_activism</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-slate-900 dark:text-white mb-1 uppercase tracking-tight">Your Impact</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 font-medium leading-normal max-w-md">
                            Thank you! Your purchase directly supports our digital ministry and the creation of more premium spiritual resources.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
