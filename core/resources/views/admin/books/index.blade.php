@extends('admin.layouts.app')

@section('title', 'Spiritual Library')

@section('content')
<div class="mb-10 flex items-end justify-between border-b border-slate-200 pb-8">
    <div>
        <h2 class="text-4xl font-black text-slate-900 tracking-tight">Spiritual Library</h2>
        <p class="mt-2 text-slate-500 font-medium italic">Manage and publish sacred texts for the community.</p>
    </div>
    <a href="{{ route('admin.books.create') }}" class="flex h-12 items-center gap-2 rounded-xl bg-primary px-8 text-sm font-black text-white shadow-lg shadow-primary/20 hover:bg-primary-dark transition-all uppercase tracking-widest">
        <span class="material-symbols-outlined text-[20px]">add</span>
        <span>Create Manuscript</span>
    </a>
</div>

@if(session('success'))
<div class="mb-8 flex items-center gap-3 rounded-2xl bg-emerald-50 border border-emerald-100 p-4 px-6 text-emerald-700">
    <span class="material-symbols-outlined">check_circle</span>
    <p class="text-sm font-bold">{{ session('success') }}</p>
</div>
@endif

<div class="overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Manuscript</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Author & Category</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Pricing</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($books as $book)
                <tr class="group hover:bg-slate-50/50 transition-all">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-5">
                            <div class="h-20 w-14 flex-shrink-0 bg-slate-100 rounded-lg overflow-hidden shadow-sm">
                                @if($book->cover_image)
                                    <img src="{{ asset($book->cover_image) }}" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full flex items-center justify-center bg-slate-100 text-slate-300">
                                        <span class="material-symbols-outlined text-xl">auto_stories</span>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-base font-black text-slate-900 group-hover:text-primary transition-colors">{{ $book->title }}</h4>
                                <p class="text-xs text-slate-500 font-bold mt-1 uppercase tracking-widest opacity-60">{{ $book->pages ?? '0' }} Predicted Pages</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <div class="text-sm font-bold text-slate-700">{{ $book->author }}</div>
                        <div class="mt-1 flex items-center gap-2">
                            <span class="inline-block size-1.5 rounded-full bg-primary/40"></span>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $book->category ?? 'General' }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        @if($book->is_free)
                            <span class="inline-flex items-center rounded-lg bg-emerald-50 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-emerald-600 border border-emerald-100">Free Access</span>
                        @else
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-slate-900">${{ number_format($book->price, 2) }}</span>
                                <span class="text-[9px] font-black uppercase tracking-widest text-slate-400">Premium License</span>
                            </div>
                        @endif
                    </td>
                    <td class="px-8 py-6">
                        @if($book->status)
                            <span class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-emerald-500">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Published
                            </span>
                        @else
                            <span class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-amber-500">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                Draft
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all">
                            <a href="{{ route('admin.books.edit', $book->id) }}" class="flex size-9 items-center justify-center rounded-lg bg-slate-100 text-slate-500 hover:bg-primary hover:text-white transition-all">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </a>
                            <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Archive this manuscript?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex size-9 items-center justify-center rounded-lg bg-slate-100 text-slate-400 hover:bg-red-500 hover:text-white transition-all">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-20 text-center">
                        <span class="material-symbols-outlined text-6xl text-slate-100">auto_stories</span>
                        <p class="mt-4 text-sm font-bold text-slate-400 uppercase tracking-widest">No manuscripts found in library</p>
                        <a href="{{ route('admin.books.create') }}" class="mt-6 inline-flex items-center gap-2 text-primary font-black uppercase tracking-widest hover:underline">Create your first book</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($books->hasPages())
<div class="mt-10">
    {{ $books->links() }}
</div>
@endif
@endsection
