@extends('layouts.app')

@section('title', 'My Library Collection - Student Dashboard')

@section('content')
<div class="flex h-[calc(100vh-64px)] overflow-hidden bg-slate-50">
    <!-- Sidebar Navigation -->
    @include('partials.student_sidebar')

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto px-6 lg:px-12 py-10 max-w-7xl mx-auto w-full">
        <!-- Heading -->
        <div class="mb-10">
            <h2 class="text-4xl font-black tracking-tight text-slate-900">My Book Collection</h2>
            <p class="text-slate-500 text-lg font-medium">Access your personal library of study materials and spiritual resources.</p>
        </div>

        <!-- Collection Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($collections as $item)
                @php $book = $item->book; @endphp
                <div class="group bg-white rounded-[32px] border border-slate-100 overflow-hidden shadow-sm hover:shadow-2xl transition-all hover:border-primary/20 flex flex-col h-full">
                    <!-- Cover -->
                    <div class="aspect-[3/4] relative overflow-hidden bg-slate-50">
                        @if($book->cover_image)
                            <img src="{{ asset('assets/' . $book->cover_image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-200">
                                <span class="material-symbols-outlined text-6xl">book</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>

                    <!-- Details -->
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-[9px] font-black px-2 py-0.5 bg-primary/10 text-primary rounded-full uppercase tracking-widest">
                                {{ $item->purchased ? 'Purchased' : 'Free' }}
                            </span>
                        </div>
                        <h3 class="font-black text-slate-900 line-clamp-2 leading-tight mb-2 group-hover:text-primary transition-colors">{{ $book->title }}</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">{{ $book->author ?? 'DBIM FACULTY' }}</p>
                        
                        <div class="mt-auto pt-4 border-t border-slate-50">
                            <a href="{{ route('student.library.read', $book->slug) }}" class="w-full h-12 bg-primary text-white text-xs font-black rounded-xl shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-sm">menu_book</span>
                                READ NOW
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-24 text-center bg-white rounded-[40px] border-2 border-dashed border-slate-100">
                    <div class="size-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mx-auto mb-6">
                        <span class="material-symbols-outlined text-4xl">library_books</span>
                    </div>
                    <p class="text-slate-400 font-black mb-6">Your collection is empty</p>
                    <a href="{{ route('library.index') }}" class="px-8 py-4 bg-primary text-white text-xs font-black rounded-2xl shadow-xl shadow-primary/20 hover:scale-105 transition-all">Explore Library</a>
                </div>
            @endforelse
        </div>
    </main>
</div>
@endsection
