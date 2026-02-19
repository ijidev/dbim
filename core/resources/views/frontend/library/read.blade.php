@extends('layouts.reader')


@section('title', $book->title . ' — Reader')

@push('styles')
<style>
    /* Reader custom styles */
    .active-icon {
        font-variation-settings: 'FILL' 1;
    }
    .sepia-mode {
        background-color: #f4ecd8 !important;
        color: #5b4636 !important;
    }
    .sepia-mode article, .sepia-mode #reader-body {
        color: #5b4636 !important;
    }
    .hl-gold { background-color: rgba(255, 215, 0, 0.4); }
    .hl-blue { background-color: rgba(147, 197, 253, 0.5); }
    .hl-green { background-color: rgba(134, 239, 172, 0.5); }
    
    .dark .hl-gold { background-color: rgba(255, 215, 0, 0.2); border-bottom: 2px solid rgba(255, 215, 0, 0.5); }
    .dark .hl-blue { background-color: rgba(147, 197, 253, 0.2); border-bottom: 2px solid rgba(147, 197, 253, 0.5); }
    .dark .hl-green { background-color: rgba(134, 239, 172, 0.2); border-bottom: 2px solid rgba(134, 239, 172, 0.5); }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; }

    /* Reader body should be full-height, override layout defaults */
    body.reader-page { overflow: hidden; height: 100vh; }
    #reader-layout { height: calc(100vh - 6px); }
</style>
@endpush


@section('content')
<div class="flex flex-col overflow-hidden h-screen">


{{-- Reading Progress Bar --}}
<div class="w-full bg-slate-200 dark:bg-slate-800 h-1.5 sticky top-0 z-50">
    <div id="reading-progress" class="bg-primary h-full transition-all duration-500" style="width: 0%;"></div>
</div>

<div class="flex flex-1 overflow-hidden">

    {{-- LEFT SIDEBAR: Chapter List --}}
    <aside class="w-72 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col h-full shrink-0 hidden lg:flex">
        <div class="p-6 border-b border-slate-200 dark:border-slate-800">
            <div class="flex items-center gap-2 text-primary mb-1">
                <span class="material-symbols-outlined text-xl">auto_stories</span>
                <span class="text-xs font-bold uppercase tracking-wider">Church Library</span>
            </div>
            <h2 class="text-xl font-bold dark:text-white leading-tight">{{ Str::limit($book->title, 30) }}</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $book->chapters->count() }} chapters</p>
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
                    <button class="w-full text-left py-1.5 text-[11px] font-bold text-slate-400 hover:text-primary transition-colors flex items-center justify-between group">
                        <span>Page {{ $p }}</span>
                        <span class="material-symbols-outlined text-xs text-emerald-500 opacity-0 group-hover:opacity-100">check</span>
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

        {{-- Floating Toolbar (top-right) --}}
        <div class="sticky top-6 right-6 z-40 flex justify-end px-8">
            <div class="bg-white dark:bg-slate-800 shadow-xl border border-slate-200 dark:border-slate-700 rounded-xl p-1 flex items-center gap-1">
                <button onclick="toggleMobileSidebar()" class="p-2 rounded-lg bg-slate-100 dark:bg-slate-900 text-slate-900 dark:text-white hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors" title="Toggle Sidebar">
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
        <div id="highlight-toolkit" class="fixed z-[70] hidden flex-col bg-slate-900 text-white rounded-xl shadow-2xl animate-in fade-in zoom-in duration-200 overflow-hidden w-64">
            <div class="flex items-center p-1 border-b border-slate-800">
                <div class="flex items-center gap-1 px-2 border-r border-slate-700">
                    <button onclick="applyHighlight('hl-gold')" class="w-6 h-6 rounded-full bg-highlight-gold border border-white/20 hover:scale-110 transition-transform"></button>
                    <button onclick="applyHighlight('hl-blue')" class="w-6 h-6 rounded-full bg-highlight-blue border border-white/20 hover:scale-110 transition-transform"></button>
                    <button onclick="applyHighlight('hl-green')" class="w-6 h-6 rounded-full bg-highlight-green border border-white/20 hover:scale-110 transition-transform"></button>
                </div>
                <button onclick="showNoteModal()" class="flex-1 flex items-center justify-center gap-2 py-2 text-[11px] font-semibold hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-sm">add_comment</span>
                    Add Note
                </button>
            </div>
            <div class="p-2 bg-slate-800/50">
                <p class="text-[10px] uppercase font-bold text-slate-400 mb-1.5 px-1">Share to Group Feed</p>
                <div class="relative">
                    <select class="w-full bg-slate-900 border-slate-700 text-white text-xs rounded-lg py-1.5 pl-2 pr-8 focus:ring-primary focus:border-primary appearance-none cursor-pointer">
                        <option>Adult Bible Study</option>
                        <option>Young Adults Group</option>
                        <option>Prayer Warriors</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-sm pointer-events-none text-slate-400">expand_more</span>
                </div>
                <button onclick="cleanup()" class="w-full mt-2 bg-primary hover:bg-primary/90 text-white text-[11px] font-bold py-1.5 rounded-lg flex items-center justify-center gap-2 transition-colors">
                    <span class="material-symbols-outlined text-sm">share</span>
                    Publish Insight
                </button>
            </div>
            <div class="absolute -bottom-1.5 left-1/2 -translate-x-1/2 w-3 h-3 bg-slate-800 rotate-45 border-r border-b border-slate-800"></div>
        </div>
        @endif

        {{-- Article Content --}}
        <article class="max-w-[800px] mx-auto px-12 py-12 pb-48">
            <header class="mb-12">
                <nav class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-sm mb-4">
                    <a href="{{ route('library.index') }}">Library</a>
                    <span class="material-symbols-outlined text-xs">chevron_right</span>
                    <span>{{ $book->title }}</span>
                </nav>
                <h1 id="chapter-title" class="font-serif text-5xl font-bold dark:text-white mb-4 leading-tight">{{ $book->chapters->first()->title ?? 'Introduction' }}</h1>
                <div class="flex items-center gap-4 py-2 border-y border-slate-100 dark:border-slate-800">
                    <span class="text-xs font-medium uppercase tracking-widest text-primary">Read Time: 12 mins</span>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                    <span class="text-xs font-medium uppercase tracking-widest text-slate-500">Audio: 15 mins</span>
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
        </article>
    </main>

    {{-- RIGHT SIDEBAR: Annotations --}}
    @if($isOwner)
    <aside id="annotation-sidebar" class="w-80 bg-white dark:bg-slate-900 border-l border-slate-200 dark:border-slate-800 flex flex-col h-full shrink-0 hidden lg:flex">
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">history_edu</span>
                <h2 class="text-lg font-bold dark:text-white">My Annotations</h2>
            </div>
            <span id="annotation-chapter-badge" class="bg-primary/10 text-primary text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Chapter 1</span>
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

        {{-- Right: Speed + Listen CTA --}}
        <div class="flex items-center justify-end gap-4 w-1/4">
            <div class="flex items-center bg-slate-100 dark:bg-slate-800 rounded-lg p-1">
                <button id="speed-1" onclick="setSpeed(1)" class="speed-btn px-3 py-1 text-xs font-bold rounded bg-white dark:bg-slate-700 text-primary shadow-sm">1x</button>
                <button id="speed-1-5" onclick="setSpeed(1.5)" class="speed-btn px-3 py-1 text-xs font-bold rounded text-slate-400 hover:text-primary">1.5x</button>
                <button id="speed-2" onclick="setSpeed(2)" class="speed-btn px-3 py-1 text-xs font-bold rounded text-slate-400 hover:text-primary">2x</button>
            </div>
            <button onclick="toggleVoice()" class="flex items-center gap-2 px-6 py-2.5 bg-primary text-white rounded-xl font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined text-xl">record_voice_over</span>
                Listen
            </button>
        </div>
    </div>
</footer>

{{-- Note Modal --}}
@if($isOwner)
<div id="note-modal" class="fixed inset-0 z-[80] hidden items-center justify-center p-6">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeNoteModal()"></div>
    <div class="relative w-full max-w-lg bg-white dark:bg-slate-900 rounded-2xl shadow-2xl p-8">
        <h3 class="text-sm font-bold uppercase tracking-widest text-slate-400 mb-6">Add Personal Note</h3>
        <textarea id="note-text" rows="4" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-4 text-sm focus:ring-2 focus:ring-primary/30 outline-none resize-none" placeholder="What truth are you reflecting on?"></textarea>
        <div class="mt-6 flex items-center justify-end gap-4">
            <button onclick="closeNoteModal()" class="text-sm font-bold text-slate-400 hover:text-slate-600">Cancel</button>
            <button onclick="saveNote()" class="px-8 py-3 bg-primary text-white text-sm font-bold rounded-xl hover:scale-105 transition-all shadow-lg shadow-primary/20">Save Note</button>
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
let wordIndex = 0;
let progressInterval = null;

// =====================
// READING PROGRESS
// =====================
const mainScroll = document.getElementById('main-scroll-area');
if (mainScroll) {
    mainScroll.addEventListener('scroll', () => {
        const { scrollTop, scrollHeight, clientHeight } = mainScroll;
        const pct = (scrollTop / (scrollHeight - clientHeight)) * 100;
        readingProgress.style.width = pct + '%';
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
            label.innerText = activeChapterIndex === totalChapters - 1 ? 'Finish Reading' : 'Next Chapter';
        }
    }
}

// =====================
// VOICE READER
// =====================
function prepareUtterance() {
    if (!isOwner) return;
    if (synth.speaking) synth.cancel();
    const text = readerBody.innerText;
    utterance = new SpeechSynthesisUtterance(text.substring(wordIndex));
    utterance.rate = currentRate;
    utterance.onstart = () => { isSpeaking = true; isPaused = false; updatePlayIcon(); startProgressTracking(); };
    utterance.onend = () => stopVoice();
    utterance.onboundary = (e) => { if (e.name === 'word') { wordIndex = Math.max(wordIndex, e.charIndex); updateTtsBar(wordIndex, text.length); } };
}

function toggleVoice() {
    if (!isOwner) { alert('Add this book to your collection to unlock the voice assistant.'); return; }
    if (isSpeaking) { isPaused ? resumeVoice() : pauseVoice(); }
    else startVoice();
}

function startVoice() { if (!utterance) prepareUtterance(); synth.speak(utterance); }
function pauseVoice() { synth.pause(); isPaused = true; updatePlayIcon(); stopProgressTracking(); }
function resumeVoice() { synth.resume(); isPaused = false; updatePlayIcon(); startProgressTracking(); }
function stopVoice() { synth.cancel(); isSpeaking = false; isPaused = false; wordIndex = 0; updatePlayIcon(); stopProgressTracking(); }

function startProgressTracking() {
    if (progressInterval) clearInterval(progressInterval);
    const totalChars = readerBody.innerText.length;
    progressInterval = setInterval(() => {
        if (isSpeaking && !isPaused) {
            wordIndex += (12 * currentRate / 20);
            if (wordIndex >= totalChars) { wordIndex = totalChars; stopProgressTracking(); }
            updateTtsBar(wordIndex, totalChars);
        }
    }, 50);
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
    document.querySelectorAll('.speed-btn').forEach(b => {
        b.classList.remove('bg-white', 'dark:bg-slate-700', 'text-primary', 'shadow-sm');
        b.classList.add('text-slate-400');
    });
    const btn = document.getElementById('speed-' + String(rate).replace('.', '-'));
    if (btn) { btn.classList.add('bg-white', 'dark:bg-slate-700', 'text-primary', 'shadow-sm'); btn.classList.remove('text-slate-400'); }
    if (isSpeaking) { const was = !isPaused; stopVoice(); prepareUtterance(); if (was) startVoice(); }
}

function seekVoice(delta) {
    if (!isOwner) return;
    const text = readerBody.innerText;
    wordIndex = Math.max(0, Math.min(text.length - 1, wordIndex + delta * 12 * currentRate));
    const sp = text.indexOf(' ', wordIndex);
    if (sp !== -1) wordIndex = sp + 1;
    const was = isSpeaking && !isPaused;
    stopVoice();
    prepareUtterance();
    if (was) startVoice();
}

function handleSeek(e) {
    const rect = e.currentTarget.getBoundingClientRect();
    const pct = (e.clientX - rect.left) / rect.width;
    wordIndex = Math.floor(pct * readerBody.innerText.length);
    updateTtsBar(wordIndex, readerBody.innerText.length);
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

    data.forEach(ann => {
        const colorMap = { 'hl-gold': 'border-l-yellow-400', 'hl-blue': 'border-l-blue-300', 'hl-green': 'border-l-green-300' };
        const dotMap = { 'hl-gold': 'bg-yellow-400', 'hl-blue': 'bg-blue-300', 'hl-green': 'bg-green-300' };
        const div = document.createElement('div');
        div.className = `ann-item group p-3 rounded-lg border-l-4 ${colorMap[ann.color] || 'border-l-primary'} bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-800 shadow-sm`;
        div.innerHTML = `
            <div class="flex items-center justify-between mb-1">
                <span class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                    <span class="w-2 h-2 rounded-full ${dotMap[ann.color]}"></span>
                    ${ann.type}
                </span>
                <span class="text-[10px] text-slate-400">${ann.date}</span>
            </div>
            <p class="text-sm italic text-slate-600 dark:text-slate-400 line-clamp-2">"${ann.text}"</p>
            ${ann.note ? `<p class="text-xs text-slate-500 dark:text-slate-400 mt-1">${ann.note}</p>` : ''}
        `;
        list.appendChild(div);
    });
}

document.addEventListener('mouseup', (e) => {
    if (!isOwner) return;
    if (e.target.closest('#highlight-toolkit') || e.target.closest('#note-modal')) return;
    const sel = window.getSelection();
    const text = sel?.toString().trim();
    const toolkit = document.getElementById('highlight-toolkit');
    if (!toolkit) return;
    if (text && text.length > 3) {
        const range = sel.getRangeAt(0);
        if (!readerBody.contains(range.commonAncestorContainer)) { toolkit.classList.add('hidden'); return; }
        const r = range.getBoundingClientRect();
        toolkit.style.top = `${r.top + window.scrollY - 72}px`;
        toolkit.style.left = `${r.left + r.width / 2 - 130}px`;
        toolkit.classList.remove('hidden');
        toolkit.style.display = 'flex';
        currentSelection = { text, range: range.cloneRange() };
    } else {
        toolkit.classList.add('hidden');
    }
});

function applyHighlight(color) {
    if (!currentSelection) return;
    const span = document.createElement('span');
    span.className = color + ' px-0.5 rounded cursor-pointer';
    span.innerText = currentSelection.text;
    try { currentSelection.range.deleteContents(); currentSelection.range.insertNode(span); } catch(e) {}
    saveAnnotation({ type: 'highlight', text: currentSelection.text, color, date: new Date().toLocaleDateString() });
    cleanup();
}

function showNoteModal() { document.getElementById('note-modal').classList.remove('hidden'); document.getElementById('note-modal').style.display = 'flex'; }
function closeNoteModal() { document.getElementById('note-modal').classList.add('hidden'); document.getElementById('note-text').value = ''; }

function saveNote() {
    const text = document.getElementById('note-text').value.trim();
    if (!text || !currentSelection) return;
    saveAnnotation({ type: 'note', text: currentSelection.text, note: text, color: 'hl-blue', date: new Date().toLocaleDateString() });
    closeNoteModal();
    cleanup();
}

function saveAnnotation(data) {
    if (!annotations[activeChapterId]) annotations[activeChapterId] = [];
    annotations[activeChapterId].push(data);
    localStorage.setItem('ann_' + activeChapterId, JSON.stringify(annotations[activeChapterId]));
    renderAnnotations();
}

function cleanup() {
    window.getSelection()?.removeAllRanges();
    currentSelection = null;
    const tk = document.getElementById('highlight-toolkit');
    if (tk) tk.classList.add('hidden');
}

function exportAnnotations() {
    const all = annotations[activeChapterId] || [];
    const text = all.map(a => `[${a.type}] "${a.text}"${a.note ? '\nNote: ' + a.note : ''}`).join('\n\n');
    const blob = new Blob([text], { type: 'text/plain' });
    const a = document.createElement('a'); a.href = URL.createObjectURL(blob);
    a.download = 'annotations.txt'; a.click();
}

// =====================
// SIDEBARS & MOBILE
// =====================
function toggleAnnotationsSidebar() {
    const s = document.getElementById('annotation-sidebar');
    if (s) s.classList.toggle('hidden');
}

function toggleMobileSidebar() {
    document.getElementById('mobile-sidebar').classList.toggle('-translate-x-full');
    document.getElementById('mobile-sidebar-overlay').classList.toggle('hidden');
}

function closeMobileSidebar() {
    document.getElementById('mobile-sidebar').classList.add('-translate-x-full');
    document.getElementById('mobile-sidebar-overlay').classList.add('hidden');
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
        
        const res = await fetch(`/dbim/my-library/add/${bookId}`, {
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

function showReaderSettings() {}

// =====================
// INIT
// =====================
window.addEventListener('load', () => {
    updateNavButtons();
    loadAnnotations();
    
    // Load saved mode
    const savedMode = localStorage.getItem('reader-mode') || 'dark';
    changeMode(savedMode);
    
    if (isOwner) prepareUtterance();
});
</script>
@endpush

