@extends('layouts.reader')


@section('title', $book->title . ' — Reader')

@push('styles')
<style>
    /* Reader custom styles */
    .active-icon { font-variation-settings: 'FILL' 1; }

    .sepia-mode { background-color: #f4ecd8 !important; color: #5b4636 !important; }
    .sepia-mode article, .sepia-mode #reader-body { color: #5b4636 !important; }

    /* Highlight colors — semi-transparent backgrounds so text stays readable */
    .hl-gold   { background: rgba(251,191,36,0.35);  border-radius: 3px; }
    .hl-blue   { background: rgba(96,165,250,0.35);   border-radius: 3px; }
    .hl-green  { background: rgba(74,222,128,0.35);   border-radius: 3px; }
    .hl-pink   { background: rgba(244,114,182,0.35);  border-radius: 3px; }
    .hl-purple { background: rgba(167,139,250,0.35);  border-radius: 3px; }
    .hl-orange { background: rgba(251,146,60,0.35);   border-radius: 3px; }

    .dark .hl-gold   { background: rgba(251,191,36,0.20);  border-bottom: 2px solid rgba(251,191,36,0.5); }
    .dark .hl-blue   { background: rgba(96,165,250,0.20);  border-bottom: 2px solid rgba(96,165,250,0.5); }
    .dark .hl-green  { background: rgba(74,222,128,0.20);  border-bottom: 2px solid rgba(74,222,128,0.5); }
    .dark .hl-pink   { background: rgba(244,114,182,0.20); border-bottom: 2px solid rgba(244,114,182,0.5); }
    .dark .hl-purple { background: rgba(167,139,250,0.20); border-bottom: 2px solid rgba(167,139,250,0.5); }
    .dark .hl-orange { background: rgba(251,146,60,0.20);  border-bottom: 2px solid rgba(251,146,60,0.5); }

    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; }

    .sidebar-closed { 
        display: none !important;
        transform: translateX(-100%); 
        opacity: 0;
    }
    #annotation-sidebar.sidebar-closed {
        transform: translateX(100%);
    }

    @media (max-width: 1024px) {
        .lg\:static { position: fixed !important; }
        #chapter-sidebar:not(.sidebar-closed) {
            transform: translateX(0);
            opacity: 1;
            display: flex !important;
        }
        #annotation-sidebar:not(.sidebar-closed) {
            transform: translateX(0);
            opacity: 1;
            display: flex !important;
        }
    }

    .sidebar-backdrop {
        background-color: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(2px);
        transition: opacity 0.3s ease;
    }

    body.reader-page { overflow: hidden; height: 100vh; height: 100dvh; }
    #reader-layout { height: calc(100vh - 6px); height: calc(100dvh - 6px); }

    /* Fix footer on mobile */
    @media (max-width: 768px) {
        footer .max-w-7xl { gap: 0.5rem; flex-wrap: wrap; justify-content: center; }
        footer .w-1\/4 { width: auto; }
        footer .flex-1 { width: 100%; order: -1; margin-bottom: 0.5rem; }
        #main-play-btn { width: 44px; height: 44px; }
        #main-play-icon { font-size: 28px; }
        .speed-btn, .pitch-btn { padding: 4px 6px; font-size: 10px; }
        .voice-controls-mobile { display: flex !important; }
    }

    #reader-body {
        -webkit-user-select: text !important;
        user-select: text !important;
        -webkit-touch-callout: default !important;
    }

    .voice-active ::selection {
        background-color: rgba(251,191,36,0.5) !important; 
        color: inherit !important;
    }
</style>
@endpush


@section('content')
<div class="flex flex-col overflow-hidden h-screen" style="height: 100vh; height: 100dvh;">


{{-- Reading Progress Bar --}}
<div class="w-full bg-slate-200 dark:bg-slate-800 h-1.5 sticky top-0 z-50">
    <div id="reading-progress" class="bg-primary h-full transition-all duration-500" style="width: 0%;"></div>
</div>

<div class="flex flex-1 overflow-hidden">

    {{-- LEFT SIDEBAR: Chapter List --}}
    {{-- Mobile: fixed overlay from left. Desktop: static flex sidebar. --}}
    <aside id="chapter-sidebar"
        class="sidebar-closed fixed inset-y-0 left-0 z-[60] w-72 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col h-full shrink-0 transition-all duration-300 lg:static lg:z-auto shadow-2xl lg:shadow-none">

        {{-- Header + Close --}}
        <div class="p-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2 text-primary mb-0.5">
                    <span class="material-symbols-outlined text-lg">auto_stories</span>
                    <span class="text-[10px] font-black uppercase tracking-wider">Church Library</span>
                </div>
                <h2 class="text-base font-bold dark:text-white leading-tight">{{ Str::limit($book->title, 28) }}</h2>
                <p class="text-[11px] text-slate-400 mt-0.5">{{ $book->chapters->count() }} chapters</p>
            </div>
            <button onclick="toggleChapterSidebar()" class="ml-2 w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="Close sidebar">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto p-4 space-y-1 custom-scrollbar">
            @foreach($book->chapters as $i => $chap)
            <div class="chapter-group">
                <button onclick="switchChapter({{ $chap->id }}, '{{ addslashes($chap->title) }}', {{ $i }})"
                    class="chapter-nav-item w-full text-left flex items-center justify-between px-3 py-3 rounded-lg transition-colors {{ $i === 0 ? 'bg-primary/10 text-primary border border-primary/20' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}"
                    data-id="{{ $chap->id }}" data-index="{{ $i }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-lg {{ $i === 0 ? 'active-icon' : '' }}">{{ $i === 0 ? 'menu_book' : 'radio_button_unchecked' }}</span>
                        <span class="text-sm {{ $i === 0 ? 'font-bold' : 'font-medium' }} leading-none">{{ $chap->title }}</span>
                    </div>
                    @if($isOwner)
                    <span class="material-symbols-outlined text-sm text-emerald-500 hidden completed-badge-{{ $chap->id }}">check_circle</span>
                    @endif
                </button>
                
                {{-- Subsection: Pages --}}
                <div id="pages-{{ $chap->id }}" class="pages-list pl-10 pr-4 py-1 space-y-1 {{ $i === 0 ? '' : 'hidden' }}">
                    @php $pagesCount = $chap->page_count; @endphp
                    @for($p = 1; $p <= $pagesCount; $p++)
                    <button onclick="scrollToPage({{ $chap->id }}, {{ $p }})" 
                            class="w-full text-left py-1.5 text-[11px] font-bold text-slate-400 hover:text-primary transition-colors flex items-center justify-between group page-item-{{ $chap->id }}-{{ $p }}">
                        <span>Page {{ $p }}</span>
                        <span class="material-symbols-outlined text-xs text-emerald-500 opacity-0 page-checkmark-{{ $chap->id }}-{{ $p }}">check_circle</span>
                    </button>
                    @endfor
                </div>
            </div>
            @endforeach



            @if(!$isOwner)
            {{-- Locked chapters visual & Unlock CTA --}}
            <div class="px-3 py-4 mt-2 mb-4 bg-primary/5 border border-primary/20 rounded-xl mx-2">
                <p class="text-[10px] font-black text-primary uppercase tracking-widest mb-3">Locked Content</p>
                <button onclick="addToCollection(event, {{ $book->id }})" class="add-btn-{{ $book->id }} w-full py-2.5 bg-primary text-white text-[11px] font-black rounded-lg hover:scale-105 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">bookmark_add</span>
                    {{ $book->is_free ? 'Add to Collection' : 'Purchase Full Book' }}
                </button>
            </div>

            @for($l = 1; $l <= 3; $l++)
            <div class="flex items-center gap-3 px-3 py-3 rounded-lg text-slate-400 opacity-30">
                <span class="material-symbols-outlined text-lg">lock</span>
                <span class="text-xs font-bold uppercase tracking-widest">Chapter Locked</span>
            </div>
            @endfor
            @endif
        </nav>
        <div class="p-4 mt-auto">
            <button onclick="showReaderSettings()" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-800 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800">
                <span class="material-symbols-outlined text-lg">settings</span>
                Reader Settings
            </button>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main id="main-scroll-area" class="flex-1 overflow-y-auto bg-white dark:bg-background-dark relative custom-scrollbar transition-colors duration-300">
        
        {{-- Sidebar Backdrop (Mobile only) --}}
        <div id="sidebar-backdrop" onclick="closeAllSidebars()" class="fixed inset-0 z-[55] sidebar-backdrop hidden opacity-0"></div>

        {{-- Floating Toolbar (top-right) --}}
        <div class="sticky top-4 lg:top-6 right-0 lg:right-6 z-40 flex justify-end px-4 lg:px-8">
            <div class="bg-white dark:bg-slate-800 shadow-xl border border-slate-200 dark:border-slate-700 rounded-xl p-1 flex items-center gap-1">
                <button onclick="toggleChapterSidebar()" class="p-2 rounded-lg bg-slate-100 dark:bg-slate-900 text-slate-900 dark:text-white hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors" title="Toggle Sidebar">
                    <span class="material-symbols-outlined">menu_open</span>
                </button>
                <div class="w-px h-6 bg-slate-200 dark:bg-slate-700 mx-1"></div>
                <button onclick="changeMode('light')" class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-900 transition-colors" title="Light Mode">
                    <span class="material-symbols-outlined">light_mode</span>
                </button>
                <button onclick="changeMode('sepia')" class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-900 transition-colors" title="Sepia Mode">
                    <span class="material-symbols-outlined text-amber-700">texture</span>
                </button>
                <button onclick="changeMode('dark')" class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-900 transition-colors" title="Dark Mode">
                    <span class="material-symbols-outlined">dark_mode</span>
                </button>
                <div class="w-px h-6 bg-slate-200 dark:bg-slate-700 mx-1"></div>
                {{-- Font Size --}}
                <div class="relative" id="font-dropdown-wrap">
                    <button onclick="toggleFontDropdown()" class="flex items-center gap-1 px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-900 transition-colors">
                        <span class="text-xs font-bold">Aa</span>
                        <span class="material-symbols-outlined text-lg">expand_more</span>
                    </button>
                    <div id="font-dropdown" class="absolute right-0 mt-2 w-36 bg-white dark:bg-slate-800 rounded-xl shadow-2xl border border-slate-100 dark:border-slate-700 p-2 z-[70] hidden">
                        <button onclick="adjustFontSize(2)" class="w-full flex items-center justify-between p-2.5 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 text-[11px] font-bold uppercase tracking-widest text-slate-600 dark:text-slate-300">
                            <span>Enlarge A</span>
                            <span class="material-symbols-outlined text-base">add</span>
                        </button>
                        <button onclick="adjustFontSize(-2)" class="w-full flex items-center justify-between p-2.5 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 text-[11px] font-bold uppercase tracking-widest text-slate-600 dark:text-slate-300">
                            <span>Reduce A</span>
                            <span class="material-symbols-outlined text-base">remove</span>
                        </button>
                    </div>
                </div>
                <div class="w-px h-6 bg-slate-200 dark:bg-slate-700 mx-1"></div>
                @if($isOwner)
                <button onclick="toggleAnnotationsSidebar()" class="p-2 rounded-lg bg-primary text-white hover:bg-primary/90 transition-colors" title="View Notes">
                    <span class="material-symbols-outlined active-icon">edit_note</span>
                </button>
                @endif
            </div>
        </div>

        {{-- Highlight Toolkit (shown on text selection) --}}
        @if($isOwner)
        <div id="highlight-toolkit" class="fixed z-[70]" style="display:none;">
            <div class="flex flex-col bg-slate-900 text-white rounded-xl shadow-2xl overflow-hidden" style="width:240px">
                {{-- Row 1: Colors + Close --}}
                <div class="flex items-center justify-between p-2 border-b border-slate-800">
                    <div class="flex items-center gap-1.5">
                        <button onclick="applyHighlight('hl-gold')"   title="Gold"   class="w-5 h-5 rounded-full bg-yellow-400  hover:scale-125 transition-transform"></button>
                        <button onclick="applyHighlight('hl-blue')"   title="Blue"   class="w-5 h-5 rounded-full bg-blue-400    hover:scale-125 transition-transform"></button>
                        <button onclick="applyHighlight('hl-green')"  title="Green"  class="w-5 h-5 rounded-full bg-green-400   hover:scale-125 transition-transform"></button>
                        <button onclick="applyHighlight('hl-pink')"   title="Pink"   class="w-5 h-5 rounded-full bg-pink-400    hover:scale-125 transition-transform"></button>
                        <button onclick="applyHighlight('hl-purple')" title="Purple" class="w-5 h-5 rounded-full bg-purple-400  hover:scale-125 transition-transform"></button>
                        <button onclick="applyHighlight('hl-orange')" title="Orange" class="w-5 h-5 rounded-full bg-orange-400  hover:scale-125 transition-transform"></button>
                    </div>
                    <button onclick="closeToolkit()" class="ml-2 text-slate-400 hover:text-white transition-colors" title="Close">
                        <span class="material-symbols-outlined text-base leading-none">close</span>
                    </button>
                </div>
                {{-- Row 2: Actions --}}
                <div class="flex border-b border-slate-800">
                    <button onclick="showNoteModal()" class="flex-1 flex items-center justify-center gap-1 px-2 py-2 text-[11px] font-semibold hover:bg-slate-800 transition-colors" title="Add Note">
                        <span class="material-symbols-outlined text-sm">add_comment</span>
                        Note
                    </button>
                    <div class="w-px bg-slate-800"></div>
                    <button onclick="pronounceSelection()" class="flex-1 flex items-center justify-center gap-1 px-2 py-2 text-[11px] font-semibold hover:bg-slate-800 transition-colors" title="Pronounce">
                        <span class="material-symbols-outlined text-sm">volume_up</span>
                        Pronounce
                    </button>
                    <div class="w-px bg-slate-800"></div>
                    <button onclick="lookupDictionary()" class="flex-1 flex items-center justify-center gap-1 px-2 py-2 text-[11px] font-semibold hover:bg-slate-800 transition-colors" title="Dictionary">
                        <span class="material-symbols-outlined text-sm">menu_book</span>
                        Define
                    </button>
                </div>
                {{-- Row 3: Dictionary result panel (hidden by default) --}}
                <div id="dict-panel" class="hidden p-3 border-t border-slate-800 text-left max-h-36 overflow-y-auto custom-scrollbar">
                    <div id="dict-loading" class="text-xs text-slate-400 text-center animate-pulse">Looking up...</div>
                    <div id="dict-result" class="hidden">
                        <p id="dict-word" class="text-xs font-black text-primary mb-0.5"></p>
                        <p id="dict-part" class="text-[10px] italic text-slate-400 mb-1"></p>
                        <p id="dict-def" class="text-[11px] text-slate-300 leading-relaxed"></p>
                        <p id="dict-example" class="text-[10px] italic text-slate-500 mt-1"></p>
                    </div>
                    <div id="dict-error" class="hidden text-[11px] text-slate-400 text-center">No definition found.</div>
                </div>
            </div>
            {{-- Caret --}}
            <div class="absolute -bottom-1.5 left-1/2 -translate-x-1/2 w-3 h-3 bg-slate-900 rotate-45"></div>
        </div>
        @endif

        {{-- Article Content --}}
        <article class="max-w-[800px] mx-auto px-6 lg:px-12 py-8 lg:py-12 pb-48">
            <header class="mb-12">
                <nav class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-sm mb-4">
                    <a href="{{ route('library.index') }}">Library</a>
                    <span class="material-symbols-outlined text-xs">chevron_right</span>
                    <span>{{ $book->title }}</span>
                </nav>
                <h1 id="chapter-title" class="font-serif text-3xl lg:text-5xl font-bold dark:text-white mb-4 leading-tight">{{ $book->chapters->first()->title ?? 'Introduction' }}</h1>
                <div class="flex items-center gap-4 py-2 border-y border-slate-100 dark:border-slate-800">
                    <span id="read-time-display" class="text-xs font-medium uppercase tracking-widest text-primary">Read Time: — mins</span>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <span id="audio-time-display" class="text-xs font-medium uppercase tracking-widest text-slate-500">Audio: — mins</span>
                </div>
            </header>

            <div id="reader-body" class="font-serif text-xl leading-relaxed text-slate-800 dark:text-slate-300 space-y-8" style="font-size: 20px;">
                {!! $book->chapters->first()->content ?? $book->content !!}
            </div>

            {{-- Chapter Navigation --}}
            <div class="mt-16 pt-8 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <button id="prev-btn" onclick="navigateChapter(-1)" disabled class="flex items-center gap-3 px-6 py-3 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-500 hover:text-primary hover:border-primary transition-all disabled:opacity-30 disabled:pointer-events-none">
                    <span class="material-symbols-outlined">west</span>
                    <span class="text-sm font-bold">Previous</span>
                </button>
                <button id="next-btn" onclick="navigateChapter(1)" class="flex items-center gap-3 px-6 py-3 rounded-xl bg-primary text-white font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 disabled:opacity-30 disabled:pointer-events-none">
                    <span class="nav-label text-sm">Next Chapter</span>
                    <span class="material-symbols-outlined">east</span>
                </button>
            </div>

            @if($isOwner)
            {{-- Finish Book CTA - Only shown on last page --}}
            <div id="finish-book-container" class="mt-20 flex justify-center hidden">
                <div class="max-w-md w-full bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-800/50 rounded-3xl p-8 text-center animate-fade-in-up">
                    <div class="w-16 h-16 bg-emerald-500 text-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-500/30">
                        <span class="material-symbols-outlined text-3xl">auto_stories</span>
                    </div>
                    <h3 class="text-xl font-black dark:text-white mb-2 uppercase tracking-tight">You've reached the end!</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mb-6">Congratulations on completing all chapters of this book. Mark it as finished to update your spiritual progress.</p>
                    <button id="finish-book-btn" onclick="markBookCompleted()" class="w-full py-4 flex items-center justify-center gap-3 rounded-2xl bg-emerald-500 text-white font-black uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-xl shadow-emerald-500/20">
                        <span class="material-symbols-outlined">task_alt</span>
                        <span id="finish-book-label">Mark as Finished</span>
                    </button>
                </div>
            </div>
            @endif
        </article>
    </main>

    {{-- RIGHT SIDEBAR: Annotations --}}
    @if($isOwner)
    <aside id="annotation-sidebar"
        class="sidebar-closed fixed inset-y-0 right-0 z-[60] w-80 bg-white dark:bg-slate-900 border-l border-slate-200 dark:border-slate-800 flex flex-col h-full shrink-0 transition-all duration-300 lg:static lg:z-auto shadow-2xl lg:shadow-none">

        {{-- Header + Close --}}
        <div class="p-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">history_edu</span>
                <h2 class="text-base font-bold dark:text-white">My Annotations</h2>
            </div>
            <div class="flex items-center gap-2">
                <span id="annotation-chapter-badge" class="bg-primary/10 text-primary text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Chapter 1</span>
                <button onclick="toggleAnnotationsSidebar()" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="Close">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
        </div>
        <div id="annotations-list" class="flex-1 overflow-y-auto p-4 space-y-4 custom-scrollbar">
            <div id="annotations-empty" class="text-center py-10 opacity-30">
                <span class="material-symbols-outlined text-4xl mb-2 block">edit_note</span>
                <p class="text-[10px] font-bold uppercase tracking-widest">No notes yet.<br>Select text to annotate.</p>
            </div>
        </div>
        <div class="p-4 bg-slate-50 dark:bg-slate-800/50 mt-auto border-t border-slate-200 dark:border-slate-800 space-y-2">
            <button onclick="exportAnnotations()" class="w-full py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg text-xs font-bold flex items-center justify-center gap-2 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                <span class="material-symbols-outlined text-sm">download</span>
                Export My Notes
            </button>
        </div>
    </aside>
    @endif

    @if(!$isOwner)
    <div id="lock-overlay" class="absolute inset-0 flex items-center justify-center bg-white/80 dark:bg-slate-900/80 backdrop-blur-[6px] z-[60] hidden">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-[0_20px_60px_rgba(0,0,0,0.15)] max-w-lg w-full overflow-hidden border border-slate-200 dark:border-slate-700 flex flex-col animate-fade-in-up">
            <!-- Top Decorative Bar -->
            <div class="h-1.5 bg-gradient-to-r from-primary to-primary/40 w-full"></div>
            
            <div class="p-8 flex flex-col items-center text-center">
                <!-- Book Thumbnail -->
                <div class="relative mb-6 group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-lg blur opacity-30 group-hover:opacity-50 transition duration-200"></div>
                    <div class="relative w-24 h-32 rounded-md shadow-lg overflow-hidden border border-slate-200 dark:border-slate-700">
                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -top-3 -right-3 bg-yellow-500 text-slate-900 p-1.5 rounded-full shadow-lg z-10 flex items-center justify-center border-2 border-white dark:border-slate-800">
                        <span class="material-symbols-outlined text-[18px] font-bold">lock</span>
                    </div>
                </div>

                <!-- Headlines -->
                <h3 class="text-2xl font-black dark:text-white mb-2 uppercase tracking-tight">Unlock Full Access</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mb-8 max-w-xs">
                    {{ $book->is_free ? 'Add this book to your collection to continue reading all chapters for free.' : 'Purchase this book to unlock all chapters and premium features.' }}
                </p>

                <!-- CTA Button -->
                <button onclick="addToCollection(event, {{ $book->id }})" class="add-btn-{{ $book->id }} w-full bg-primary text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-primary/20 transform transition hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-3">
                    <span class="material-symbols-outlined text-2xl">bookmark_add</span>
                    <span>{{ $book->is_free ? 'Add to Collection' : 'Purchase Full Book - $' . number_format($book->price, 2) }}</span>
                </button>

                <!-- Features List -->
                <div class="w-full bg-slate-50 dark:bg-slate-900/40 rounded-xl p-5 border border-slate-100 dark:border-slate-700/50 mt-6">
                    <ul class="space-y-3 text-left">
                        <li class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center mt-0.5">
                                <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-[14px] font-bold">check</span>
                            </div>
                            <span class="text-xs font-bold text-slate-600 dark:text-slate-300 uppercase">Unlock all {{ $book->chapters->count() }} Chapters</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center mt-0.5">
                                <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-[14px] font-bold">check</span>
                            </div>
                            <span class="text-xs font-bold text-slate-600 dark:text-slate-300 uppercase">Full Voice Assistant Access</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center mt-0.5">
                                <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-[14px] font-bold">check</span>
                            </div>
                            <span class="text-xs font-bold text-slate-600 dark:text-slate-300 uppercase">Personal Annotations & Notes</span>
                        </li>
                    </ul>
                </div>
                
                <p class="mt-6 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Secure session • One-time access</p>
            </div>
        </div>
    </div>
    @endif
</div>{{-- end flex workspace --}}

{{-- FOOTER: Voice Reader Bar --}}
<footer class="bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 p-4 z-50 shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.1)]">
    @if(!$isOwner)
    <div id="footer-lock-overlay" class="absolute inset-0 flex items-center justify-center bg-white/60 dark:bg-slate-900/60 backdrop-blur-[2px] z-10 hidden">
        <div class="flex items-center gap-6 px-8 py-4 bg-white dark:bg-slate-800 shadow-2xl rounded-2xl border border-slate-100 dark:border-slate-700">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary text-2xl">lock</span>
                <p class="text-xs font-black uppercase tracking-widest">Voice Assistant Locked</p>
            </div>
            <div class="w-px h-6 bg-slate-200 dark:bg-slate-700"></div>
            <button onclick="addToCollection(event, {{ $book->id }})" class="add-btn-{{ $book->id }} flex items-center gap-2 px-6 py-2.5 bg-primary text-white rounded-xl font-bold hover:scale-105 transition-all shadow-lg shadow-primary/20 pointer-events-auto">
                <span class="material-symbols-outlined text-xl">bookmark_add</span>
                {{ $book->is_free ? 'Add to Access' : 'Purchase Book' }}
            </button>
        </div>
    </div>
    @endif

    <div class="max-w-7xl mx-auto flex items-center justify-between gap-8">
        {{-- Left: Track Info --}}
        <div class="flex items-center gap-4 w-1/4">
            <div class="w-12 h-12 rounded-lg bg-primary/20 flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-3xl">graphic_eq</span>
            </div>
            <div class="hidden lg:block min-w-0">
                <p id="player-chapter-title" class="text-sm font-bold dark:text-white truncate">{{ $book->chapters->first()->title ?? 'Introduction' }}</p>
                <p id="player-chapter-index" class="text-xs text-slate-500 dark:text-slate-400">Section 1 of {{ $book->chapters->count() }}</p>
            </div>
        </div>

        {{-- Center: Controls --}}
        <div class="flex flex-col items-center gap-2 flex-1">
            <div class="flex items-center gap-6">
                <button onclick="seekVoice(-5)" class="text-slate-400 hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-2xl">replay_5</span>
                </button>
                <button id="main-play-btn" onclick="toggleVoice()" class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center hover:scale-105 active:scale-95 transition-all shadow-lg shadow-primary/30">
                    <span class="material-symbols-outlined text-3xl active-icon" id="main-play-icon">play_arrow</span>
                </button>
                <button onclick="seekVoice(5)" class="text-slate-400 hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-2xl">forward_5</span>
                </button>
            </div>
            <div class="w-full max-w-md bg-slate-200 dark:bg-slate-800 h-1 rounded-full overflow-hidden cursor-pointer" onclick="handleSeek(event)">
                <div id="voice-progress" class="bg-primary h-full" style="width: 0%;"></div>
            </div>
        </div>

        {{-- Right: Settings & Listen --}}
        <div class="flex items-center justify-end gap-3 w-auto md:w-1/4">
            
            {{-- Desktop Controls --}}
            <div class="hidden xl:flex items-center gap-4">
                {{-- Volume --}}
                <div class="flex flex-col items-center gap-0.5">
                    <p class="text-[9px] uppercase font-bold text-slate-400">Volume</p>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm text-slate-400">volume_down</span>
                        <input type="range" min="0" max="1" step="0.1" value="1" oninput="setVolume(this.value)" class="w-16 h-1 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-primary">
                        <span class="material-symbols-outlined text-sm text-slate-400">volume_up</span>
                    </div>
                </div>
                {{-- Read Speed --}}
                <div class="flex flex-col items-center gap-0.5">
                    <p class="text-[9px] uppercase font-bold text-slate-400">Speed</p>
                    <div class="flex items-center bg-slate-100 dark:bg-slate-800 rounded-lg p-0.5">
                        <button id="speed-0-5" onclick="setSpeed(0.5)" class="speed-btn px-2 py-1 text-[11px] font-bold rounded text-slate-400 hover:text-primary transition-colors">0.5x</button>
                        <button id="speed-1"   onclick="setSpeed(1)"   class="speed-btn px-2 py-1 text-[11px] font-bold rounded bg-white dark:bg-slate-700 text-primary shadow-sm transition-colors">1x</button>
                        <button id="speed-1-5" onclick="setSpeed(1.5)" class="speed-btn px-2 py-1 text-[11px] font-bold rounded text-slate-400 hover:text-primary transition-colors">1.5x</button>
                    </div>
                </div>
                {{-- Pitch --}}
                <div class="flex flex-col items-center gap-0.5">
                    <p class="text-[9px] uppercase font-bold text-slate-400">Pitch</p>
                    <div class="flex items-center bg-slate-100 dark:bg-slate-800 rounded-lg p-0.5">
                        <button id="pitch-0-5" onclick="setPitch(0.5)" class="pitch-btn px-2 py-1 text-[11px] font-bold rounded text-slate-400 hover:text-primary transition-colors" title="Low">▼</button>
                        <button id="pitch-1"   onclick="setPitch(1)"   class="pitch-btn px-2 py-1 text-[11px] font-bold rounded bg-white dark:bg-slate-700 text-primary shadow-sm transition-colors" title="Normal">●</button>
                        <button id="pitch-1-5" onclick="setPitch(1.5)" class="pitch-btn px-2 py-1 text-[11px] font-bold rounded text-slate-400 hover:text-primary transition-colors" title="High">▲</button>
                    </div>
                </div>
            </div>

            {{-- Mobile Settings Dropdown --}}
            <div class="relative group block xl:hidden">
                <button type="button" class="flex items-center justify-center w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-primary transition-colors focus:outline-none focus:ring-2 focus:ring-primary/30">
                    <span class="material-symbols-outlined text-xl">settings</span>
                </button>
                <div class="absolute bottom-full right-0 mb-3 w-64 bg-white dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700 rounded-xl shadow-[0_10px_40px_rgba(0,0,0,0.2)] p-4 opacity-0 invisible group-hover:opacity-100 group-hover:visible focus-within:opacity-100 focus-within:visible transition-all origin-bottom-right scale-95 group-hover:scale-100 z-[100]">
                    <div class="flex flex-col gap-4">
                        {{-- Dropdown Volume --}}
                        <div class="flex flex-col gap-1.5">
                            <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400">Volume</p>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px] text-slate-400">volume_down</span>
                                <input type="range" min="0" max="1" step="0.1" value="1" oninput="setVolume(this.value)" class="flex-1 h-1.5 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-primary">
                                <span class="material-symbols-outlined text-[16px] text-slate-400">volume_up</span>
                            </div>
                        </div>
                        {{-- Dropdown Speed --}}
                        <div class="flex flex-col gap-1.5">
                            <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400">Read Speed</p>
                            <div class="grid grid-cols-3 gap-1 bg-slate-100 dark:bg-slate-700 rounded-lg p-1">
                                <button onclick="setSpeed(0.5); document.querySelectorAll('.mobile-speed-btn').forEach(b => {b.classList.remove('bg-white','dark:bg-slate-600','text-primary','shadow'); b.classList.add('text-slate-400')}); this.classList.remove('text-slate-400'); this.classList.add('bg-white','dark:bg-slate-600','text-primary','shadow');" class="mobile-speed-btn px-2 py-1.5 text-xs font-bold rounded text-slate-400 hover:text-primary transition-all">0.5x</button>
                                <button onclick="setSpeed(1); document.querySelectorAll('.mobile-speed-btn').forEach(b => {b.classList.remove('bg-white','dark:bg-slate-600','text-primary','shadow'); b.classList.add('text-slate-400')}); this.classList.remove('text-slate-400'); this.classList.add('bg-white','dark:bg-slate-600','text-primary','shadow');" class="mobile-speed-btn px-2 py-1.5 text-xs font-bold rounded bg-white dark:bg-slate-600 text-primary shadow transition-all">1x</button>
                                <button onclick="setSpeed(1.5); document.querySelectorAll('.mobile-speed-btn').forEach(b => {b.classList.remove('bg-white','dark:bg-slate-600','text-primary','shadow'); b.classList.add('text-slate-400')}); this.classList.remove('text-slate-400'); this.classList.add('bg-white','dark:bg-slate-600','text-primary','shadow');" class="mobile-speed-btn px-2 py-1.5 text-xs font-bold rounded text-slate-400 hover:text-primary transition-all">1.5x</button>
                            </div>
                        </div>
                        {{-- Dropdown Pitch --}}
                        <div class="flex flex-col gap-1.5">
                            <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400">Voice Pitch</p>
                            <div class="grid grid-cols-3 gap-1 bg-slate-100 dark:bg-slate-700 rounded-lg p-1">
                                <button onclick="setPitch(0.5); document.querySelectorAll('.mobile-pitch-btn').forEach(b => {b.classList.remove('bg-white','dark:bg-slate-600','text-primary','shadow'); b.classList.add('text-slate-400')}); this.classList.remove('text-slate-400'); this.classList.add('bg-white','dark:bg-slate-600','text-primary','shadow');" class="mobile-pitch-btn px-2 py-1.5 text-xs font-bold rounded text-slate-400 hover:text-primary transition-all" title="Low">▼</button>
                                <button onclick="setPitch(1); document.querySelectorAll('.mobile-pitch-btn').forEach(b => {b.classList.remove('bg-white','dark:bg-slate-600','text-primary','shadow'); b.classList.add('text-slate-400')}); this.classList.remove('text-slate-400'); this.classList.add('bg-white','dark:bg-slate-600','text-primary','shadow');" class="mobile-pitch-btn px-2 py-1.5 text-xs font-bold rounded bg-white dark:bg-slate-600 text-primary shadow transition-all" title="Normal">●</button>
                                <button onclick="setPitch(1.5); document.querySelectorAll('.mobile-pitch-btn').forEach(b => {b.classList.remove('bg-white','dark:bg-slate-600','text-primary','shadow'); b.classList.add('text-slate-400')}); this.classList.remove('text-slate-400'); this.classList.add('bg-white','dark:bg-slate-600','text-primary','shadow');" class="mobile-pitch-btn px-2 py-1.5 text-xs font-bold rounded text-slate-400 hover:text-primary transition-all" title="High">▲</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button onclick="toggleVoice()" class="flex h-10 w-10 md:h-auto md:w-auto items-center justify-center md:px-4 md:py-2.5 bg-primary text-white rounded-xl font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/20 text-sm">
                <span class="material-symbols-outlined text-lg">record_voice_over</span>
                <span class="hidden md:inline ml-2">Listen</span>
            </button>
        </div>
    </div>
</footer>

{{-- Note Modal --}}
@if($isOwner)
<div id="note-modal" class="fixed inset-0 z-[80] hidden" style="display:none;">
    <div class="absolute inset-0 flex items-center justify-center p-6">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeNoteModal()"></div>
        <div class="relative z-10 w-full max-w-lg bg-white dark:bg-slate-900 rounded-2xl shadow-2xl p-8">
            <button onclick="closeNoteModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                <span class="material-symbols-outlined">close</span>
            </button>
            <h3 class="text-sm font-bold uppercase tracking-widest text-slate-400 mb-2">Add Personal Note</h3>
            <p id="note-selection-preview" class="text-xs italic text-primary mb-4 line-clamp-2"></p>
            <textarea id="note-text" rows="4" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-4 text-sm focus:ring-2 focus:ring-primary/30 outline-none resize-none" placeholder="What truth are you reflecting on?"></textarea>
            <div class="mt-6 flex items-center justify-end gap-4">
                <button onclick="closeNoteModal()" class="text-sm font-bold text-slate-400 hover:text-slate-600">Cancel</button>
                <button onclick="saveNote()" class="px-8 py-3 bg-primary text-white text-sm font-bold rounded-xl hover:scale-105 transition-all shadow-lg shadow-primary/20">Save Note</button>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Mobile Sidebar Overlay --}}
<div id="mobile-sidebar-overlay" class="lg:hidden fixed inset-0 bg-slate-900/60 z-[52] hidden" onclick="closeMobileSidebar()"></div>
<div id="mobile-sidebar" class="lg:hidden fixed inset-y-0 left-0 w-72 bg-white dark:bg-slate-900 z-[55] transform -translate-x-full transition-transform duration-300 shadow-2xl">
    <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center">
        <h3 class="font-bold text-sm uppercase tracking-widest text-slate-400">Chapters</h3>
        <button onclick="closeMobileSidebar()"><span class="material-symbols-outlined">close</span></button>
    </div>
    <nav class="p-4 space-y-1 overflow-y-auto custom-scrollbar">
        @foreach($book->chapters as $i => $chap)
        <button onclick="switchChapter({{ $chap->id }}, '{{ addslashes($chap->title) }}', {{ $i }}); closeMobileSidebar();"
            class="chapter-nav-item w-full text-left flex items-center gap-3 px-3 py-3 rounded-lg transition-colors text-slate-600 dark:text-slate-400 hover:bg-slate-100"
            data-id="{{ $chap->id }}" data-index="{{ $i }}">
            <span class="material-symbols-outlined text-lg">radio_button_unchecked</span>
            <span class="text-sm font-medium leading-none">{{ $chap->title }}</span>
        </button>
        @endforeach
    </nav>
</div>
</div>
{{-- /end reader wrapper --}}
@endsection

@push('scripts')

<script>
// =====================
// CORE STATE
// =====================
const readerBody = document.getElementById('reader-body');
const readingProgress = document.getElementById('reading-progress');
const isOwner = {{ $isOwner ? 'true' : 'false' }};

let currentFontSize = 20;
let activeChapterId = {{ $book->chapters->first()->id ?? 'null' }};
let activeChapterIndex = 0;
let totalChapters = {{ $book->chapters->count() }};

// Voice
let synth = window.speechSynthesis;
let utterance = null;
let isSpeaking = false;
let isPaused = false;
let currentRate = 1;
let currentPitch = 1;
let currentVolume = 1;
let wordIndex = 0;
let progressInterval = null;

// Page progress tracking
const chapterPageCount = {{ $book->chapters->first()->page_count ?? 1 }};
const readPages = JSON.parse(localStorage.getItem('read_pages_{{ $book->id }}') || '{}');

// Track which chapters the user has visited
const readChapters = JSON.parse(localStorage.getItem('read_chapters_{{ $book->id }}') || '{}');

function markChapterRead(chapterId) {
    readChapters[chapterId] = true;
    localStorage.setItem('read_chapters_{{ $book->id }}', JSON.stringify(readChapters));
    // Show completed badge
    const badge = document.querySelector(`.completed-badge-${chapterId}`);
    if (badge) badge.classList.remove('hidden');
}

function markPageRead(chapterId, pageNum) {
    if (!readPages[chapterId]) readPages[chapterId] = [];
    if (!readPages[chapterId].includes(pageNum)) {
        readPages[chapterId].push(pageNum);
        localStorage.setItem('read_pages_{{ $book->id }}', JSON.stringify(readPages));
        // Update UI
        const check = document.querySelector(`.page-checkmark-${chapterId}-${pageNum}`);
        if (check) check.classList.remove('opacity-0');
    }
}

function scrollToPage(chapterId, pageNum) {
    if (activeChapterId !== chapterId) {
        // Need to switch chapter first then scroll
        // For now just scroll if active
        return;
    }
    const scrollArea = document.getElementById('main-scroll-area');
    if (!scrollArea) return;
    const totalHeight = scrollArea.scrollHeight - scrollArea.clientHeight;
    const chapPageCount = document.querySelectorAll(`#pages-${chapterId} button`).length;
    const targetScroll = (totalHeight / chapPageCount) * (pageNum - 1);
    scrollArea.scrollTo({ top: targetScroll, behavior: 'smooth' });
}

// =====================
// DYNAMIC READ / AUDIO TIME
// =====================
function updateReadTime() {
    const text = readerBody?.innerText || '';
    const words = text.trim().split(/\s+/).filter(w => w.length > 0).length;
    const readMins  = Math.max(1, Math.round(words / 200));  // avg adult: 200 wpm
    const audioMins = Math.max(1, Math.round(words / 130));  // avg TTS speech: 130 wpm
    const rt = document.getElementById('read-time-display');
    const at = document.getElementById('audio-time-display');
    if (rt) rt.textContent = `Read Time: ${readMins} min${readMins !== 1 ? 's' : ''}`;
    if (at) at.textContent = `Audio: ${audioMins} min${audioMins !== 1 ? 's' : ''}`;
}

// =====================
// PRONOUNCE SELECTION
// =====================
function pronounceSelection() {
    if (!currentSelection?.text) return;
    const u = new SpeechSynthesisUtterance(currentSelection.text);
    u.rate  = 0.9;
    u.pitch = 1.0;
    window.speechSynthesis.cancel();
    window.speechSynthesis.speak(u);
}

// =====================
// DICTIONARY LOOKUP
// =====================
async function lookupDictionary() {
    if (!currentSelection?.text) return;
    // Only look up the first word of the selection for dictionary
    const query = currentSelection.text.trim().split(/\s+/)[0].replace(/[^a-zA-Z'-]/g, '');
    if (!query) return;

    const panel   = document.getElementById('dict-panel');
    const loading = document.getElementById('dict-loading');
    const result  = document.getElementById('dict-result');
    const error   = document.getElementById('dict-error');

    // Reset
    panel.classList.remove('hidden');
    loading.classList.remove('hidden');
    result.classList.add('hidden');
    error.classList.add('hidden');

    try {
        const res  = await fetch(`https://api.dictionaryapi.dev/api/v2/entries/en/${encodeURIComponent(query)}`);
        if (!res.ok) throw new Error('Not found');
        const data = await res.json();
        const entry    = data[0];
        const meanings = entry?.meanings?.[0];
        const def      = meanings?.definitions?.[0];

        document.getElementById('dict-word').textContent = entry?.word || query;
        document.getElementById('dict-part').textContent = meanings?.partOfSpeech || '';
        document.getElementById('dict-def').textContent  = def?.definition || 'No definition found.';
        const ex = def?.example;
        const exEl = document.getElementById('dict-example');
        exEl.textContent = ex ? `"${ex}"` : '';

        loading.classList.add('hidden');
        result.classList.remove('hidden');
    } catch (e) {
        loading.classList.add('hidden');
        error.classList.remove('hidden');
    }
}

// =====================
// FINISH / COMPLETED BOOK
// =====================
const BOOK_ID = {{ $book->id }};

function markBookCompleted() {
    const isCompleted = localStorage.getItem(`book_completed_${BOOK_ID}`) === 'true';
    if (isCompleted) {
        // Unmark
        localStorage.removeItem(`book_completed_${BOOK_ID}`);
        updateFinishBtn(false);
    } else {
        // Mark complete
        localStorage.setItem(`book_completed_${BOOK_ID}`, 'true');
        updateFinishBtn(true);
        // Optionally persist to server
        @auth
        fetch('/dbim/my-library/completed/' + BOOK_ID, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ completed: true })
        }).catch(() => {});
        @endauth
    }
}

function updateFinishBtn(done) {
    const btn   = document.querySelector('#finish-book-btn');
    const label = document.querySelector('#finish-book-label');
    if (!btn) return;
    if (done) {
        btn.classList.remove('bg-emerald-500', 'hover:bg-emerald-600');
        btn.classList.add('bg-primary');
        label.textContent = '✓ Book Completed';
    } else {
        btn.classList.add('bg-emerald-500', 'hover:bg-emerald-600');
        btn.classList.remove('bg-primary');
        label.textContent = 'Mark as Finished';
    }
}

// Restore book completion state on load
if (localStorage.getItem(`book_completed_${BOOK_ID}`) === 'true') {
    updateFinishBtn(true);
}

// =====================
// READING PROGRESS
// =====================
const mainScroll = document.getElementById('main-scroll-area');
if (mainScroll) {
    mainScroll.addEventListener('scroll', () => {
        const { scrollTop, scrollHeight, clientHeight } = mainScroll;
        const pct = (scrollTop / (scrollHeight - clientHeight)) * 100;
        readingProgress.style.width = pct + '%';
        
        // Mark chapter as read when scrolled past 80%
        if (pct >= 80 && activeChapterId) {
            markChapterRead(activeChapterId);
        }

        // Mark individual pages as read
        const chapPageCount = document.querySelectorAll(`#pages-${activeChapterId} button`).length;
        if (chapPageCount > 1) {
            const currentPage = Math.floor((pct / 100) * chapPageCount) + 1;
            for (let p = 1; p <= currentPage; p++) {
                markPageRead(activeChapterId, p);
            }
        }
        
        if (Math.abs(pct - (window.__lastSaved || 0)) > 5) {
            saveProgress(pct);
            window.__lastSaved = pct;
        }
    });
}

async function saveProgress(pct) {
    @auth
    try {
        await fetch("{{ route('library.progress.update', $book->id) }}", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ chapter_id: activeChapterId, percentage: pct })
        });
        
        // Show completion badge if 100%
        if (pct >= 100) {
            const badge = document.querySelector(`.completed-badge-${activeChapterId}`);
            if (badge) badge.classList.remove('hidden');
        }
    } catch(e) {}
    @endauth
}

// =====================
// CHAPTER SWITCHING
// =====================
async function switchChapter(id, title, index) {
    if (isSpeaking) stopVoice();
    activeChapterId = id;
    activeChapterIndex = index;

    const isIntro = index === 0;
    const lockOverlay = document.getElementById('lock-overlay');
    const footerLock = document.getElementById('footer-lock-overlay');

    // Handle Locking Logic
    if (!isOwner && !isIntro) {
        if (lockOverlay) lockOverlay.classList.remove('hidden');
        if (footerLock) footerLock.classList.remove('hidden');
        // Disable TTS functionality visual indicators if locked
        document.getElementById('voice-progress-wrap')?.classList.add('opacity-20');
    } else {
        if (lockOverlay) lockOverlay.classList.add('hidden');
        if (footerLock) footerLock.classList.add('hidden');
        document.getElementById('voice-progress-wrap')?.classList.remove('opacity-20');
    }

    // Update sidebar active states
    document.querySelectorAll('.chapter-nav-item').forEach(el => {
        el.classList.remove('bg-primary/10', 'text-primary', 'border', 'border-primary/20', 'font-bold');
        el.classList.add('text-slate-600', 'dark:text-slate-400');
        const icon = el.querySelector('.material-symbols-outlined');
        if (icon) { icon.textContent = 'radio_button_unchecked'; icon.classList.remove('active-icon'); }
    });
    
    // Hide all pages lists, show active one
    document.querySelectorAll('.pages-list').forEach(p => p.classList.add('hidden'));
    const activePagesList = document.getElementById(`pages-${id}`);
    if (activePagesList) activePagesList.classList.remove('hidden');

    document.querySelectorAll(`.chapter-nav-item[data-id="${id}"]`).forEach(el => {
        el.classList.add('bg-primary/10', 'text-primary', 'border', 'border-primary/20');
        el.classList.remove('text-slate-600', 'dark:text-slate-400');
        const span = el.querySelector('span.text-sm');
        if (span) span.classList.add('font-bold');
        const icon = el.querySelector('.material-symbols-outlined');
        if (icon) { icon.textContent = 'menu_book'; icon.classList.add('active-icon'); }
    });

    // Update titles
    document.getElementById('chapter-title').innerText = title;
    const pt = document.getElementById('player-chapter-title');
    const pi = document.getElementById('player-chapter-index');
    if (pt) pt.innerText = title;
    if (pi) pi.innerText = `Section ${index + 1} of {{ $book->chapters->count() }}`;

    const badge = document.getElementById('annotation-chapter-badge');
    if (badge) badge.innerText = `Chapter ${index + 1}`;

    // Fetch chapter content (Intro is always allowed)
    try {
        const res = await fetch("{{ route('library.chapter.content', '') }}/" + id);
        const data = await res.json();
        
        if (!isOwner && !isIntro) {
            // Content is gated but we already show overlay, 
            // maybe show a blurred preview or just wait for overlay
            readerBody.innerHTML = '<div class="h-96"></div>'; 
        } else {
            readerBody.innerHTML = data.content || '<p class="text-slate-400 italic">No content yet.</p>';
        }
    } catch(e) {
        readerBody.innerHTML = '<p class="text-red-400">Failed to load chapter.</p>';
    }

    // Reset
    if (mainScroll) mainScroll.scrollTo({ top: 0, behavior: 'smooth' });
    wordIndex = 0;
    prepareUtterance();
    updateNavButtons();
    loadAnnotations();
    applySavedAnnotations();
    updateReadTime(); 

    // Handle finish button visibility
    const finishWrap = document.getElementById('finish-book-container');
    if (finishWrap) {
        // Only show on the last chapter
        if (index === totalChapters - 1) {
            finishWrap.classList.remove('hidden');
        } else {
            finishWrap.classList.add('hidden');
        }
    }

    // Refresh page checkmarks for this chapter
    if (readPages[id]) {
        readPages[id].forEach(p => {
            const check = document.querySelector(`.page-checkmark-${id}-${p}`);
            if (check) check.classList.remove('opacity-0');
        });
    }
}

function navigateChapter(dir) {
    const next = activeChapterIndex + dir;
    if (next >= 0 && next < totalChapters) {
        const el = document.querySelector(`.chapter-nav-item[data-index="${next}"]`);
        if (el) {
            const title = el.querySelector('span.text-sm').innerText;
            switchChapter(parseInt(el.dataset.id), title, next);
        }
    }
}

function updateNavButtons() {
    const prev = document.getElementById('prev-btn');
    const next = document.getElementById('next-btn');
    if (prev) prev.disabled = activeChapterIndex === 0;
    if (next) next.disabled = activeChapterIndex === totalChapters - 1;
    const label = next?.querySelector('.nav-label');
    if (label) {
        if (!isOwner && activeChapterIndex === 0) {
            label.innerText = 'Unlock to Continue';
        } else {
            if (activeChapterIndex === totalChapters - 1) {
                label.innerText = 'Last Chapter';
                next.disabled = true; // next button hidden/disabled on last chapter
            } else {
                label.innerText = 'Next Chapter';
                next.onclick = () => navigateChapter(1);
            }
        }
    }
}

// =====================
// VOICE READER
// =====================
let ttsNodes = [];
let ttsTotalChars = 0;
let ttsCurrentNodeIndex = 0;

function parseTtsNodes() {
    ttsNodes = [];
    ttsTotalChars = 0;
    const walker = document.createTreeWalker(readerBody, NodeFilter.SHOW_TEXT, null, false);
    let node;
    while ((node = walker.nextNode())) {
        const text = node.nodeValue;
        if (text.trim().length > 0) {
            ttsNodes.push({ node: node, text: text, charOffset: ttsTotalChars });
            ttsTotalChars += text.length;
        }
    }
}

function prepareUtterance() {
    if (!isOwner) return;
    if (synth.speaking) synth.cancel();
    
    parseTtsNodes();
    if (ttsNodes.length === 0) return;
    
    ttsCurrentNodeIndex = 0;
    for (let i = 0; i < ttsNodes.length; i++) {
        if (wordIndex >= ttsNodes[i].charOffset) ttsCurrentNodeIndex = i;
    }
    
    readerBody.classList.add('voice-active');
    playTtsNode(ttsCurrentNodeIndex, Math.max(0, wordIndex - ttsNodes[ttsCurrentNodeIndex].charOffset));
}

function playTtsNode(index, offset = 0) {
    if (index >= ttsNodes.length) { stopVoice(); return; }
    
    const nodeObj = ttsNodes[index];
    const remainingText = nodeObj.text.substring(offset);
    
    if (!remainingText.trim()) { playTtsNode(index + 1, 0); return; }

    // Safely extract just the FIRST chunk to fix Chrome SpeechSynthesis bugs on long strings
    let chunkLength = remainingText.length;
    const match = remainingText.match(/^[^.!?\n]+[.!?\n]+/);
    if (match && match[0].length < 300) {
        chunkLength = match[0].length;
    } else if (remainingText.length > 200) {
        let sp = remainingText.lastIndexOf(' ', 200);
        if (sp > 0) chunkLength = sp + 1;
        else chunkLength = 200;
    }
    
    const chunkText = remainingText.substring(0, chunkLength);

    utterance = new SpeechSynthesisUtterance(chunkText);
    utterance.rate  = currentRate;
    utterance.pitch = currentPitch;
    utterance.volume = currentVolume;
    
    utterance.onstart = () => { isSpeaking = true; isPaused = false; updatePlayIcon(); startProgressTracking(); };
    utterance.onend = () => { 
        if (isSpeaking && !isPaused) {
            if (offset + chunkLength < nodeObj.text.length) {
                playTtsNode(index, offset + chunkLength);
            } else {
                playTtsNode(index + 1, 0);
            }
        }
    };
    
    utterance.onboundary = (e) => {
        // Removed e.name === 'word' to support Windows TTS which often drops the name
        wordIndex = nodeObj.charOffset + offset + e.charIndex;
        updateTtsBar(wordIndex, ttsTotalChars);
        
        try {
            const range = document.createRange();
            let endOffset = offset + e.charIndex + (e.charLength || 0);
            if (!e.charLength || e.charLength === 0) {
                const remainingChunk = chunkText.substring(e.charIndex);
                const wmatch = remainingChunk.match(/^[\w\u00C0-\u017F]+/);
                endOffset = wmatch ? offset + e.charIndex + wmatch[0].length : offset + e.charIndex + 5;
            }
            if (endOffset > nodeObj.text.length) endOffset = nodeObj.text.length;
            
            range.setStart(nodeObj.node, offset + e.charIndex);
            range.setEnd(nodeObj.node, endOffset);
            
            const scrollArea = document.getElementById('main-scroll-area');
            const mainRect = scrollArea.getBoundingClientRect();
            const rect = range.getBoundingClientRect();
            
            if (rect.width > 0 && rect.height > 0) {
                let hl = document.getElementById('tts-hl-box');
                if (!hl) {
                    hl = document.createElement('div');
                    hl.id = 'tts-hl-box';
                    hl.style.position = 'absolute';
                    hl.style.backgroundColor = 'rgba(251, 191, 36, 0.4)';
                    hl.style.borderRadius = '4px';
                    hl.style.pointerEvents = 'none';
                    hl.style.transition = 'all 0.1s ease-out';
                    hl.style.zIndex = '40';
                    scrollArea.appendChild(hl);
                }
                hl.style.top = (scrollArea.scrollTop + (rect.top - mainRect.top) - 2) + 'px';
                hl.style.left = (scrollArea.scrollLeft + (rect.left - mainRect.left) - 2) + 'px';
                hl.style.width = (rect.width + 4) + 'px';
                hl.style.height = (rect.height + 4) + 'px';
                hl.style.display = 'block';
                
                if (rect.top < mainRect.top + 100 || rect.bottom > mainRect.bottom - 100) {
                    scrollArea.scrollBy({top: rect.top - (mainRect.top + scrollArea.clientHeight/3), left:0, behavior: 'smooth'});
                }
            }
        } catch(err) {}
    };
    synth.speak(utterance);
}

function toggleVoice() {
    if (!isOwner) { alert('Add this book to your collection to unlock the voice assistant.'); return; }
    if (isSpeaking) { isPaused ? resumeVoice() : pauseVoice(); } else { startVoice(); }
}

function startVoice() { prepareUtterance(); }
function pauseVoice() { synth.pause(); isPaused = true; updatePlayIcon(); stopProgressTracking(); }
function resumeVoice() { 
    synth.resume(); isPaused = false; updatePlayIcon(); 
    if (!synth.speaking && isSpeaking) prepareUtterance(); else startProgressTracking();
}

function stopVoice() { 
    isSpeaking = false; isPaused = false; synth.cancel(); wordIndex = 0; 
    parseTtsNodes(); updateTtsBar(0, ttsTotalChars || 1); updatePlayIcon(); stopProgressTracking(); 
    const hl = document.getElementById('tts-hl-box'); if (hl) hl.style.display = 'none';
}
function stopVoiceKeepPos() { 
    isSpeaking = false; isPaused = false; synth.cancel(); stopProgressTracking(); 
    const hl = document.getElementById('tts-hl-box'); if (hl) hl.style.display = 'none';
}

function startProgressTracking() {
    if (progressInterval) clearInterval(progressInterval);
    progressInterval = setInterval(() => { if (isSpeaking && !isPaused && synth.speaking && !synth.paused) synth.resume(); }, 10000); 
}
function stopProgressTracking() { clearInterval(progressInterval); progressInterval = null; }

function updateTtsBar(cur, total) {
    const pct = (cur / total) * 100;
    document.getElementById('voice-progress').style.width = pct + '%';
}

function updatePlayIcon() {
    const icon = document.getElementById('main-play-icon');
    if (icon) icon.textContent = (isSpeaking && !isPaused) ? 'pause' : 'play_arrow';
}

function setSpeed(rate) {
    currentRate = rate;
    document.querySelectorAll('.speed-btn').forEach(b => { b.classList.remove('bg-white', 'dark:bg-slate-700', 'text-primary', 'shadow-sm'); b.classList.add('text-slate-400'); });
    const btn = document.getElementById('speed-' + String(rate).replace('.', '-'));
    if (btn) { btn.classList.add('bg-white', 'dark:bg-slate-700', 'text-primary', 'shadow-sm'); btn.classList.remove('text-slate-400'); }
    const wasPlaying = isSpeaking && !isPaused; stopVoiceKeepPos(); prepareUtterance(); if (wasPlaying) startVoice();
}

function setPitch(pitch) {
    currentPitch = pitch;
    document.querySelectorAll('.pitch-btn').forEach(b => { b.classList.remove('bg-white', 'dark:bg-slate-700', 'text-primary', 'shadow-sm'); b.classList.add('text-slate-400'); });
    const btn = document.getElementById('pitch-' + String(pitch).replace('.', '-'));
    if (btn) { btn.classList.add('bg-white', 'dark:bg-slate-700', 'text-primary', 'shadow-sm'); btn.classList.remove('text-slate-400'); }
    const wasPlaying = isSpeaking && !isPaused; stopVoiceKeepPos(); prepareUtterance(); if (wasPlaying) startVoice();
}

function setVolume(vol) {
    currentVolume = parseFloat(vol);
    if (utterance) utterance.volume = currentVolume;
    const wasPlaying = isSpeaking && !isPaused;
    if (wasPlaying) { stopVoiceKeepPos(); prepareUtterance(); startVoice(); }
}

function seekVoice(deltaSeconds) {
    if (!isOwner) return;
    parseTtsNodes();
    const CHARS_PER_SEC = 14;
    wordIndex = Math.max(0, Math.min(ttsTotalChars - 1, wordIndex + deltaSeconds * CHARS_PER_SEC * currentRate));
    const wasPlaying = isSpeaking && !isPaused; stopVoiceKeepPos(); prepareUtterance(); if (wasPlaying) startVoice();
}

function handleSeek(e) {
    if (!ttsTotalChars) parseTtsNodes();
    const rect = e.currentTarget.getBoundingClientRect();
    const pct = (e.clientX - rect.left) / rect.width;
    wordIndex = Math.floor(pct * ttsTotalChars);
    updateTtsBar(wordIndex, ttsTotalChars);
    const wasPlaying = isSpeaking && !isPaused; stopVoiceKeepPos(); prepareUtterance(); if (wasPlaying) startVoice();
}

// =====================
// READER SETTINGS
// =====================
function changeMode(mode) {
    const mainArea = document.getElementById('main-scroll-area');
    const html = document.documentElement;
    
    // Reset special modes
    mainArea.classList.remove('sepia-mode');
    html.classList.remove('dark');
    
    if (mode === 'sepia') {
        mainArea.classList.add('sepia-mode');
    } else if (mode === 'dark') {
        html.classList.add('dark');
    }
    
    // Save preference
    localStorage.setItem('reader-mode', mode);
}

function adjustFontSize(delta) {
    currentFontSize = Math.min(Math.max(currentFontSize + delta, 14), 42);
    readerBody.style.fontSize = currentFontSize + 'px';
}

function toggleFontDropdown() {
    document.getElementById('font-dropdown').classList.toggle('hidden');
}

document.addEventListener('click', (e) => {
    if (!document.getElementById('font-dropdown-wrap')?.contains(e.target)) {
        document.getElementById('font-dropdown')?.classList.add('hidden');
    }
});

// =====================
// ANNOTATIONS
// =====================
let annotations = {};
let currentSelection = null;

function loadAnnotations() {
    annotations[activeChapterId] = JSON.parse(localStorage.getItem('ann_' + activeChapterId) || '[]');
    renderAnnotations();
}

function renderAnnotations() {
    const list = document.getElementById('annotations-list');
    const empty = document.getElementById('annotations-empty');
    if (!list) return;
    const data = annotations[activeChapterId] || [];
    if (data.length === 0) { if(empty) empty.classList.remove('hidden'); return; }
    if(empty) empty.classList.add('hidden');

    // Remove old rendered items (keep empty div)
    list.querySelectorAll('.ann-item').forEach(el => el.remove());

    data.forEach((ann, idx) => {
        const colorMap = { 'hl-gold': 'border-l-yellow-400', 'hl-blue': 'border-l-blue-300', 'hl-green': 'border-l-green-300' };
        const dotMap = { 'hl-gold': 'bg-yellow-400', 'hl-blue': 'bg-blue-300', 'hl-green': 'bg-green-300' };
        const div = document.createElement('div');
        div.className = `ann-item group p-3 rounded-lg border-l-4 ${colorMap[ann.color] || 'border-l-primary'} bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-800 shadow-sm relative transition-all hover:shadow-md`;
        div.innerHTML = `
            <div class="flex items-center justify-between mb-1">
                <span class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                    <span class="w-2 h-2 rounded-full ${dotMap[ann.color]}"></span>
                    ${ann.type}
                </span>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] text-slate-400">${ann.date}</span>
                    <button onclick="deleteAnnotation(${idx})" class="opacity-0 group-hover:opacity-100 p-1 hover:text-red-500 transition-all">
                        <span class="material-symbols-outlined text-sm">delete</span>
                    </button>
                </div>
            </div>
            <div onclick="scrollToAnnotation('${ann.id}')" class="cursor-pointer">
                <p class="text-sm italic text-slate-600 dark:text-slate-400 line-clamp-2">"${ann.text}"</p>
                ${ann.note ? `<p class="text-xs text-slate-500 dark:text-slate-400 mt-1">${ann.note}</p>` : ''}
            </div>
        `;
        list.appendChild(div);
    });
}

function scrollToAnnotation(id) {
    const el = document.getElementById(id);
    if (el) {
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        el.classList.add('ring-4', 'ring-primary/20', 'transition-all');
        setTimeout(() => el.classList.remove('ring-4', 'ring-primary/20'), 2000);
    } else {
        // If not found (maybe same-text wrapping issue), try to find by text content if we must
        console.warn('Annotation element not found:', id);
    }
}

function deleteAnnotation(index) {
    if (!confirm('Are you sure you want to delete this annotation?')) return;
    const ann = annotations[activeChapterId][index];
    annotations[activeChapterId].splice(index, 1);
    localStorage.setItem('ann_' + activeChapterId, JSON.stringify(annotations[activeChapterId]));

    // Delete from server
    if (ann && ann.serverId) {
        fetch('/dbim/annotations/' + ann.serverId, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}', 'Accept': 'application/json' }
        }).catch(() => {});
    }

    // Refresh UI
    renderAnnotations();
    window.location.reload();
}

function applySavedAnnotations() {
    const data = annotations[activeChapterId] || [];
    const content = readerBody.innerHTML;
    let newContent = content;

    data.forEach(ann => {
        if (ann.type === 'highlight' || ann.type === 'note') {
            const regex = new RegExp(ann.text.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g');
            // Only wrap if not already wrapped
            if (!newContent.includes(`id="${ann.id}"`)) {
                newContent = newContent.replace(regex, `<span id="${ann.id}" class="${ann.color} px-0.5 rounded cursor-pointer">${ann.text}</span>`);
            }
        }
    });

    readerBody.innerHTML = newContent;
}

const handleSelectionChange = (e) => {
    if (!isOwner) return;
    if (e && e.target && e.target.closest && (e.target.closest('#highlight-toolkit') || e.target.closest('#note-modal'))) return;
    
    // Small delay to ensure selection is processed by browser
    setTimeout(() => {
        const sel = window.getSelection();
        const text = sel?.toString().trim();
        const toolkit = document.getElementById('highlight-toolkit');
        if (!toolkit) return;
        
        if (text && text.length > 2) {
            const range = sel.getRangeAt(0);
            if (!readerBody.contains(range.commonAncestorContainer)) { closeToolkit(); return; }
            const r = range.getBoundingClientRect();
            
            // Positioning logic improved for mobile scroll area
            const scrollArea = document.getElementById('main-scroll-area');
            const mainRect = scrollArea.getBoundingClientRect();
            
            const toolkitWidth = 208; // w-52
            // left relative to scrollArea
            let left = scrollArea.scrollLeft + (r.left - mainRect.left) + r.width / 2 - toolkitWidth / 2;
            
            // Keep within horizontal bounds
            if (left < 10) left = 10;
            if (left + toolkitWidth > scrollArea.clientWidth - 10) {
                left = scrollArea.clientWidth - toolkitWidth - 10;
            }
            
            // Position above or below depending on space
            let top = scrollArea.scrollTop + (r.top - mainRect.top) - 90;
            if (r.top - mainRect.top < 90) {
                top = scrollArea.scrollTop + (r.bottom - mainRect.top) + 20; // Show below if no space above
            }
            
            // Append toolkit directly to scrollArea if it's not already
            if (toolkit.parentElement !== scrollArea) {
                scrollArea.appendChild(toolkit);
            }
            
            toolkit.style.position = 'absolute';
            toolkit.style.left = left + 'px';
            toolkit.style.top  = top + 'px';
            toolkit.style.display = 'block';
            currentSelection = { text, range: range.cloneRange() };
        } else {
            // Only close if we didn't just click the toolkit itself
            if (e && e.target && e.target.closest && !e.target.closest('#highlight-toolkit')) {
                closeToolkit();
            }
        }
    }, 100);
};

document.addEventListener('mouseup', handleSelectionChange);
document.addEventListener('touchend', handleSelectionChange);
document.addEventListener('selectionchange', () => {
    if (window.selectionTimeout) clearTimeout(window.selectionTimeout);
    window.selectionTimeout = setTimeout(() => handleSelectionChange({ target: document.activeElement }), 500);
});

function closeToolkit() {
    const toolkit = document.getElementById('highlight-toolkit');
    if (toolkit) toolkit.style.display = 'none';
    currentSelection = null;
    window.getSelection()?.removeAllRanges();
}

function applyHighlight(color) {
    if (!currentSelection) return;
    const annId = 'ann-' + Date.now();
    const span = document.createElement('span');
    span.id = annId;
    span.className = color + ' rounded cursor-pointer';
    span.appendChild(document.createTextNode(currentSelection.text));
    try { 
        currentSelection.range.deleteContents(); 
        currentSelection.range.insertNode(span);
    } catch(e) { console.error('Highlight error:', e); }
    saveAnnotation({ id: annId, type: 'highlight', text: currentSelection.text, color, date: new Date().toLocaleDateString() });
    closeToolkit();
}

function showNoteModal() { 
    if (!currentSelection) return;
    const modal = document.getElementById('note-modal');
    const preview = document.getElementById('note-selection-preview');
    if (preview) preview.textContent = '"' + currentSelection.text + '"';
    modal.style.display = 'block';
}
function closeNoteModal() { 
    const modal = document.getElementById('note-modal');
    modal.style.display = 'none'; 
    document.getElementById('note-text').value = ''; 
}

function saveNote() {
    const text = document.getElementById('note-text').value.trim();
    if (!text || !currentSelection) return;
    const annId = 'ann-' + Date.now();
    // Wrap the text so we can anchor to it later
    const span = document.createElement('span');
    span.id = annId;
    span.className = 'hl-blue px-0.5 rounded cursor-pointer';
    span.innerText = currentSelection.text;
    try { 
        currentSelection.range.deleteContents(); 
        currentSelection.range.insertNode(span); 
    } catch(e) {}
    
    saveAnnotation({ id: annId, type: 'note', text: currentSelection.text, note: text, color: 'hl-blue', date: new Date().toLocaleDateString() });
    closeNoteModal();
    cleanup();
}

function saveAnnotation(data) {
    if (!data.id) data.id = 'ann-' + Date.now();
    if (!annotations[activeChapterId]) annotations[activeChapterId] = [];
    annotations[activeChapterId].push(data);
    localStorage.setItem('ann_' + activeChapterId, JSON.stringify(annotations[activeChapterId]));
    renderAnnotations();

    // Sync to server
    @auth
    fetch("{{ route('student.annotations.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            book_id: BOOK_ID,
            chapter_id: activeChapterId,
            annotation_id: data.id,
            type: data.type || 'highlight',
            text: data.text,
            note: data.note || null,
            color: data.color || 'hl-gold'
        })
    }).then(res => res.json()).then(result => {
        // Store server ID for future delete operations
        if (result.annotation && result.annotation.id) {
            const idx = annotations[activeChapterId].findIndex(a => a.id === data.id);
            if (idx !== -1) {
                annotations[activeChapterId][idx].serverId = result.annotation.id;
                localStorage.setItem('ann_' + activeChapterId, JSON.stringify(annotations[activeChapterId]));
            }
        }
    }).catch(() => {});
    @endauth
}

function cleanup() {
    closeToolkit();
}

function toggleChapterSidebar() {
    const s = document.getElementById('chapter-sidebar');
    const backdrop = document.getElementById('sidebar-backdrop');
    if (!s) return;
    
    // Close other sidebars if opening this one on mobile
    if (window.innerWidth < 1024 && s.classList.contains('sidebar-closed')) {
        document.getElementById('annotation-sidebar')?.classList.add('sidebar-closed');
    }

    s.classList.toggle('sidebar-closed');
    
    // Backdrop logic
    updateBackdrop();
}

function toggleAnnotationsSidebar() {
    const s = document.getElementById('annotation-sidebar');
    if (!s) return;

    if (window.innerWidth < 1024 && s.classList.contains('sidebar-closed')) {
        document.getElementById('chapter-sidebar')?.classList.add('sidebar-closed');
    }

    s.classList.toggle('sidebar-closed');
    updateBackdrop();
}

function closeAllSidebars() {
    document.getElementById('chapter-sidebar')?.classList.add('sidebar-closed');
    document.getElementById('annotation-sidebar')?.classList.add('sidebar-closed');
    updateBackdrop();
}

function updateBackdrop() {
    const backdrop = document.getElementById('sidebar-backdrop');
    const chapterOpen = !document.getElementById('chapter-sidebar')?.classList.contains('sidebar-closed');
    const annOpen = !document.getElementById('annotation-sidebar')?.classList.contains('sidebar-closed');
    const anyOpen = (chapterOpen || annOpen) && window.innerWidth < 1024;

    if (backdrop) {
        if (anyOpen) {
            backdrop.classList.remove('hidden');
            setTimeout(() => backdrop.classList.remove('opacity-0'), 10);
            document.body.style.overflow = 'hidden';
        } else {
            backdrop.classList.add('opacity-0');
            setTimeout(() => backdrop.classList.add('hidden'), 300);
            document.body.style.overflow = '';
        }
    }
}

// =====================
// READER SETTINGS PANEL
// =====================
function showReaderSettings() {
    let panel = document.getElementById('reader-settings-panel');
    if (!panel) {
        panel = document.createElement('div');
        panel.id = 'reader-settings-panel';
        panel.className = 'fixed bottom-24 left-4 z-[80] w-64 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-2xl p-4';
        panel.innerHTML = `
            <div class="flex items-center justify-between mb-4">
                <p class="text-xs font-black uppercase tracking-widest text-slate-400">Reader Settings</p>
                <button onclick="document.getElementById('reader-settings-panel').remove()" class="text-slate-400 hover:text-slate-600">
                    <span class="material-symbols-outlined text-base">close</span>
                </button>
            </div>
            <div class="space-y-4">
                <div>
                    <p class="text-[11px] font-bold text-slate-500 mb-2">Font Size</p>
                    <div class="flex items-center gap-3">
                        <button onclick="adjustFontSize(-2)" class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-200">
                            <span class="material-symbols-outlined text-base">remove</span>
                        </button>
                        <span id="settings-font-label" class="text-sm font-bold text-slate-700 dark:text-slate-200 flex-1 text-center">${currentFontSize}px</span>
                        <button onclick="adjustFontSize(2)" class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-200">
                            <span class="material-symbols-outlined text-base">add</span>
                        </button>
                    </div>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-500 mb-2">Theme</p>
                    <div class="flex gap-2">
                        <button onclick="changeMode('light')"  class="flex-1 py-1.5 rounded-lg bg-white border border-slate-200 text-[11px] font-bold text-slate-600 hover:border-primary">Light</button>
                        <button onclick="changeMode('sepia')"  class="flex-1 py-1.5 rounded-lg bg-amber-50 border border-amber-200 text-[11px] font-bold text-amber-800 hover:border-primary">Sepia</button>
                        <button onclick="changeMode('dark')"   class="flex-1 py-1.5 rounded-lg bg-slate-900 border border-slate-700 text-[11px] font-bold text-white hover:border-primary">Dark</button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(panel);
    } else {
        panel.remove();
    }
}
// =====================
// COLLECTION ACCESS
// =====================
async function addToCollection(e, bookId) {
    e.preventDefault();
    const btn = document.querySelectorAll('.add-btn-' + bookId);
    
    try {
        btn.forEach(b => {
            b.disabled = true;
            b.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">progress_activity</span> Unlocking...';
        });
        
        const res = await fetch("{{ route('student.library.add', ':id') }}".replace(':id', bookId), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });
        
        const data = await res.json();
        
        if (res.ok) {
            if (data.redirect) {
                window.location.href = data.url;
                return;
            }
            if (window.Swal) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Access Granted!',
                    text: data.success || 'This book has been added to your collection.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
            // Reload to unlock all gated features
            window.location.reload();
        } else {
            throw new Error(data.error || 'Failed to unlock.');
        }
    } catch (err) {
        btn.forEach(b => {
            b.disabled = false;
            b.innerHTML = '<span class="material-symbols-outlined text-xl">bookmark_add</span> Get Book to Unlock';
        });
        if (window.Swal) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: err.message
            });
        }
    }
}


// =====================
// INIT
// =====================
window.addEventListener('load', () => {
    updateNavButtons();
    loadAnnotations();
    updateReadTime(); // calculate from initial chapter content
    
    // Load saved mode
    const savedMode = localStorage.getItem('reader-mode') || 'dark';
    changeMode(savedMode);
    
    // Apply highlights after initialization
    setTimeout(applySavedAnnotations, 500);
    
    if (isOwner) parseTtsNodes();
});
</script>
@endpush

