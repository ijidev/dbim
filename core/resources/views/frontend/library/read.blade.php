@extends('layouts.app')

@section('title', $book->title . ' - Digital Library')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,200..900;1,200..900&family=Metamorphous&display=swap');

    .font-manuscript {
        font-family: 'Crimson Pro', serif;
    }

    .font-ornamental {
        font-family: 'Metamorphous', cursive;
    }

    .glass-nav {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }

    .text-justify-custom {
        text-align: justify;
        text-justify: inter-word;
    }

    /* Reading Modes */
    .sepia-mode {
        background-color: #f4ecd8 !important;
        color: #5b4636 !important;
    }
    .sepia-mode .content-card {
        background-color: #fdf6e3 !important;
        border-color: #eee8d5 !important;
    }

    .dark-mode-reader {
        background-color: #1a1a1a !important;
        color: #d1d1d1 !important;
    }
    .dark-mode-reader .content-card {
        background-color: #262626 !important;
        border-color: #333 !important;
    }
    .dark-mode-reader h1, .dark-mode-reader h2 {
        color: #fff !important;
    }
</style>
@endpush

@section('content')
<div id="reader-container" class="min-h-screen bg-slate-50 transition-colors duration-500 font-manuscript pb-20">
    <!-- Reader Navigation -->
    <nav class="sticky top-0 z-50 glass-nav border-b border-slate-200/50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="{{ route('library.index') }}" class="group flex items-center gap-2 text-slate-500 hover:text-primary transition-colors text-sm font-bold uppercase tracking-widest">
                    <span class="material-symbols-outlined text-xl transition-transform group-hover:-translate-x-1">arrow_back</span>
                    <span>Back to Library</span>
                </a>
                <div class="h-6 w-px bg-slate-200"></div>
                <div>
                    <h2 class="text-lg font-black text-slate-900 leading-tight line-clamp-1">{{ $book->title }}</h2>
                    <p class="text-[10px] text-primary font-bold uppercase tracking-[0.2em] mt-0.5">{{ $book->author }}</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <!-- Reading Controls -->
                <div class="hidden md:flex items-center bg-slate-100/50 rounded-2xl p-1 border border-slate-200/50">
                    <button onclick="changeMode('light')" class="p-2.5 rounded-xl hover:bg-white hover:shadow-sm transition-all text-slate-500 hover:text-primary" title="Light Mode">
                        <span class="material-symbols-outlined text-[20px]">light_mode</span>
                    </button>
                    <button onclick="changeMode('sepia')" class="p-2.5 rounded-xl hover:bg-white hover:shadow-sm transition-all text-slate-500 hover:text-amber-700" title="Sepia Mode">
                        <span class="material-symbols-outlined text-[20px]">coffee</span>
                    </button>
                    <button onclick="changeMode('dark')" class="p-2.5 rounded-xl hover:bg-white hover:shadow-sm transition-all text-slate-500 hover:text-slate-900" title="Dark Mode">
                        <span class="material-symbols-outlined text-[20px]">dark_mode</span>
                    </button>
                </div>
                
                <div class="hidden sm:flex items-center gap-2">
                    <button onclick="adjustFontSize(-2)" class="size-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:border-primary transition-all text-sm font-bold">A-</button>
                    <button onclick="adjustFontSize(2)" class="size-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:border-primary transition-all text-lg font-bold">A+</button>
                </div>

                <a href="#" class="flex h-11 items-center gap-2 rounded-xl bg-primary px-6 text-[11px] font-black text-white shadow-lg shadow-primary/20 hover:opacity-90 transition-all uppercase tracking-widest">
                    <span class="material-symbols-outlined text-[18px]">share</span>
                    <span class="hidden sm:inline">Share Wisdom</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Reading Progress Bar -->
    <div class="fixed top-[73px] left-0 w-full h-1 bg-slate-100 z-50">
        <div id="reading-progress" class="h-full bg-primary transition-all duration-300 w-0"></div>
    </div>

    <!-- Book Content -->
    <main class="max-w-4xl mx-auto px-6 pt-16 lg:pt-24">
        <article class="content-card bg-white rounded-[40px] shadow-2xl shadow-slate-200/50 border border-slate-100 p-8 md:p-16 lg:p-24 relative overflow-hidden transition-colors duration-500">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -mr-32 -mt-32 blur-3xl pointer-events-none"></div>
            
            <header class="mb-20 text-center relative z-10">
                <span class="inline-block px-4 py-1.5 rounded-full bg-primary/10 text-primary text-[10px] font-black uppercase tracking-[0.3em] mb-8">Sacred Manuscript</span>
                <h1 class="text-4xl md:text-6xl font-ornamental text-slate-900 mb-8 leading-[1.1] tracking-tight italic">{{ $book->title }}</h1>
                <div class="flex items-center justify-center gap-6 text-slate-400">
                    <div class="flex flex-col items-center">
                        <span class="text-[10px] font-black uppercase tracking-widest mb-1 text-primary">Author</span>
                        <span class="text-base font-bold italic text-slate-600">{{ $book->author }}</span>
                    </div>
                    <div class="w-px h-10 bg-slate-100"></div>
                    <div class="flex flex-col items-center">
                        <span class="text-[10px] font-black uppercase tracking-widest mb-1 text-primary">Category</span>
                        <span class="text-base font-bold italic text-slate-600">{{ $book->category ?? 'Spiritual' }}</span>
                    </div>
                </div>
                <div class="mt-12 flex items-center justify-center gap-4">
                    <div class="h-px w-16 bg-gradient-to-r from-transparent to-slate-200"></div>
                    <span class="material-symbols-outlined text-slate-200 text-3xl">local_library</span>
                    <div class="h-px w-16 bg-gradient-to-l from-transparent to-slate-200"></div>
                </div>
            </header>

            <div id="reader-body" class="prose prose-slate prose-lg lg:prose-xl max-w-none text-slate-700 leading-[1.8] font-medium text-justify-custom whitespace-pre-wrap transition-all duration-300">
                {!! $book->content !!}
            </div>

            <footer class="mt-32 pt-16 border-t border-slate-100 text-center">
                <div class="inline-flex items-center justify-center size-20 rounded-full bg-slate-50 text-slate-200 mb-8">
                    <span class="material-symbols-outlined text-4xl">auto_stories</span>
                </div>
                <h4 class="text-2xl font-ornamental italic text-slate-900 mb-4">End of Manuscript</h4>
                <p class="text-slate-400 text-sm font-bold uppercase tracking-widest">Blessings upon your journey through wisdom.</p>
                
                <div class="mt-16 flex flex-wrap items-center justify-center gap-6">
                    <a href="{{ route('library.index') }}" class="flex h-14 items-center gap-3 rounded-2xl bg-slate-900 px-10 text-xs font-black text-white hover:bg-primary transition-all uppercase tracking-[0.2em] shadow-xl">
                        <span class="material-symbols-outlined text-lg">grid_view</span>
                        Return to Library
                    </a>
                </div>
            </footer>
        </article>
    </main>
</div>

@push('scripts')
<script>
    const readerContainer = document.getElementById('reader-container');
    const readerBody = document.getElementById('reader-body');
    const progressBar = document.getElementById('reading-progress');
    let currentFontSize = 20;

    function changeMode(mode) {
        readerContainer.classList.remove('sepia-mode', 'dark-mode-reader');
        if (mode === 'sepia') readerContainer.classList.add('sepia-mode');
        if (mode === 'dark') readerContainer.classList.add('dark-mode-reader');
    }

    function adjustFontSize(delta) {
        currentFontSize += delta;
        if (currentFontSize < 14) currentFontSize = 14;
        if (currentFontSize > 32) currentFontSize = 32;
        readerBody.style.fontSize = currentFontSize + 'px';
    }

    window.onscroll = function() {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        progressBar.style.width = scrolled + "%";
    };
</script>
@endpush
@endsection
