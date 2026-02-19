@extends('layouts.instructor')

@section('title', 'Chapter Builder - ' . $book->title)
@section('page_title', 'Chapter Builder')

@section('instructor_content')
<!-- Quill.js CDN -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<div class="max-w-[1600px] mx-auto space-y-10" x-data="chapterBuilder()">
    <!-- Step Indicator -->
    <div class="flex items-center justify-center gap-12 max-w-2xl mx-auto mb-10 relative">
        <div class="absolute top-1/2 left-0 w-full h-px bg-slate-100 -translate-y-1/2 -z-10"></div>
        
        <div class="flex flex-col items-center gap-2 bg-background-light px-4 opacity-40">
            <div class="size-8 rounded-full bg-emerald-500 text-white flex items-center justify-center font-black">
                <span class="material-symbols-outlined text-sm">check</span>
            </div>
            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Metadata</span>
        </div>
        
        <div class="flex flex-col items-center gap-2 bg-background-light px-4">
            <div class="size-8 rounded-full bg-primary text-white flex items-center justify-center font-black shadow-lg shadow-primary/20">2</div>
            <span class="text-[9px] font-black text-slate-900 uppercase tracking-widest">Chapters</span>
        </div>

        <div class="flex flex-col items-center gap-2 bg-background-light px-4 opacity-30">
            <div class="size-8 rounded-full bg-white border-2 border-slate-200 text-slate-400 flex items-center justify-center font-black">3</div>
            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Review</span>
        </div>
    </div>

    <!-- Analytics & Progress Header -->
    <div class="bg-white p-6 rounded-3xl border border-[#dcdfe5] shadow-sm flex items-center justify-between gap-10">
        <div class="flex-1 space-y-3">
            <div class="flex items-center justify-between text-[10px] font-black uppercase tracking-widest">
                <span class="text-slate-400">Project Progress: <span class="text-slate-900" x-text="bookPageCount">0</span> / {{ $book->pages }} Pages</span>
                <span class="text-primary" x-text="progressPercent + '%'">0%</span>
            </div>
            <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-primary transition-all duration-500" :style="'width: ' + progressPercent + '%'"></div>
            </div>
        </div>
        
        <div class="flex items-center gap-8 shrink-0">
            <div class="text-center px-6 border-r border-slate-100">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Words</p>
                <p class="text-xl font-black text-slate-900" x-text="bookWordCount">0</p>
            </div>
            <div class="text-center px-6">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Est. Read Time</p>
                <p class="text-xl font-black text-slate-900"><span x-text="bookReadTime">0</span> <small class="text-[10px] uppercase">mins</small></p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-8 h-[750px] items-stretch">
        <!-- Sidebar: Table of Contents -->
        <div class="col-span-3 bg-white rounded-[2rem] border border-[#dcdfe5] shadow-sm flex flex-col overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest">Table of Contents</h3>
                <button @click="addNewChapter()" class="size-8 bg-primary/10 text-primary rounded-lg flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                    <span class="material-symbols-outlined text-xl">add</span>
                </button>
            </div>
            
            <div class="flex-1 overflow-y-auto p-4 space-y-2">
                <template x-for="(chapter, index) in chaptersData" :key="chapter.id">
                    <button @click="selectChapter(chapter)" 
                            :class="activeChapterId == chapter.id ? 'bg-primary/5 border-primary/20 text-primary' : 'hover:bg-slate-50 border-transparent text-slate-600'"
                            class="w-full p-4 rounded-2xl border text-left transition-all group flex items-start gap-4">
                        <span class="text-[11px] font-black opacity-30 mt-1" x-text="'#' + chapter.order"></span>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-black truncate" x-text="chapter.title"></p>
                            <p class="text-[9px] font-bold opacity-50 mt-1 uppercase tracking-tighter" x-text="getChapterStats(chapter.id)">0 Words</p>
                        </div>
                    </button>
                </template>
                
                <div class="py-10 text-center px-6" x-show="chaptersData.length === 0">
                    <p class="text-[10px] font-bold text-slate-400 italic">No chapters yet. Click the + to start writing.</p>
                </div>
            </div>
            
            @if($book->chapters->isNotEmpty())
            <div class="p-4 bg-slate-50/50">
                 <button onclick="window.location.reload()" class="w-full h-12 bg-white border border-slate-200 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:border-primary/30 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-lg">sync</span>
                    Refresh Stats
                </button>
            </div>
            @endif
        </div>

        <!-- Main Workspace: Editor -->
        <div class="col-span-9 flex flex-col gap-6">
            <div class="bg-white rounded-[2rem] border border-[#dcdfe5] shadow-sm flex-1 flex flex-col overflow-hidden" x-show="activeChapterId">
                <!-- Editor Header -->
                <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                    <div class="flex-1 max-w-xl">
                        <input type="text" x-model="activeTitle" class="w-full text-lg font-black text-slate-900 border-none p-0 focus:ring-0 placeholder:text-slate-200" placeholder="Untitled Chapter">
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="text-right px-4 border-r border-slate-100">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Chapter Reading Time</p>
                            <p class="text-xs font-black text-slate-900"><span x-text="currentReadTime">0</span> Minutes</p>
                        </div>
                        <button @click="saveActiveChapter()" class="h-11 px-6 bg-primary text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-105 transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">save</span>
                            Save Progress
                        </button>
                    </div>
                </div>

                <!-- Quill Editor -->
                <div class="flex-1 flex flex-col">
                    <div id="editor" class="flex-1 bg-white border-none!"></div>
                </div>

                <!-- Editor Footer (Analytics) -->
                <div class="px-8 py-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-slate-400 text-sm">sticky_note_2</span>
                            <span class="text-[10px] font-black text-slate-900 uppercase tracking-widest"><span x-text="currentWordCount">0</span> Words</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-slate-400 text-sm">description</span>
                            <span class="text-[10px] font-black text-slate-900 uppercase tracking-widest"><span x-text="currentPageCount">0</span> Pages</span>
                        </div>
                    </div>
                    
                    <button @click="deleteChapter()" class="text-red-400 hover:text-red-600 flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm font-bold">delete</span>
                        <span class="text-[9px] font-black uppercase tracking-widest">Delete Chapter</span>
                    </button>
                </div>
            </div>
            
            <!-- Empty State -->
            <div class="bg-white rounded-[2rem] border border-[#dcdfe5] shadow-sm flex-1 flex flex-col items-center justify-center text-center p-20" x-show="!activeChapterId">
                 <div class="size-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center text-slate-200 mb-8">
                    <span class="material-symbols-outlined text-5xl font-light">edit_square</span>
                </div>
                <h3 class="text-2xl font-black text-slate-900">Choose a chapter to edit</h3>
                <p class="text-slate-500 max-w-xs mx-auto mt-4 font-medium italic">"The scariest moment is always just before you start." — Stephen King</p>
                <button @click="addNewChapter()" class="mt-10 h-14 px-10 bg-primary/10 text-primary rounded-[1.25rem] text-[10px] font-black uppercase tracking-widest hover:bg-primary hover:text-white transition-all">
                    OR CREATE A NEW ONE
                </button>
            </div>

            <!-- Footer Actions -->
            <div class="flex items-center justify-between">
                <a href="{{ route('instructor.library.edit', $book->id) }}" class="text-sm font-black text-slate-400 hover:text-slate-900 transition-all uppercase tracking-widest">
                    Back to Metadata
                </a>
                
                <div class="flex gap-4">
                    <a href="{{ route('instructor.library.index') }}" class="h-16 px-10 bg-white border border-slate-200 text-slate-600 rounded-[1.25rem] text-[11px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all flex items-center justify-center">
                        SAVE AS DRAFT
                    </a>
                    <form action="{{ route('instructor.library.publish', $book->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="h-16 px-12 bg-primary text-white rounded-[1.25rem] text-[11px] font-black uppercase tracking-widest shadow-xl shadow-primary/20 hover:scale-105 transition-all flex items-center gap-4">
                            PUBLISH BOOK
                            <span class="material-symbols-outlined">rocket_launch</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('chapterBuilder', () => ({
            activeChapterId: null,
            activeTitle: '',
            activeContent: '',
            activeOrder: 1,
            
            // Stats
            currentWordCount: 0,
            currentPageCount: 0,
            currentReadTime: 0,
            
            // Book Wide Stats
            bookWordCount: 0,
            bookPageCount: 0,
            bookReadTime: 0,
            progressPercent: 0,
            
            quill: null,
            targetPages: {{ $book->pages }},
            
            chaptersData: @json($book->chapters),

            init() {
                this.calculateBookStats();
                
                // Init Quill
                this.quill = new Quill('#editor', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'header': [1, 2, 3, false] }],
                            ['blockquote', 'code-block'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['clean']
                        ]
                    },
                    placeholder: 'Begin writing your wisdom...'
                });

                this.quill.on('text-change', () => {
                    this.activeContent = this.quill.root.innerHTML;
                    this.updateAnalytics();
                });
            },
            
            getChapterStats(id) {
                const chapter = this.chaptersData.find(c => c.id == id);
                if (!chapter) return '0 Words';
                const words = this.countWords(chapter.content || '');
                return `${words} Words`;
            },

            selectChapter(chapter) {
                this.activeChapterId = chapter.id;
                this.activeTitle = chapter.title;
                this.activeContent = chapter.content || '';
                this.activeOrder = chapter.order;
                
                this.quill.root.innerHTML = this.activeContent;
                this.updateAnalytics();
            },

            addNewChapter() {
                const title = prompt("Enter Chapter Title:");
                if (!title) return;

                fetch("{{ route('instructor.library.chapters.store', $book->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        title: title,
                        order: this.chaptersData.length + 1,
                        content: ''
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.chaptersData.push(data.chapter);
                        this.selectChapter(data.chapter);
                        this.calculateBookStats();
                    }
                })
                .catch(err => alert('Error adding chapter. Please try again.'));
            },

            countWords(str) {
                if (!str) return 0;
                const text = str.replace(/<[^>]*>/g, ' '); // remove html tags
                return text.trim().split(/\s+/).filter(word => word.length > 0).length;
            },

            updateAnalytics() {
                const words = this.countWords(this.activeContent);
                this.currentWordCount = words;
                this.currentPageCount = (words / 275).toFixed(1);
                this.currentReadTime = Math.ceil(words / 200);
            },

            calculateBookStats() {
                let totalWords = 0;
                this.chaptersData.forEach(c => {
                    totalWords += this.countWords(c.content || '');
                });

                this.bookWordCount = totalWords;
                this.bookPageCount = Math.floor(totalWords / 275);
                this.bookReadTime = Math.ceil(totalWords / 200);
                
                this.progressPercent = Math.min(100, Math.floor((this.bookPageCount / this.targetPages) * 100));
            },

            saveActiveChapter() {
                if (!this.activeChapterId) return;

                const saveBtn = event.currentTarget;
                const originalText = saveBtn.innerHTML;
                saveBtn.disabled = true;
                saveBtn.innerHTML = '<span class="material-symbols-outlined animate-spin">sync</span> SAVING...';

                fetch("{{ url('instructor/library/' . $book->id . '/chapters') }}/" + this.activeChapterId, {
                    method: 'POST', // Blade @method('PUT') will be handled by X-HTTP-Method-Override if needed, but we can also just use PUT
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'PUT',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        title: this.activeTitle,
                        content: this.activeContent,
                        order: this.activeOrder
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Update local data
                        const idx = this.chaptersData.findIndex(c => c.id == this.activeChapterId);
                        if (idx !== -1) {
                            this.chaptersData[idx].title = this.activeTitle;
                            this.chaptersData[idx].content = this.activeContent;
                        }
                        this.calculateBookStats();
                        
                        // Show Success State
                        saveBtn.innerHTML = '<span class="material-symbols-outlined">check_circle</span> SAVED';
                        setTimeout(() => {
                            saveBtn.disabled = false;
                            saveBtn.innerHTML = originalText;
                        }, 2000);
                    }
                })
                .catch(err => {
                    alert('Save failed.');
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = originalText;
                });
            },

            deleteChapter() {
                if (!confirm('Delete this chapter forever?')) return;

                fetch("{{ url('instructor/library/' . $book->id . '/chapters') }}/" + this.activeChapterId, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.chaptersData = this.chaptersData.filter(c => c.id != this.activeChapterId);
                        this.activeChapterId = null;
                        this.calculateBookStats();
                    }
                })
                .catch(err => alert('Delete failed.'));
            }
        }))
    })
</script>

<style>
    .ql-container {
        font-family: 'Inter', sans-serif !important;
        font-size: 16px !important;
        color: #1e293b !important;
        border: none !important;
        height: auto !important;
    }
    .ql-editor {
        padding: 40px !important;
        line-height: 1.8 !important;
    }
    .ql-toolbar.ql-snow {
        border: none !important;
        border-bottom: 1px solid #f1f5f9 !important;
        padding: 12px 24px !important;
    }
    .ql-editor.ql-blank::before {
        left: 40px !important;
        font-style: normal !important;
        color: #cbd5e1 !important;
        font-weight: 500 !important;
    }
</style>
@endsection
