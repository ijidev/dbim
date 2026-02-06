@extends('layouts.app')

@section('title', 'Church Digital Library')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&display=swap');
    
    .font-serif-premium {
        font-family: 'Newsreader', serif;
    }
    
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endpush

@section('content')
<main class="flex-1 max-w-[1440px] mx-auto w-full px-6 lg:px-20 py-12 font-serif-premium">
    <!-- Header & Search -->
    <div class="flex flex-col gap-10 mb-16">
        <div class="max-w-3xl">
            <span class="text-primary font-bold text-sm uppercase tracking-[0.2em] mb-4 block">The Sanctuary of Wisdom</span>
            <h1 class="text-slate-900 text-5xl md:text-6xl font-extrabold leading-tight tracking-tight italic mb-8">Church Digital <span class="text-primary tracking-normal">Library</span></h1>
            
            <form action="{{ route('library.index') }}" method="GET" class="relative block group">
                <span class="absolute inset-y-0 left-0 flex items-center pl-5 text-slate-400 group-focus-within:text-primary transition-colors">
                    <span class="material-symbols-outlined text-2xl">search</span>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" class="block w-full h-16 pl-14 pr-6 bg-white border border-slate-200 rounded-2xl shadow-sm focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all placeholder:italic placeholder:text-slate-300 text-xl font-medium" placeholder="Search for theology, devotionals, or sacred texts...">
            </form>
        </div>

        <!-- Categories -->
        <div class="flex flex-wrap items-center gap-3 no-scrollbar overflow-x-auto pb-2">
            @php
                $activeCategory = request('category', 'all');
                $categories = ['Theology', 'Devotionals', 'Church History', 'Liturgy', 'Biographies', 'Leadership', 'Faith'];
            @endphp
            <a href="{{ route('library.index') }}" class="px-6 py-2.5 rounded-full text-sm font-bold border transition-all {{ $activeCategory == 'all' ? 'bg-primary border-primary text-white shadow-lg shadow-primary/20' : 'bg-white border-slate-200 text-slate-600 hover:border-primary hover:text-primary' }}">
                All Works
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('library.index', ['category' => $cat]) }}" class="px-6 py-2.5 rounded-full text-sm font-bold border transition-all {{ $activeCategory == $cat ? 'bg-primary border-primary text-white shadow-lg shadow-primary/20' : 'bg-white border-slate-200 text-slate-600 hover:border-primary hover:text-primary' }}">
                {{ $cat }}
            </a>
            @endforeach
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-16">
        <!-- Main Content -->
        <div class="flex-1">
            <div class="flex items-baseline justify-between mb-10 border-b border-slate-100 pb-6">
                <h3 class="text-3xl font-bold tracking-tight italic text-slate-900">Spiritual Literature</h3>
                <span class="text-sm text-slate-400 font-bold uppercase tracking-widest">{{ $books->total() }} Volumes Available</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-10">
                @forelse($books as $book)
                <div class="group flex flex-col gap-5 bg-white p-5 rounded-3xl border border-transparent hover:border-slate-100 hover:shadow-2xl transition-all duration-500">
                    <div class="relative aspect-[3/4] rounded-2xl overflow-hidden shadow-xl">
                        @if($book->cover_image)
                            <img src="{{ asset($book->cover_image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $book->title }}">
                        @else
                            <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
                                <span class="material-symbols-outlined text-6xl font-light">auto_stories</span>
                            </div>
                        @endif
                        
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-500 flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <a href="{{ route('library.read', $book->slug) }}" class="bg-white text-primary text-sm font-black px-8 h-12 rounded-xl flex items-center justify-center transform translate-y-4 group-hover:translate-y-0 transition-all duration-500 shadow-xl uppercase tracking-widest">Preview</a>
                        </div>
                        
                        <!-- Pricing Badge -->
                        <div class="absolute top-4 right-4">
                            @if($book->is_free)
                                <span class="px-3 py-1.5 bg-emerald-500 text-white text-[9px] font-black rounded-full uppercase tracking-widest shadow-lg">Free</span>
                            @else
                                <span class="px-3 py-1.5 bg-primary text-white text-[9px] font-black rounded-full uppercase tracking-widest shadow-lg">${{ number_format($book->price, 2) }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <h4 class="text-xl font-black text-slate-900 leading-tight line-clamp-1 group-hover:text-primary transition-colors">{{ $book->title }}</h4>
                        <p class="text-primary text-sm font-bold italic tracking-wide opacity-80">{{ $book->author }}</p>
                        <a href="{{ route('library.read', $book->slug) }}" class="mt-4 flex h-12 w-full items-center justify-center gap-3 rounded-xl bg-slate-900 border border-slate-900 text-white font-black text-xs uppercase tracking-[0.2em] hover:bg-white hover:text-slate-900 transition-all">
                            <span class="material-symbols-outlined text-[18px]">menu_book</span>
                            <span>Read Manuscript</span>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-20 text-center bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                    <span class="material-symbols-outlined text-6xl text-slate-200 mb-4 font-light">find_in_page</span>
                    <p class="text-slate-400 font-bold uppercase tracking-widest">No spiritual works match your search</p>
                    <a href="{{ route('library.index') }}" class="text-primary font-bold mt-4 inline-block hover:underline">Clear all filters</a>
                </div>
                @endforelse
            </div>

            @if($books->hasPages())
            <div class="mt-16">
                {{ $books->links() }}
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <aside class="w-full lg:w-96 flex flex-col gap-10">
            <!-- Your Sanctuary -->
            <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm">
                <div class="flex items-center gap-3 mb-8">
                    <span class="material-symbols-outlined text-primary text-3xl">bookmark_heart</span>
                    <h3 class="text-2xl font-black italic text-slate-900">Your Sanctuary</h3>
                </div>
                
                <div class="space-y-10">
                    <!-- Recently Read (Mockup for now, could be dynamic later) -->
                    <div>
                        <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-6 flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary/30"></span> Recently Read
                        </h4>
                        <div class="flex gap-5 group cursor-pointer items-center">
                            <div class="w-16 h-20 bg-slate-100 rounded-xl overflow-hidden shadow-md flex-shrink-0 transition-transform group-hover:scale-105">
                                <div class="w-full h-full bg-gradient-to-br from-slate-200 to-slate-300"></div>
                            </div>
                            <div class="flex-1">
                                <p class="text-base font-black text-slate-900 line-clamp-1 group-hover:text-primary transition-colors">Start Reading...</p>
                                <p class="text-xs text-slate-500 font-bold italic mt-1 uppercase tracking-wide opacity-60">Browse Library</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quote -->
                    <div class="pt-8 border-t border-slate-50 relative">
                        <span class="material-symbols-outlined absolute -top-4 -right-4 text-8xl opacity-[0.03] rotate-12 text-slate-900 pointer-events-none select-none">format_quote</span>
                        <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-6">Wisdom of the Day</h4>
                        <p class="text-xl italic font-medium leading-relaxed text-slate-800 mb-4">"Thou hast made us for thyself, O Lord, and our heart is restless until it finds its rest in thee."</p>
                        <p class="text-xs font-black uppercase tracking-widest text-primary">— St. Augustine</p>
                    </div>
                </div>
            </div>

            <!-- Library Stats Card -->
            <div class="bg-slate-900 p-8 rounded-[40px] text-white overflow-hidden relative">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/10 rounded-full -mr-16 -mt-16 blur-3xl"></div>
                <h4 class="text-3xl font-black italic mb-6 leading-tight">Empowering your spiritual <span class="text-primary italic-normal">journey</span>.</h4>
                <p class="text-slate-400 text-sm font-medium leading-relaxed mb-8 opacity-80">Access over a thousand volumes of theological works, historical manuscripts, and modern devotionals from anywhere in the world.</p>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-3xl font-black tracking-tight">{{ $books->total() }}</p>
                        <p class="text-[9px] font-bold uppercase tracking-widest text-slate-500 mt-1">Total Volumes</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black tracking-tight">2.4k</p>
                        <p class="text-[9px] font-bold uppercase tracking-widest text-slate-500 mt-1">Active Readers</p>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</main>
@endsection
