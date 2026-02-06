@extends('admin.layouts.app')

@section('title', 'Create Manuscript - Admin')

@section('content')
<div class="p-8">
    <div class="max-w-4xl mx-auto">
        <header class="mb-10 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-slate-900 leading-tight">Create Manuscript</h1>
                <p class="text-slate-500 font-bold uppercase tracking-widest text-[10px] mt-2">Initialize your new spiritual work</p>
            </div>
            <a href="{{ route('admin.books.index') }}" class="size-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-200 transition-all">
                <span class="material-symbols-outlined">close</span>
            </a>
        </header>

        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            <div class="bg-white rounded-[32px] p-10 shadow-sm border border-slate-100 space-y-8">
                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Book Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full bg-slate-50 border-none rounded-2xl p-6 text-2xl font-black focus:ring-2 focus:ring-primary transition-all placeholder:text-slate-200" placeholder="Enter Book Title..." required>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Author Name</label>
                        <input type="text" name="author" value="{{ old('author') }}" class="w-full bg-slate-50 border-none rounded-xl p-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all" placeholder="Full name" required>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Genre / Category</label>
                        <select name="category" class="w-full bg-slate-50 border-none rounded-xl p-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                            <option value="Theology">Theology</option>
                            <option value="History">History</option>
                            <option value="Devotional">Devotional</option>
                            <option value="Biography">Biography</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pricing Model</label>
                    <div class="flex p-1 bg-slate-100 rounded-2xl w-full max-w-sm">
                        <label class="flex-1">
                            <input type="radio" name="is_free" value="1" class="sr-only peer" checked>
                            <div class="py-3 text-center text-[10px] font-black uppercase tracking-widest transition-all cursor-pointer rounded-xl peer-checked:bg-white peer-checked:shadow-sm peer-checked:text-primary text-slate-400">Free Access</div>
                        </label>
                        <label class="flex-1">
                            <input type="radio" name="is_free" value="0" class="sr-only peer">
                            <div class="py-3 text-center text-[10px] font-black uppercase tracking-widest transition-all cursor-pointer rounded-xl peer-checked:bg-white peer-checked:shadow-sm peer-checked:text-primary text-slate-400">Premium</div>
                        </label>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Introduction / Description</label>
                    <textarea name="description" class="w-full bg-slate-50 border-none rounded-2xl p-6 text-sm font-bold focus:ring-2 focus:ring-primary transition-all min-h-[150px]" placeholder="Brief summary of the book..."></textarea>
                </div>
                
                <input type="hidden" name="content" value="Initial draft content.">
                <input type="hidden" name="status" value="0">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="flex items-center justify-center rounded-2xl h-14 px-10 bg-primary text-white text-sm font-black hover:opacity-90 transition-all shadow-lg shadow-primary/20 uppercase tracking-widest">
                    Create & Continue to Chapters
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
