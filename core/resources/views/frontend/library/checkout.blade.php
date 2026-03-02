 @extends('layouts.app')

@section('title', 'Purchase: ' . $book->title)

@section('content')
<div class="min-h-screen bg-slate-950 flex items-center justify-center p-6">
    <div class="w-full max-w-lg">

        {{-- Back Link --}}
        <a href="{{ route('student.library.read', $book->slug) }}"
           class="inline-flex items-center gap-2 text-slate-400 hover:text-white text-sm font-semibold mb-8 transition-colors">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Back to Reader
        </a>

        {{-- Card --}}
        <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">

            {{-- Book Cover Banner --}}
            <div class="relative h-40 bg-gradient-to-br from-primary/30 to-slate-900 flex items-center justify-center">
                @if($book->cover_url)
                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}"
                         class="h-36 w-auto object-cover rounded-xl shadow-2xl -mb-8 ring-4 ring-slate-900">
                @else
                    <span class="material-symbols-outlined text-7xl text-primary/30">menu_book</span>
                @endif
            </div>

            <div class="px-8 pt-12 pb-8">
                {{-- Book Info --}}
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-black text-white mb-1">{{ $book->title }}</h1>
                    <p class="text-slate-400 text-sm">by {{ $book->author }}</p>

                    <div class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-primary/10 border border-primary/20 rounded-full">
                        <span class="material-symbols-outlined text-primary text-lg">sell</span>
                        <span class="text-white font-black text-xl">
                            {{ $book->price ? '₦' . number_format($book->price, 2) : 'Premium Access' }}
                        </span>
                    </div>
                </div>

                {{-- What you get --}}
                <div class="bg-slate-800/50 rounded-2xl p-5 mb-6 space-y-3">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">What you get</p>
                    @foreach(['Full book access — all chapters', 'Personal highlights & notes', 'Text-to-speech reader', 'Read on any device'] as $perk)
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-emerald-400 text-lg">check_circle</span>
                        <span class="text-sm text-slate-300">{{ $perk }}</span>
                    </div>
                    @endforeach
                </div>

                {{-- Alerts --}}
                @if(session('success'))
                    <div class="mb-4 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Purchase Form --}}
                <form method="POST" action="{{ route('library.book.purchase', $book->id) }}">
                    @csrf
                    <button type="submit"
                        class="w-full py-4 bg-gradient-to-r from-primary to-primary/80 text-white font-black rounded-2xl hover:scale-[1.02] active:scale-100 transition-all shadow-lg shadow-primary/30 flex items-center justify-center gap-2 text-base">
                        <span class="material-symbols-outlined">lock_open</span>
                        Confirm Purchase &mdash; {{ $book->price ? '₦' . number_format($book->price, 2) : 'Get Access' }}
                    </button>
                </form>

                <p class="text-center text-xs text-slate-500 mt-4">
                    By purchasing, you agree to our
                    <a href="#" class="text-primary hover:underline">terms of service</a>.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
