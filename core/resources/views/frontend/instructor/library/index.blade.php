@extends('layouts.instructor')

@section('title', 'Library Management')
@section('page_title', 'Library Management Hub')

@section('instructor_content')
<div class="space-y-12">
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 leading-tight tracking-tight">Author's Studio</h1>
            <p class="text-slate-500 font-medium mt-1">Publish and manage spiritual literature for the digital library.</p>
        </div>
        <a href="{{ route('instructor.library.create') }}" class="h-14 px-8 bg-primary text-white rounded-[1.25rem] text-sm font-black flex items-center gap-3 shadow-xl shadow-primary/20 hover:scale-105 transition-all">
            <span class="material-symbols-outlined text-xl">add_box</span>
            PUBLISH NEW BOOK
        </a>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[2rem] border border-[#dcdfe5] shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Total Publications</p>
                <div class="bg-primary/10 p-2.5 rounded-xl text-primary">
                    <span class="material-symbols-outlined font-bold">library_books</span>
                </div>
            </div>
            <h3 class="text-3xl font-black text-slate-900">{{ $books->total() }}</h3>
            <p class="text-[10px] font-bold text-slate-400 mt-2">Books in library</p>
        </div>

        <div class="bg-white p-8 rounded-[2rem] border border-[#dcdfe5] shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Live Content</p>
                <div class="bg-emerald-50 p-2.5 rounded-xl text-emerald-600">
                    <span class="material-symbols-outlined font-bold">public</span>
                </div>
            </div>
            <h3 class="text-3xl font-black text-slate-900">{{ $books->where('status', true)->count() }}</h3>
            <p class="text-[10px] font-bold text-slate-400 mt-2">Published works</p>
        </div>

        <div class="bg-white p-8 rounded-[2rem] border border-[#dcdfe5] shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Drafts</p>
                <div class="bg-amber-50 p-2.5 rounded-xl text-amber-600">
                    <span class="material-symbols-outlined font-bold">edit_note</span>
                </div>
            </div>
            <h3 class="text-3xl font-black text-slate-900">{{ $books->where('status', false)->count() }}</h3>
            <p class="text-[10px] font-bold text-slate-400 mt-2">Works in progress</p>
        </div>
    </div>

    <!-- Books Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @forelse($books as $book)
        <div class="bg-white rounded-[2rem] border border-[#dcdfe5] shadow-sm overflow-hidden group hover:shadow-xl hover:shadow-primary/5 transition-all flex flex-col">
            <!-- Cover Image -->
            <div class="aspect-[3/4] relative bg-slate-100 overflow-hidden">
                @if($book->cover_image)
                    <img src="{{ asset('assets/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-slate-50 text-slate-300">
                        <span class="material-symbols-outlined text-6xl">book_2</span>
                    </div>
                @endif
                
                <div class="absolute top-4 right-4">
                    @if($book->status)
                        <span class="px-3 py-1 bg-emerald-500 text-white text-[10px] font-black uppercase rounded-lg tracking-widest shadow-sm">
                            PUBLISHED
                        </span>
                    @else
                        <span class="px-3 py-1 bg-slate-500 text-white text-[10px] font-black uppercase rounded-lg tracking-widest shadow-sm">
                            DRAFT
                        </span>
                    @endif
                </div>
            </div>

            <!-- Content -->
            <div class="p-6 flex-1 flex flex-col">
                <h3 class="text-lg font-black text-slate-900 leading-tight mb-1 line-clamp-1 group-hover:text-primary transition-colors">{{ $book->title }}</h3>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">{{ $book->author }}</p>
                
                <div class="mt-auto flex items-center gap-4 text-xs font-bold text-slate-500">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">format_list_numbered</span>
                        {{ $book->chapters_count }} Chapters
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-base">pages</span>
                        {{ $book->pages }} Pages
                    </span>
                </div>
            </div>

            <!-- Actions -->
            <div class="p-4 bg-[#f8f9fb] border-t border-slate-100 grid grid-cols-3 gap-2">
                <a href="{{ route('instructor.library.chapters', $book->id) }}" class="flex flex-col items-center justify-center p-2 rounded-xl hover:bg-white hover:text-primary hover:shadow-sm transition-all text-slate-400 group/btn" title="Manage Chapters">
                    <span class="material-symbols-outlined mb-1 group-hover/btn:scale-110 transition-transform">menu_book</span>
                    <span class="text-[9px] font-black uppercase tracking-wider">Chapters</span>
                </a>
                <a href="{{ route('instructor.library.edit', $book->id) }}" class="flex flex-col items-center justify-center p-2 rounded-xl hover:bg-white hover:text-primary hover:shadow-sm transition-all text-slate-400 group/btn" title="Edit Metadata">
                    <span class="material-symbols-outlined mb-1 group-hover/btn:scale-110 transition-transform">edit</span>
                    <span class="text-[9px] font-black uppercase tracking-wider">Edit</span>
                </a>
                <form action="{{ route('instructor.library.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Strict Warning: Delete this book completely?')" class="contents">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="flex flex-col items-center justify-center p-2 rounded-xl hover:bg-red-50 hover:text-red-500 hover:shadow-sm transition-all text-slate-400 group/btn" title="Delete Book">
                        <span class="material-symbols-outlined mb-1 group-hover/btn:scale-110 transition-transform">delete</span>
                        <span class="text-[9px] font-black uppercase tracking-wider">Delete</span>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full py-32 text-center">
            <div class="size-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center text-slate-200 mx-auto mb-8">
                <span class="material-symbols-outlined text-5xl font-light">import_contacts</span>
            </div>
            <h3 class="text-2xl font-black text-slate-900">Your library is empty</h3>
            <p class="text-slate-500 max-w-sm mx-auto mt-4 font-medium italic">"Write the vision; make it plain on tablets, so he may run who reads it." — Habakkuk 2:2</p>
            <div class="mt-10">
                <a href="{{ route('instructor.library.create') }}" class="inline-flex h-14 px-10 bg-primary text-white rounded-[1.25rem] text-sm font-black items-center gap-3 shadow-xl shadow-primary/20 hover:scale-105 transition-all">
                    START WRITING
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($books->hasPages())
    <div class="mt-12 flex justify-center">
        {{ $books->links() }}
    </div>
    @endif
</div>
@endsection
