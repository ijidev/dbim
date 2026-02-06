@extends('layouts.app')

@section('title', $book->title . ' - Digital Library')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,200..900;1,200..900&family=Metamorphous&family=Lora:ital,wght@0,400..700;1,400..700&display=swap');

    :root {
        --primary: #0f49bd;
        --bg-dark: #101622;
        --surface-dark: #0f172a;
        --border-dark: #1e293b;
    }

    .font-manuscript { font-family: 'Crimson Pro', serif; }
    .font-serif-study { font-family: 'Lora', serif; }

    /* Premium Dark Theme Override */
    .reader-dark-base {
        background-color: var(--bg-dark);
        color: #e2e8f0;
    }

    .glass-nav {
        background: rgba(15, 23, 42, 0.8);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }

    .text-justify-custom { text-align: justify; text-justify: inter-word; }

    /* Highlighting */
    .hl-gold { background-color: rgba(255, 215, 0, 0.2); border-bottom: 2px solid #ffd700; color: #fff; }
    .hl-blue { background-color: rgba(147, 197, 253, 0.2); border-bottom: 2px solid #93c5fd; color: #fff; }
    .hl-green { background-color: rgba(134, 239, 172, 0.2); border-bottom: 2px solid #86efac; color: #fff; }
    
    .current-word {
        background-color: var(--primary);
        color: white !important;
        border-radius: 4px;
        padding: 0 2px;
    }

    .no-scrollbar::-webkit-scrollbar { display: none; }
    
    /* Layout heights */
    .content-height { height: calc(100vh - 65px - 90px); } /* Nav - Player */
</style>
@endpush

@section('content')
<div class="h-screen flex flex-col overflow-hidden reader-dark-base">
    <!-- Reader Navigation -->
    <nav class="h-[65px] flex items-center glass-nav border-b border-white/5 px-6 z-50">
        <div class="w-full h-full flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="{{ route('library.index') }}" class="group flex items-center gap-2 text-slate-400 hover:text-white transition-colors text-sm font-bold uppercase tracking-widest">
                    <span class="material-symbols-outlined text-xl transition-transform group-hover:-translate-x-1">arrow_back</span>
                    <span class="hidden sm:inline">Back</span>
                </a>
                <div class="h-6 w-px bg-white/10"></div>
                <div>
                    <h2 class="text-[10px] font-black text-primary uppercase tracking-[0.2em] mb-0.5">{{ $book->title }}</h2>
                    <h1 class="text-xs sm:text-sm font-black text-white leading-tight line-clamp-1 chapter-title-display">{{ $book->chapters->first()->title ?? $book->title }}</h1>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button onclick="toggleChapters()" class="lg:hidden flex h-10 items-center gap-2 rounded-xl bg-white/5 border border-white/10 px-4 text-[10px] font-black text-slate-300 hover:bg-primary/20 hover:text-primary transition-all uppercase tracking-widest">
                    <span class="material-symbols-outlined text-[18px]">menu_book</span>
                    <span>TOC</span>
                </button>
                <div class="hidden lg:flex items-center bg-white/5 rounded-xl p-1 border border-white/10">
                    <button onclick="changeMode('sepia')" class="p-2 rounded-lg hover:bg-white/10 text-slate-400 transition-all"><span class="material-symbols-outlined text-lg text-amber-600">texture</span></button>
                    <button onclick="changeMode('dark')" class="p-2 rounded-lg bg-white/10 text-primary transition-all"><span class="material-symbols-outlined text-lg">dark_mode</span></button>
                    <div class="w-px h-4 bg-white/10 mx-1"></div>
                    <button onclick="adjustFontSize(2)" class="p-2 rounded-lg hover:bg-white/10 text-slate-400 transition-all"><span class="text-xs font-black">Aa+</span></button>
                </div>
                <button onclick="toggleAnnotations()" class="lg:hidden flex h-10 w-10 items-center justify-center rounded-xl bg-white/5 border border-white/10 text-slate-300 hover:bg-primary/20 hover:text-primary transition-all">
                    <span class="material-symbols-outlined text-[20px]">edit_note</span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Reading Progress Bar (Top) -->
    <div class="h-1 bg-white/5 z-50 overflow-hidden">
        <div id="reading-progress" class="h-full bg-primary transition-all duration-300 w-0 shadow-[0_0_10px_rgba(15,73,189,0.5)]"></div>
    </div>

    <!-- Main Reader Workspace -->
    <div id="reader-container" class="flex-1 flex overflow-hidden font-serif-study relative">
        <!-- Persistent Left Sidebar (Desktop) -->
        <aside id="desktop-sidebar" class="hidden lg:flex w-64 bg-surface-dark border-r border-white/5 flex-col shrink-0 overflow-y-auto no-scrollbar">
            <div class="p-6">
                <div class="flex items-center gap-2 text-primary mb-1">
                    <span class="material-symbols-outlined text-lg">auto_stories</span>
                    <span class="text-[10px] font-black uppercase tracking-widest">Table of Contents</span>
                </div>
                <h3 class="text-md font-bold text-white mb-6">{{ $book->title }}</h3>
                <div class="space-y-1">
                    @foreach($book->chapters as $chap)
                        <div onclick="switchChapter({{ $chap->id }}, '{{ addslashes($chap->title) }}', {{ $loop->index }})" class="chapter-nav-item p-3.5 rounded-xl hover:bg-white/5 cursor-pointer border border-transparent transition-all group {{ $loop->first ? 'bg-primary/10 border-primary/20' : '' }}" data-id="{{ $chap->id }}" data-index="{{ $loop->index }}">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-primary text-lg mt-0.5 {{ $loop->first ? 'active-icon' : '' }}">{{ $loop->first ? 'menu_book' : 'check_circle' }}</span>
                                <div>
                                    <p class="text-xs font-bold text-slate-300 group-hover:text-white transition-colors line-clamp-2 leading-relaxed">{{ $chap->title }}</p>
                                    <p class="text-[9px] text-slate-500 font-bold uppercase tracking-widest mt-1">Section {{ $loop->iteration }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </aside>

        <!-- Chapter Sidebar Drawer (Mobile) -->
        <div id="chapters-drawer" class="lg:hidden fixed inset-y-0 left-0 w-80 bg-surface-dark shadow-2xl z-[60] transform -translate-x-full transition-transform duration-500 ease-in-out border-r border-white/5">
            <div class="p-8 h-full flex flex-col">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400">Chapters</h3>
                    <button onclick="toggleChapters()" class="text-slate-500 hover:text-white">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto space-y-2 no-scrollbar">
                    @foreach($book->chapters as $chap)
                        <div onclick="switchChapter({{ $chap->id }}, '{{ addslashes($chap->title) }}', {{ $loop->index }})" class="chapter-nav-item p-4 rounded-xl hover:bg-white/5 cursor-pointer border border-transparent transition-all group {{ $loop->first ? 'bg-primary/10 border-primary/20' : '' }}" data-id="{{ $chap->id }}" data-index="{{ $loop->index }}">
                            <p class="text-sm font-bold text-slate-300 group-hover:text-white transition-colors">{{ $chap->title }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Book Content Area -->
        <main id="scroll-container" class="flex-1 overflow-y-auto bg-bg-dark no-scrollbar relative scroll-smooth px-6">
            <div class="max-w-3xl mx-auto py-16 lg:py-24">
                <header class="mb-12 border-b border-white/5 pb-10">
                    <div class="flex items-center gap-2 text-slate-500 text-[10px] mb-6 uppercase tracking-widest font-black">
                        <span>Library</span>
                        <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                        <span>{{ $book->title }}</span>
                    </div>
                    <h1 class="text-4xl sm:text-5xl font-bold text-white mb-6 leading-tight font-manuscript chapter-title-display">{{ $book->chapters->first()->title ?? $book->title }}</h1>
                    <div class="flex items-center gap-6">
                        <span class="text-[10px] font-black uppercase tracking-widest text-primary">Read: 12 mins</span>
                        <div class="w-1.5 h-1.5 rounded-full bg-white/10"></div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Audio: 15 mins</span>
                    </div>
                </header>

                <article id="reader-body" class="prose prose-invert prose-slate prose-lg lg:prose-xl max-w-none text-slate-300 leading-[2] font-serif-study text-justify-custom whitespace-pre-wrap transition-all duration-300" style="font-size: 20px;">
                    {!! $book->chapters->first()->content ?? $book->content !!}
                </article>

                <!-- Chapter Navigation -->
                <div class="mt-20 pt-10 border-t border-white/5 flex items-center justify-between">
                    <button id="prev-btn" onclick="navigateChapter(-1)" class="flex items-center gap-3 px-8 py-4 rounded-2xl bg-white/5 border border-white/10 text-slate-500 hover:text-white hover:border-slate-600 transition-all group disabled:opacity-20 disabled:pointer-events-none">
                        <span class="material-symbols-outlined transition-transform group-hover:-translate-x-1">west</span>
                        <span class="text-[10px] font-black uppercase tracking-widest">Previous</span>
                    </button>
                    <button id="next-btn" onclick="navigateChapter(1)" class="flex items-center gap-3 px-8 py-4 rounded-2xl bg-primary text-white shadow-xl shadow-primary/30 hover:scale-105 transition-all group disabled:opacity-20 disabled:pointer-events-none">
                        <span class="nav-text text-[10px] font-black uppercase tracking-widest">Next Chapter</span>
                        <span class="material-symbols-outlined transition-transform group-hover:translate-x-1">east</span>
                    </button>
                </div>
            </div>
        </main>

        <!-- Persistent Right Sidebar (Desktop) -->
        <aside id="annotation-sidebar-persistent" class="hidden lg:flex w-72 bg-surface-dark border-l border-white/5 flex-col shrink-0 overflow-y-auto no-scrollbar">
            <div class="p-8 h-full flex flex-col">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">history_edu</span>
                        <h2 class="text-[10px] font-black uppercase tracking-widest text-white">My Annotations</h2>
                    </div>
                    <span class="text-[9px] font-black bg-primary/20 text-primary px-2 py-1 rounded">STUDY MODE</span>
                </div>
                <div class="active-annotations-list flex-1 space-y-4">
                    <!-- Notes via JS -->
                </div>
                <div class="mt-8 pt-8 border-t border-white/5">
                    <button class="w-full py-4 bg-white/5 text-slate-400 border border-white/10 rounded-2xl text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-primary/10 hover:text-white transition-all shadow-xl">
                        <span class="material-symbols-outlined text-sm">download</span>
                        Export Annotations
                    </button>
                </div>
            </div>
        </aside>

        <!-- Annotation Sidebar Drawer (Mobile) -->
        <aside id="annotation-sidebar" class="fixed right-0 top-0 h-full w-80 bg-surface-dark border-l border-white/5 translate-x-full transition-transform duration-500 z-[55] flex flex-col shadow-2xl">
            <div class="p-8 border-b border-white/5 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">history_edu</span>
                    <h2 class="text-base font-bold text-white">Annotations</h2>
                </div>
                <button onclick="toggleAnnotations()" class="text-slate-500 hover:text-white transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="annotations-list-drawer flex-1 overflow-y-auto p-6 space-y-4 no-scrollbar"></div>
        </aside>
    </div>

    <!-- Toolkit & Modals -->
    <div id="drawer-overlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[52] hidden transition-opacity duration-500 opacity-0" onclick="closeDrawers()"></div>

    <div id="highlight-toolkit" class="fixed z-[70] hidden flex items-center bg-slate-900 text-white rounded-2xl shadow-2xl p-1 animate-in fade-in zoom-in duration-200">
        <div class="flex items-center gap-2 px-3 border-r border-slate-700">
            <button onclick="applyHighlight('hl-gold')" class="w-7 h-7 rounded-full bg-[#ffd700] border-2 border-white/20 hover:scale-110 transition-transform shadow-sm" title="Insight"></button>
            <button onclick="applyHighlight('hl-blue')" class="w-7 h-7 rounded-full bg-[#93c5fd] border-2 border-white/20 hover:scale-110 transition-transform shadow-sm" title="Meditation"></button>
            <button onclick="applyHighlight('hl-green')" class="w-7 h-7 rounded-full bg-[#86efac] border-2 border-white/20 hover:scale-110 transition-transform shadow-sm" title="Promise"></button>
        </div>
        <button onclick="showNoteModal()" class="flex items-center gap-2 px-4 py-2.5 text-[11px] font-black uppercase tracking-[0.1em] hover:bg-slate-800 rounded-xl transition-colors">
            <span class="material-symbols-outlined text-sm">add_comment</span>
            <span>Add Note</span>
        </button>
        <div class="absolute -bottom-1.5 left-1/2 -translate-x-1/2 w-3 h-3 bg-slate-900 rotate-45"></div>
    </div>

    <!-- Note Modal -->
    <div id="note-modal" class="fixed inset-0 z-[80] hidden flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeNoteModal()"></div>
        <div class="relative w-full max-w-lg bg-surface-dark border border-white/10 rounded-[32px] shadow-2xl p-8 animate-in fade-in zoom-in duration-300">
            <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">add_comment</span>
                Add Personal Note
            </h3>
            <textarea id="note-text" rows="4" class="w-full bg-white/5 border border-white/10 rounded-2xl p-5 text-sm text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none resize-none" placeholder="What truth are you meditating on in this passage?"></textarea>
            <div class="mt-6 flex items-center justify-end gap-4">
                <button onclick="closeNoteModal()" class="px-6 py-3 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-white">Cancel</button>
                <button onclick="saveNote()" class="px-8 py-3 bg-primary text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-primary/20 hover:opacity-90 transition-all">Save Note</button>
            </div>
        </div>
    </div>

    <!-- TTS Player Footer -->
    <div id="tts-player" class="h-[90px] bg-surface-dark border-t border-white/5 z-[60] shadow-[0_-15px_30px_rgba(0,0,0,0.5)] px-6 relative transition-transform duration-500 {{ auth()->check() ? '' : 'hidden' }}">
        <!-- Progress Bar at the very top of player bar -->
        <div class="absolute top-0 left-0 w-full h-[3px] bg-white/5 cursor-pointer group" onclick="handleSeek(event)">
            <div id="voice-progress" class="bg-primary h-full transition-all duration-300 w-0"></div>
            <div class="absolute top-1/2 -translate-y-1/2 w-4 h-4 bg-white rounded-full shadow-xl opacity-0 group-hover:opacity-100 transition-opacity translate-x-[-1px]" id="voice-handle" style="left: 0%;"></div>
        </div>

        <div class="max-w-7xl mx-auto h-full flex items-center justify-between gap-6">
            <!-- Left: Stats -->
            <div class="flex items-center gap-4 w-72">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-3xl active-icon">graphic_eq</span>
                </div>
                <div class="hidden md:block">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-0.5">Now Listening</p>
                    <p class="text-xs font-bold text-white leading-tight chapter-title-display-small line-clamp-1">{{ $book->chapters->first()->title ?? $book->title }}</p>
                </div>
            </div>

            <!-- Center: Transport -->
            <div class="flex flex-col items-center gap-1 flex-1">
                <div class="flex items-center gap-10">
                    <button onclick="seekVoice(-5)" class="text-slate-500 hover:text-primary transition-all active:scale-90"><span class="material-symbols-outlined text-2xl">replay_5</span></button>
                    <button id="main-play-btn" onclick="toggleVoice()" class="w-12 h-12 rounded-full bg-white text-primary flex items-center justify-center hover:scale-105 active:scale-95 transition-all shadow-[0_0_20px_rgba(15,73,189,0.4)]">
                        <span class="material-symbols-outlined text-3xl active-icon" id="main-play-icon">play_arrow</span>
                    </button>
                    <button onclick="seekVoice(5)" class="text-slate-500 hover:text-primary transition-all active:scale-90"><span class="material-symbols-outlined text-2xl">forward_5</span></button>
                </div>
                <div class="flex items-center gap-4 text-[9px] font-black uppercase tracking-[0.2em] text-slate-500">
                    <span id="voice-current-time">00:00</span>
                    <div class="w-1 h-1 rounded-full bg-white/10"></div>
                    <span id="voice-duration">00:00</span>
                </div>
            </div>

            <!-- Right: Options -->
            <div class="flex items-center justify-end gap-6 w-72">
                <div class="flex items-center bg-white/5 border border-white/10 rounded-xl p-1">
                    <button onclick="setSpeed(1)" class="speed-btn px-4 py-1.5 text-[9px] font-black uppercase rounded-lg text-primary bg-white/10 shadow-sm transition-all">1.0x</button>
                    <button onclick="setSpeed(1.5)" class="speed-btn px-4 py-1.5 text-[9px] font-black uppercase rounded-lg text-slate-500 hover:text-white transition-all">1.5x</button>
                    <button onclick="setSpeed(2)" class="speed-btn px-4 py-1.5 text-[9px] font-black uppercase rounded-lg text-slate-500 hover:text-white transition-all">2.0x</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const readerContainer = document.getElementById('reader-container');
    const readerBody = document.getElementById('reader-body');
    const progressBar = document.getElementById('reading-progress');
    const drawer = document.getElementById('chapters-drawer');
    const overlay = document.getElementById('drawer-overlay');
    const annotationSidebar = document.getElementById('annotation-sidebar');
    
    let currentFontSize = 20;
    let activeChapterId = {{ $book->chapters->first()->id ?? 'null' }};
    let activeChapterIndex = 0;
    let totalChapters = {{ $book->chapters->count() }};
    let lastSavedPercentage = 0;

    // --- Drawer Management ---
    function toggleChapters() {
        drawer.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
        setTimeout(() => overlay.classList.toggle('opacity-100'), 10);
    }

    function toggleAnnotations() {
        annotationSidebar.classList.toggle('translate-x-full');
        overlay.classList.toggle('hidden');
        setTimeout(() => overlay.classList.toggle('opacity-100'), 10);
    }

    function closeDrawers() {
        drawer.classList.add('-translate-x-full');
        annotationSidebar.classList.add('translate-x-full');
        overlay.classList.remove('opacity-100');
        setTimeout(() => overlay.classList.add('hidden'), 500);
    }

    // --- Chapter Navigation ---
    async function switchChapter(id, title, index) {
        if (isSpeaking) pauseVoice();
        
        activeChapterId = id;
        activeChapterIndex = index;
        
        // Close menus
        closeDrawers();
        
        // Update Nav UI (Both sidebars)
        document.querySelectorAll('.chapter-nav-item').forEach(el => el.classList.remove('bg-primary/5', 'border-primary/20'));
        document.querySelectorAll(`.chapter-nav-item[data-id="${id}"]`).forEach(el => el.classList.add('bg-primary/5', 'border-primary/20'));
        
        document.querySelectorAll('.chapter-title-display').forEach(el => el.innerText = title);
        const smallDisplay = document.querySelector('.chapter-title-display-small');
        if (smallDisplay) smallDisplay.innerText = title;

        // Fetch Content
        try {
            // Robust base URL handling
            const baseUrl = window.location.pathname.split('/library/')[0];
            const response = await fetch(`${baseUrl}/library/chapter/${id}`);
            const chapter = await response.json();
            
            if (chapter.content) {
                readerBody.innerHTML = chapter.content;
            } else {
                readerBody.innerHTML = '<p class="text-slate-300 italic">No content available.</p>';
            }
            
            // Update Navigation Buttons visibility
            updateNavButtons();
            
            // Reset state
            window.scrollTo({ top: 0, behavior: 'smooth' });
            updateProgress(0);
            
            // Reset voice state
            wordIndex = 0; 
            prepareUtterance();

            // Reload Annotations for new chapter
            annotations = JSON.parse(localStorage.getItem('annotations_' + activeChapterId) || '[]');
            renderAnnotations();
        } catch (error) { 
            console.error("Fetch Error:", error);
            alert("Failed to load chapter content. Please check your connection.");
        }
    }

    function updateNavButtons() {
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        
        if (prevBtn) prevBtn.disabled = activeChapterIndex === 0;
        if (nextBtn) nextBtn.disabled = activeChapterIndex === totalChapters - 1;
        if (nextBtn) nextBtn.querySelector('.nav-text').innerText = (activeChapterIndex === totalChapters - 1) ? 'Finish Reading' : 'Next Chapter';
    }

    function navigateChapter(direction) {
        const nextIndex = activeChapterIndex + direction;
        if (nextIndex >= 0 && nextIndex < totalChapters) {
            const nextItem = document.querySelector(`.chapter-nav-item[data-index="${nextIndex}"]`);
            const nextId = nextItem.getAttribute('data-id');
            const nextTitle = nextItem.querySelector('p').innerText;
            switchChapter(nextId, nextTitle, nextIndex);
        }
    }

    // --- Voice Reader Logic (Advanced) ---
    let synth = window.speechSynthesis;
    let utterance = null;
    let isSpeaking = false;
    let isPaused = false;
    let currentRate = 1;
    let wordIndex = 0;
    let words = [];

    function prepareUtterance() {
        if (synth.speaking) synth.cancel();
        
        const text = readerBody.innerText;
        utterance = new SpeechSynthesisUtterance(text.substring(wordIndex));
        utterance.rate = currentRate;
        utterance.pitch = currentRate > 1 ? 0.8 : (currentRate < 1 ? 1.2 : 1.0);

        utterance.onstart = () => {
            isSpeaking = true;
            isPaused = false;
            updateVoiceUI();
            startProgressTracking();
        };

        utterance.onboundary = (event) => {
            if (event.name === 'word') {
                const absoluteIndex = wordIndex + event.charIndex;
                currentSpokenIndex = absoluteIndex; 
                highlightCurrentWord(absoluteIndex, event.charLength);
                updateTtsProgress(absoluteIndex, text.length);
            }
        };

        utterance.onend = () => {
            stopVoice();
        };
    }

    function toggleVoice() {
        if (isSpeaking) {
            if (isPaused) resumeVoice();
            else pauseVoice();
        } else {
            startVoice();
        }
    }

    let progressInterval = null;

    function startVoice() {
        if (!utterance) prepareUtterance();
        synth.speak(utterance);
        // Tracking now starts in onstart event
    }

    function pauseVoice() {
        synth.pause();
        isPaused = true;
        updateVoiceUI();
        stopProgressTracking();
    }

    function resumeVoice() {
        synth.resume();
        isPaused = false;
        updateVoiceUI();
        startProgressTracking();
    }

    function stopVoice() {
        synth.cancel();
        isSpeaking = false;
        isPaused = false;
        updateVoiceUI();
        clearWordHighlight();
        stopProgressTracking();
    }

    let currentSpokenIndex = 0;

    function startProgressTracking() {
        if (progressInterval) clearInterval(progressInterval);
        const text = readerBody.innerText;
        const totalChars = text.length;
        currentSpokenIndex = wordIndex;
        
        progressInterval = setInterval(() => {
            if (isSpeaking && !isPaused) {
                // Instead of blindly incrementing, we interpolate but don't wander too far
                // anchor to currentSpokenIndex (updated by onboundary)
                wordIndex = Math.max(wordIndex, currentSpokenIndex);
                wordIndex += (15 * currentRate / 20); // Slower incremental crawl (50ms)
                
                if (wordIndex >= totalChars) {
                    wordIndex = totalChars;
                    stopProgressTracking();
                }
                updateTtsProgress(wordIndex, totalChars);
            }
        }, 50);
    }

    function stopProgressTracking() {
        if (progressInterval) {
            clearInterval(progressInterval);
            progressInterval = null;
        }
    }

    function updateVoiceUI() {
        const icon = document.getElementById('main-play-icon');
        if (isSpeaking && !isPaused) {
            icon.innerText = 'pause';
        } else {
            icon.innerText = 'play_arrow';
        }
    }

    function setSpeed(rate) {
        currentRate = rate;
        document.querySelectorAll('.speed-btn').forEach(btn => {
            btn.classList.remove('text-primary', 'bg-white', 'shadow-sm');
            btn.classList.add('text-slate-400');
        });
        const activeBtn = document.getElementById(`speed-${rate}`.replace('.', '-'));
        if (activeBtn) {
            activeBtn.classList.add('text-primary', 'bg-white', 'shadow-sm');
            activeBtn.classList.remove('text-slate-400');
        }
        
        if (isSpeaking) {
            // Restart with new rate from current position if possible
            // Web Speech API is limited here, simple restart from beginning for now
            const wasSpeaking = !isPaused;
            stopVoice();
            prepareUtterance();
            if (wasSpeaking) startVoice();
        }
    }

    function seekVoice(delta) {
        if (!isSpeaking) return;
        
        const text = readerBody.innerText;
        const charsPerSec = 15 * currentRate;
        const charDelta = delta * charsPerSec;
        
        // Approximate new word index
        wordIndex = Math.max(0, Math.min(text.length - 1, (wordIndex || 0) + charDelta));
        
        // Find nearest space to avoid cutting words
        const nextSpace = text.indexOf(' ', wordIndex);
        if (nextSpace !== -1) wordIndex = nextSpace + 1;

        const wasPaused = isPaused;
        stopVoice();
        prepareUtterance();
        isSpeaking = true;
        if (!wasPaused) startVoice();
        
        updateTtsProgress(wordIndex, text.length);
    }

    function highlightCurrentWord(charIndex, charLength) {
        // Clear previous
        clearWordHighlight();
        
        // For performance, we don't rebuild the whole DOM.
        // We find the text node and wrap the word if possible.
        // For this implementation, we use a slightly more robust 'readerBody.innerHTML' approach
        // but it's still better to wrap words in spans initially if we want smooth high-speed performance.
        // For now, let's just make the simple one work without breaking.
    }

    function clearWordHighlight() {
        document.querySelectorAll('.current-word').forEach(el => {
            const parent = el.parentNode;
            if (parent) {
                parent.replaceChild(document.createTextNode(el.innerText), el);
                parent.normalize();
            }
        });
    }

    function handleSeek(event) {
        const rect = event.currentTarget.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const percent = (x / rect.width) * 100;
        
        // Mock seek for Speech API (restricted)
        console.log("Mock Seek to " + percent + "%");
    }

    function updateTtsProgress(charIndex, totalLength) {
        const percent = (charIndex / totalLength) * 100;
        const progressEl = document.getElementById('voice-progress');
        const handleEl = document.getElementById('voice-handle');
        if (progressEl) progressEl.style.width = percent + '%';
        if (handleEl) handleEl.style.left = percent + '%';
        
        const totalEstimatedSec = totalLength / 15;
        const currentSec = Math.floor(totalEstimatedSec * (percent / 100));
        document.getElementById('voice-current-time').innerText = formatTime(currentSec);
        document.getElementById('voice-duration').innerText = formatTime(totalEstimatedSec);
    }

    function formatTime(sec) {
        const m = Math.floor(sec / 60);
        const s = Math.floor(sec % 60);
        return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
    }

    // --- Highlighting & Annotations ---
    let currentSelection = null;
    let annotations = JSON.parse(localStorage.getItem('annotations_' + activeChapterId) || '[]');

    document.addEventListener('mouseup', handleTextSelection);

    function handleTextSelection(e) {
        if (e && e.target.closest('#highlight-toolkit') || e && e.target.closest('#note-modal')) return;

        const selection = window.getSelection();
        const text = selection.toString().trim();
        const toolkit = document.getElementById('highlight-toolkit');

        if (text.length > 5) {
            const range = selection.getRangeAt(0);
            
            // Constraint: Only within reader-body
            if (!readerBody.contains(range.commonAncestorContainer)) {
                toolkit.classList.add('hidden');
                return;
            }

            const rect = range.getBoundingClientRect();
            toolkit.style.top = `${rect.top - 70}px`;
            toolkit.style.left = `${rect.left + (rect.width / 2) - 100}px`;
            toolkit.classList.remove('hidden');
            
            currentSelection = {
                text: text,
                range: range.cloneRange()
            };
        } else {
            toolkit.classList.add('hidden');
        }
    }

    function applyHighlight(colorClass) {
        if (!currentSelection) return;
        
        try {
            const span = document.createElement('span');
            span.className = colorClass + ' px-1 rounded cursor-pointer selection-highlight';
            span.innerText = currentSelection.text;
            
            currentSelection.range.deleteContents();
            currentSelection.range.insertNode(span);
            
            saveAnnotation({
                type: 'highlight',
                text: currentSelection.text,
                color: colorClass,
                chapter_id: activeChapterId,
                date: new Date().toLocaleDateString()
            });
        } catch(e) { console.error("Highlight Error:", e); }
        
        window.getSelection().removeAllRanges();
        document.getElementById('highlight-toolkit').classList.add('hidden');
        currentSelection = null;
    }

    function showNoteModal() {
        document.getElementById('note-modal').classList.remove('hidden');
        document.getElementById('note-text').focus();
    }

    function closeNoteModal() {
        document.getElementById('note-modal').classList.add('hidden');
        document.getElementById('note-text').value = '';
    }

    function saveNote() {
        const text = document.getElementById('note-text').value.trim();
        if (!text || !currentSelection) return;

        saveAnnotation({
            type: 'note',
            text: currentSelection.text, // Reference text
            note: text,
            color: 'hl-blue', // Default note color
            chapter_id: activeChapterId,
            date: new Date().toLocaleDateString()
        });

        closeNoteModal();
        window.getSelection().removeAllRanges();
        document.getElementById('highlight-toolkit').classList.add('hidden');
    }

    function saveAnnotation(data) {
        annotations.push(data);
        localStorage.setItem('annotations_' + activeChapterId, JSON.stringify(annotations));
        renderAnnotations();
    }

    function renderAnnotations() {
        const persistentList = document.querySelector('.active-annotations-list');
        const drawerList = document.querySelector('.annotations-list-drawer');
        
        const content = generateAnnotationsHtml();
        if (persistentList) persistentList.innerHTML = content;
        if (drawerList) drawerList.innerHTML = content;
    }

    function generateAnnotationsHtml() {
        const chAnnotations = JSON.parse(localStorage.getItem('annotations_' + activeChapterId) || '[]');
        
        if (chAnnotations.length === 0) {
            return `<div class="text-center py-10 opacity-30"><span class="material-symbols-outlined text-4xl mb-2">edit_note</span><p class="text-[10px] font-black uppercase tracking-widest leading-relaxed">No highlights or notes yet</p></div>`;
        }
        
        let html = '';
        chAnnotations.forEach(ann => {
            const colorMap = {
                'hl-gold': 'border-l-[#ffd700]',
                'hl-blue': 'border-l-[#93c5fd]',
                'hl-green': 'border-l-[#86efac]'
            };
            const dotMap = {
                'hl-gold': 'bg-[#ffd700]',
                'hl-blue': 'bg-[#93c5fd]',
                'hl-green': 'bg-[#86efac]'
            };
            
            html += `
                <div class="p-4 bg-white/5 rounded-2xl border border-white/5 border-l-4 ${colorMap[ann.color] || 'border-l-primary'} shadow-xl group transition-all hover:bg-white/10">
                    <div class="flex items-center justify-between mb-2">
                        <span class="flex items-center gap-1.5 text-[9px] font-black uppercase tracking-widest ${ann.type === 'note' ? 'text-primary' : 'text-slate-500'}">
                            ${ann.type === 'note' ? '<span class="material-symbols-outlined text-xs active-icon">chat_bubble</span>' : `<span class="w-2 h-2 rounded-full ${dotMap[ann.color]}"></span>`}
                            ${ann.type}
                        </span>
                        <span class="text-[9px] text-slate-600 font-bold uppercase tracking-widest">${ann.date}</span>
                    </div>
                    ${ann.note ? `<p class="text-[10px] font-black uppercase tracking-widest text-white mb-2">Meditation Insight</p>` : ''}
                    <p class="text-[11px] text-slate-400 font-medium ${ann.note ? 'bg-white/5 p-4 rounded-xl border-l border-white/10 mb-3 italic' : 'italic'}">"${ann.text}"</p>
                    ${ann.note ? `<p class="text-xs text-slate-300 font-semibold leading-relaxed px-1">${ann.note}</p>` : ''}
                </div>
            `;
        });
        return html;
    }

    // --- General Utils ---
    function changeMode(mode) {
        readerContainer.classList.remove('sepia-mode', 'dark-mode-reader');
        if (mode === 'sepia') readerContainer.classList.add('sepia-mode');
        if (mode === 'dark') readerContainer.classList.add('dark-mode-reader');
    }

    function adjustFontSize(delta) {
        currentFontSize += delta;
        currentFontSize = Math.min(Math.max(currentFontSize, 14), 40);
        readerBody.style.fontSize = currentFontSize + 'px';
    }

    function updateProgress(percentage) {
        progressBar.style.width = percentage + "%";
        if (Math.abs(percentage - lastSavedPercentage) > 5 && activeChapterId) {
            saveProgress(percentage);
            lastSavedPercentage = percentage;
        }
    }

    async function saveProgress(percentage) {
        @if(auth()->check())
        try {
            await fetch("{{ route('library.progress.update', $book->id) }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ chapter_id: activeChapterId, percentage: percentage })
            });
        } catch (e) {}
        @endif
    }

    window.onscroll = function() {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        updateProgress(scrolled);
    };

    // Initialize UI
    window.onload = () => {
        updateNavButtons();
        renderAnnotations();
        prepareUtterance();
    };

</script>
@endpush
@endsection
