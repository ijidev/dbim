@extends('admin.layouts.app')

@section('title', 'Edit Manuscript - Admin')

@push('styles')
<style>
    .editor-container:focus-within { border-color: #1754cf; }
    /* Custom scrollbar for sidebars */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    
    .floating-toolbar {
        position: fixed;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%);
        background: #0f172a;
        padding: 8px 24px;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        gap: 16px;
        z-index: 100;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
        border: 1px solid rgba(255,255,255,0.1);
    }
</style>
@endpush

@section('content')
<div class="flex flex-col h-[calc(100vh-64px)] -m-8 overflow-hidden bg-slate-50">
    <!-- Top Action Bar -->
    <header class="flex items-center justify-between border-b border-slate-200 bg-white px-8 py-4 z-20">
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
            <a href="{{ route('library.read', $book->slug) }}" target="_blank" class="flex items-center justify-center rounded-xl h-11 px-6 bg-slate-100 text-slate-600 text-sm font-black hover:bg-slate-200 transition-all uppercase tracking-widest">
                <span class="material-symbols-outlined text-sm mr-2">visibility</span>
                <span>View Site</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center justify-center rounded-xl h-11 px-6 bg-red-50 text-red-600 text-sm font-black hover:bg-red-100 transition-all uppercase tracking-widest">
                     Logout
                </button>
            </form>
        </div>
    </header>

    <div class="flex flex-1 overflow-hidden">
        <!-- Left Sidebar: Metadata -->
        <aside class="w-80 border-r border-slate-200 bg-white overflow-y-auto p-8 custom-scrollbar space-y-8">
            <form id="book-metadata-form" action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div>
                    <h3 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">info</span> Book Details
                    </h3>
                    <div class="space-y-6">
                        <div class="flex flex-col gap-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Author Name</label>
                            <input type="text" name="author" value="{{ old('author', $book->author) }}" class="w-full bg-slate-50 border-none rounded-xl p-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all" required>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Genre / Category</label>
                            <select name="category" class="w-full bg-slate-50 border-none rounded-xl p-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                                <option value="Theology" {{ $book->category == 'Theology' ? 'selected' : '' }}>Theology</option>
                                <option value="History" {{ $book->category == 'History' ? 'selected' : '' }}>History</option>
                                <option value="Devotional" {{ $book->category == 'Devotional' ? 'selected' : '' }}>Devotional</option>
                                <option value="Biography" {{ $book->category == 'Biography' ? 'selected' : '' }}>Biography</option>
                                <option value="Leadership" {{ $book->category == 'Leadership' ? 'selected' : '' }}>Leadership</option>
                                <option value="Faith" {{ $book->category == 'Faith' ? 'selected' : '' }}>Faith</option>
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
                            <input type="number" step="0.01" name="price" value="{{ old('price', $book->price) }}" class="w-full bg-slate-50 border-none rounded-xl p-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Approx. Pages</label>
                            <input type="number" name="pages" value="{{ old('pages', $book->pages) }}" class="w-full bg-slate-50 border-none rounded-xl p-4 text-sm font-bold focus:ring-2 focus:ring-primary transition-all">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Cover Image</label>
                            <div class="relative group cursor-pointer border-2 border-dashed border-slate-200 rounded-2xl aspect-[3/4] flex flex-col items-center justify-center gap-3 hover:border-primary transition-all bg-slate-50/50">
                                <input type="file" name="cover_image" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewImage(this)">
                                <div id="image-preview" class="absolute inset-0 rounded-2xl overflow-hidden {{ $book->cover_image ? '' : 'hidden' }}">
                                    <img src="{{ $book->cover_image ? asset($book->cover_image) : '' }}" class="w-full h-full object-cover">
                                </div>
                                <span class="material-symbols-outlined text-4xl {{ $book->cover_image ? 'hidden' : '' }} text-slate-300 group-hover:text-primary transition-colors">upload_file</span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </aside>

        <!-- Center: Editor Content Area -->
        <section class="flex-1 bg-slate-100 overflow-hidden flex flex-col relative">
            <!-- Floating Editor Toolbar (Sub-toolbar) -->
            <div class="absolute top-6 left-1/2 -translate-x-1/2 bg-white shadow-xl border border-slate-200 rounded-2xl p-2 flex items-center gap-1 z-30">
                <button type="button" class="p-2 hover:bg-slate-100 rounded-lg text-slate-600"><span class="material-symbols-outlined">format_bold</span></button>
                <button type="button" class="p-2 hover:bg-slate-100 rounded-lg text-slate-600"><span class="material-symbols-outlined">format_italic</span></button>
                <div class="w-px h-6 bg-slate-200 mx-1"></div>
                <button type="button" class="p-2 hover:bg-slate-100 rounded-lg text-slate-600"><span class="material-symbols-outlined">format_h1</span></button>
                <button type="button" class="p-2 hover:bg-slate-100 rounded-lg text-slate-600"><span class="material-symbols-outlined">format_h2</span></button>
                <div class="w-px h-6 bg-slate-200 mx-1"></div>
                <button type="button" class="p-2 hover:bg-slate-100 rounded-lg text-slate-600"><span class="material-symbols-outlined">image</span></button>
            </div>

            <!-- Content Workspace -->
            <div class="flex-1 overflow-y-auto p-12 custom-scrollbar flex justify-center pt-24 pb-32">
                <div class="max-w-3xl w-full bg-white shadow-2xl rounded-2xl min-h-[1000px] p-20 flex flex-col gap-8 editor-container border-2 border-transparent transition-all">
                    <input type="text" id="chapter-title-input" placeholder="Chapter Title..." class="text-4xl font-black bg-transparent border-none p-0 focus:ring-0 placeholder-slate-200">
                    <textarea id="chapter-content-input" class="flex-1 text-lg bg-transparent border-none p-0 focus:ring-0 resize-none placeholder-slate-200 min-h-[800px] leading-relaxed" placeholder="Start writing your manuscript..."></textarea>
                </div>
            </div>

            <!-- Floating Global Footer Toolbar -->
            <div class="floating-toolbar">
                <div class="flex items-center gap-2 text-primary">
                    <span class="material-symbols-outlined text-xl">cloud_done</span>
                    <span class="text-[10px] font-black uppercase tracking-widest">All changes saved locally</span>
                </div>
                <div class="w-px h-6 bg-slate-700"></div>
                <div class="flex items-center gap-3">
                    <button type="button" onclick="saveCurrentChapter()" class="text-white text-xs font-black uppercase tracking-widest hover:text-primary transition-all">Save Chapter</button>
                    <button type="button" onclick="document.getElementById('book-metadata-form').submit()" class="bg-primary text-white text-xs font-black px-6 py-2.5 rounded-full hover:opacity-90 transition-all uppercase tracking-widest">Update & Publish</button>
                </div>
            </div>
        </section>

        <!-- Right Sidebar: Chapters -->
        <aside class="w-72 border-l border-slate-200 bg-white flex flex-col">
            <div class="p-6 border-b border-slate-200 flex items-center justify-between">
                <h3 class="text-xs font-black uppercase tracking-widest text-slate-400">Chapters</h3>
                <button onclick="createNewChapter()" class="size-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center hover:bg-primary/20 transition-colors">
                    <span class="material-symbols-outlined text-xl">add</span>
                </button>
            </div>
            <div id="chapters-list" class="flex-1 overflow-y-auto p-4 custom-scrollbar space-y-2">
                @foreach($book->chapters as $chapter)
                <div onclick="loadChapter({{ $chapter->id }})" id="chapter-item-{{ $chapter->id }}" class="chapter-item group flex items-center gap-3 p-3 hover:bg-slate-50 border border-transparent rounded-xl cursor-pointer transition-all">
                    <span class="material-symbols-outlined text-slate-300">drag_indicator</span>
                    <div class="flex-1">
                        <p class="text-xs font-black text-slate-700 truncate chapter-title">{{ $chapter->title }}</p>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Chapter {{ $loop->iteration }}</p>
                    </div>
                    <button onclick="event.stopPropagation(); deleteChapter({{ $chapter->id }})" class="opacity-0 group-hover:opacity-100 text-slate-300 hover:text-red-500 transition-all">
                        <span class="material-symbols-outlined text-sm">delete</span>
                    </button>
                </div>
                @endforeach
            </div>
        </aside>
    </div>
</div>

@push('scripts')
<script>
    let currentChapterId = null;

    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').classList.remove('hidden');
                document.getElementById('image-preview').querySelector('img').src = e.target.result;
                input.nextElementSibling.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Pricing Model Toggle
    document.querySelectorAll('input[name="is_free"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            const priceContainer = document.getElementById('price-container');
            if (e.target.value === '0') {
                priceContainer.classList.remove('hidden');
            } else {
                priceContainer.classList.add('hidden');
            }
        });
    });

    // Chapter Management
    async function createNewChapter() {
        const title = prompt("Enter Chapter Title:");
        if (!title) return;

        try {
            const response = await fetch("{{ route('admin.books.chapters.store', $book->id) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ title })
            });
            const chapter = await response.json();
            
            // Append to list
            const list = document.getElementById('chapters-list');
            const item = document.createElement('div');
            item.id = `chapter-item-${chapter.id}`;
            item.className = "chapter-item group flex items-center gap-3 p-3 hover:bg-slate-50 border border-transparent rounded-xl cursor-pointer transition-all";
            item.onclick = () => loadChapter(chapter.id);
            item.innerHTML = `
                <span class="material-symbols-outlined text-slate-300">drag_indicator</span>
                <div class="flex-1">
                    <p class="text-xs font-black text-slate-700 truncate chapter-title">${chapter.title}</p>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">New Chapter</p>
                </div>
                <button onclick="event.stopPropagation(); deleteChapter(${chapter.id})" class="opacity-0 group-hover:opacity-100 text-slate-300 hover:text-red-500 transition-all">
                    <span class="material-symbols-outlined text-sm">delete</span>
                </button>
            `;
            list.appendChild(item);
            loadChapter(chapter.id);
        } catch (error) {
            console.error(error);
        }
    }

    async function loadChapter(id) {
        document.querySelectorAll('.chapter-item').forEach(el => el.classList.remove('bg-primary/5', 'border-primary/20'));
        document.getElementById(`chapter-item-${id}`).classList.add('bg-primary/5', 'border-primary/20');
        
        currentChapterId = id;
        try {
            const response = await fetch(`/admin/chapters/${id}`);
            const chapter = await response.json();
            document.getElementById('chapter-title-input').value = chapter.title;
            document.getElementById('chapter-content-input').value = chapter.content || '';
        } catch (error) {
            console.error(error);
        }
    }

    async function saveCurrentChapter() {
        if (!currentChapterId) {
            alert("Select or create a chapter first.");
            return;
        }

        const title = document.getElementById('chapter-title-input').value;
        const content = document.getElementById('chapter-content-input').value;

        try {
            const response = await fetch(`/admin/chapters/${currentChapterId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ title, content })
            });
            const data = await response.json();
            if (data.success) {
                // Update title in list
                document.querySelector(`#chapter-item-${currentChapterId} .chapter-title`).innerText = title;
                // Show success toast (optional)
            }
        } catch (error) {
            console.error(error);
        }
    }

    async function deleteChapter(id) {
        if (!confirm("Are you sure?")) return;

        try {
            await fetch(`/admin/chapters/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            document.getElementById(`chapter-item-${id}`).remove();
            if (currentChapterId === id) {
                document.getElementById('chapter-title-input').value = '';
                document.getElementById('chapter-content-input').value = '';
                currentChapterId = null;
            }
        } catch (error) {
            console.error(error);
        }
    }

    // Auto-load first chapter on refresh
    window.addEventListener('load', () => {
        const first = document.querySelector('.chapter-item');
        if (first) first.click();
    });
</script>
@endpush
@endsection
