@extends('admin.layouts.app')

@section('title', 'Edit Manuscript')

@push('styles')
<style>
    .editor-container:focus-within { border-color: var(--primary); }
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
</style>
@endpush

@section('content')
<form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col h-[calc(100vh-120px)] -m-8">
    @csrf
    @method('PUT')
    <!-- Top Action Bar -->
    <header class="flex items-center justify-between border-b border-slate-200 bg-white px-8 py-4 sticky top-0 z-10">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.books.index') }}" class="size-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-200 transition-all">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h2 class="text-xl font-black text-slate-900 leading-tight">Edit Manuscript</h2>
                <div class="flex items-center gap-2 text-[10px] text-slate-500 uppercase tracking-widest font-black">
                    <span class="w-1.5 h-1.5 rounded-full {{ $book->status ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                    {{ $book->status ? 'Published' : 'Draft Mode' }}
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button type="submit" name="status" value="0" class="flex items-center justify-center rounded-xl h-11 px-6 bg-slate-100 text-slate-600 text-sm font-black hover:bg-slate-200 transition-all uppercase tracking-widest">
                <span>Save as Draft</span>
            </button>
            <button type="submit" name="status" value="1" class="flex items-center justify-center rounded-xl h-11 px-8 bg-primary text-white text-sm font-black hover:opacity-90 transition-all shadow-lg shadow-primary/20 uppercase tracking-widest">
                <span>Update & Publish</span>
            </button>
        </div>
    </header>

    @if($errors->any())
        <div class="mx-8 mt-6 bg-red-50 border border-red-100 text-red-600 px-6 py-4 rounded-2xl flex items-center gap-3">
            <span class="material-symbols-outlined">error</span>
            <p class="text-sm font-bold">Please check the form for errors: {{ $errors->first() }}</p>
        </div>
    @endif

    <!-- Main Workspace -->
    <div class="flex flex-1 overflow-hidden">
        <!-- Left Sidebar: Metadata -->
        <aside class="w-80 border-r border-slate-200 bg-white overflow-y-auto p-8 custom-scrollbar space-y-8">
            <div>
                <h3 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">info</span> Book Details
                </h3>
                <div class="space-y-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Author Name</label>
                        <input type="text" name="author" value="{{ old('author', $book->author) }}" class="w-full bg-slate-50 border-none rounded-xl p-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all" placeholder="Full name of the author" required>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Genre / Category</label>
                        <select name="category" class="w-full bg-slate-50 border-none rounded-xl p-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                            @foreach(['Theology', 'History', 'Devotional', 'Biography', 'Leadership', 'Faith'] as $cat)
                                <option value="{{ $cat }}" {{ (old('category', $book->category) == $cat) ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pricing Model</label>
                        <div class="flex p-1 bg-slate-100 rounded-xl">
                            <label class="flex-1">
                                <input type="radio" name="is_free" value="1" class="sr-only peer" {{ $book->is_free ? 'checked' : '' }}>
                                <div class="py-2.5 text-center text-[10px] font-black uppercase tracking-widest transition-all cursor-pointer rounded-lg peer-checked:bg-white peer-checked:shadow-sm peer-checked:text-primary text-slate-400">Free</div>
                            </label>
                            <label class="flex-1">
                                <input type="radio" name="is_free" value="0" class="sr-only peer" {{ !$book->is_free ? 'checked' : '' }}>
                                <div class="py-2.5 text-center text-[10px] font-black uppercase tracking-widest transition-all cursor-pointer rounded-lg peer-checked:bg-white peer-checked:shadow-sm peer-checked:text-primary text-slate-400">Premium</div>
                            </label>
                        </div>
                    </div>
                    <div id="price-container" class="{{ $book->is_free ? 'hidden' : '' }} flex flex-col gap-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Book Price ($)</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $book->price) }}" class="w-full bg-slate-50 border-none rounded-xl p-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all" placeholder="0.00">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Approx. Pages</label>
                        <input type="number" name="pages" value="{{ old('pages', $book->pages) }}" class="w-full bg-slate-50 border-none rounded-xl p-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all" placeholder="e.g. 120">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Cover Image</label>
                        <div class="relative group cursor-pointer border-2 border-dashed border-slate-200 rounded-2xl aspect-[3/4] flex flex-col items-center justify-center gap-3 hover:border-primary transition-all bg-slate-50/50">
                            <input type="file" name="cover_image" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewImage(this)">
                            <div id="image-preview" class="absolute inset-0 rounded-2xl overflow-hidden {{ $book->cover_image ? '' : 'hidden' }}">
                                <img src="{{ $book->cover_image ? asset($book->cover_image) : '' }}" class="w-full h-full object-cover">
                            </div>
                            <span class="material-symbols-outlined text-4xl text-slate-300 group-hover:text-primary transition-colors">upload_file</span>
                            <p class="text-[9px] text-center px-6 font-black text-slate-400 uppercase tracking-widest leading-relaxed">Drag cover or click to browse</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Center: Editor -->
        <section class="flex-1 bg-slate-50 overflow-hidden flex flex-col">
            <!-- Simple Toolbar -->
            <div class="bg-white border-b border-slate-200 p-3 px-8 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <button type="button" class="p-2 hover:bg-slate-100 rounded-lg text-slate-600" title="Bold"><span class="material-symbols-outlined">format_bold</span></button>
                    <button type="button" class="p-2 hover:bg-slate-100 rounded-lg text-slate-600" title="Italic"><span class="material-symbols-outlined">format_italic</span></button>
                    <div class="w-px h-6 bg-slate-200 mx-1"></div>
                    <button type="button" class="p-2 hover:bg-slate-100 rounded-lg text-slate-600" title="Heading 1"><span class="material-symbols-outlined text-lg">format_h1</span></button>
                    <button type="button" class="p-2 hover:bg-slate-100 rounded-lg text-slate-600" title="Heading 2"><span class="material-symbols-outlined text-lg">format_h2</span></button>
                    <div class="w-px h-6 bg-slate-200 mx-1"></div>
                    <button type="button" class="p-2 hover:bg-slate-100 rounded-lg text-slate-600" title="List"><span class="material-symbols-outlined text-lg">format_list_bulleted</span></button>
                </div>
                <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                    Editing Mode • <span id="word-count">0</span> words
                </div>
            </div>

            <!-- Content Area -->
            <div class="flex-1 overflow-y-auto p-12 custom-scrollbar flex justify-center bg-[#FAF9F6]">
                <div class="max-w-4xl w-full bg-white shadow-2xl rounded-2xl min-h-[1000px] p-20 flex flex-col gap-8">
                    <input type="text" name="title" value="{{ old('title', $book->title) }}" placeholder="Enter Book Title..." class="text-4xl lg:text-5xl font-black bg-transparent border-none p-0 focus:ring-0 placeholder-slate-200 text-slate-900 leading-tight" required>
                    <textarea name="description" placeholder="Write a brief, compelling description..." class="text-lg text-slate-500 font-medium italic border-none p-0 focus:ring-0 placeholder-slate-200 resize-none min-h-[100px]">{{ old('description', $book->description) }}</textarea>
                    <div class="h-px bg-slate-100 w-full"></div>
                    <textarea name="content" id="manuscript-editor" placeholder="Start your spiritual manuscript here..." class="flex-1 text-xl leading-relaxed text-slate-700 bg-transparent border-none p-0 focus:ring-0 placeholder-slate-200 resize-none min-h-[600px]" required>{{ old('content', $book->content) }}</textarea>
                </div>
            </div>
        </section>
    </div>
</form>

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').querySelector('img').src = e.target.result;
                document.getElementById('image-preview').classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Toggle price field based on is_free radio
    document.querySelectorAll('input[name="is_free"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const priceContainer = document.getElementById('price-container');
            if (this.value === '0') {
                priceContainer.classList.remove('hidden');
            } else {
                priceContainer.classList.add('hidden');
            }
        });
    });

    // Simple word count logic
    const editor = document.getElementById('manuscript-editor');
    const wordCountSpan = document.getElementById('word-count');
    
    function updateWordCount() {
        const text = editor.value.trim();
        const words = text ? text.split(/\s+/).length : 0;
        wordCountSpan.textContent = words;
    }
    
    editor.addEventListener('input', updateWordCount);
    window.addEventListener('load', updateWordCount);
</script>
@endpush
@endsection
