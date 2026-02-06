@extends('admin.layouts.app')

@section('content')
<div class="p-8">
    <div class="max-w-4xl mx-auto">
        <header class="mb-10">
            <h1 class="text-3xl font-black text-slate-900 leading-tight">Library Settings</h1>
            <p class="text-slate-500 font-bold uppercase tracking-widest text-[10px] mt-2">Manage sanctuary content & wisdom of the day</p>
        </header>

        <form action="{{ route('admin.library.settings.update') }}" method="POST" class="space-y-8">
            @csrf
            <div class="bg-white rounded-[32px] p-10 shadow-sm border border-slate-100">
                <div class="flex items-center gap-4 mb-8">
                    <div class="size-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined">lightbulb</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Wisdom of the Day</h3>
                        <p class="text-sm text-slate-400 font-bold">This quote will appear in the frontend library sidebar.</p>
                    </div>
                </div>

                <div class="grid gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Wisdom Message</label>
                        <textarea name="wisdom_text" class="w-full bg-slate-50 border-none rounded-2xl p-6 text-sm font-bold focus:ring-2 focus:ring-primary transition-all min-h-[120px]" placeholder="e.g. Thou hast made us for thyself, O Lord, and our heart is restless until it finds its rest in thee.">{{ $wisdom }}</textarea>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Author Attribution</label>
                        <input type="text" name="wisdom_author" value="{{ $author }}" class="w-full bg-slate-50 border-none rounded-xl p-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all" placeholder="e.g. ST. AUGUSTINE">
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="flex items-center justify-center rounded-2xl h-14 px-10 bg-primary text-white text-sm font-black hover:opacity-90 transition-all shadow-lg shadow-primary/20 uppercase tracking-widest">
                    Save Library Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
