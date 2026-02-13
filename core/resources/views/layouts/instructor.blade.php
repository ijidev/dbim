@extends('layouts.app')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --primary: #1A237E;
        --accent: #C5A059;
        --background-light: #f8f9fb;
        --background-dark: #0f172a;
    }

    body { 
        font-family: 'Inter', sans-serif;
        background-color: var(--background-light);
    }
    
    h1, h2, h3, h4, h5, h6, .font-display { 
        font-family: 'Lexend', sans-serif; 
    }

    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .filled-icon { font-variation-settings: 'FILL' 1; }

    /* Custom Scrollbar for Sidebar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #dcdfe5;
        border-radius: 10px;
    }

    /* Fixed Header Style */
    .glass-header {
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
    }
</style>
@yield('instructor_styles')
@endpush

@section('content')
<div class="flex min-h-[calc(100vh-72px)] bg-[#f8f9fb]">
    <!-- Global Sidebar -->
    <div class="hidden lg:block">
        @include('partials.sidebar')
    </div>

    <!-- Main Content -->
    <main class="flex-1 overflow-x-hidden">
        <!-- Sub Header (Role Specific Title) -->
        <header class="h-14 glass-header sticky top-[72px] z-[40] flex items-center justify-between px-8 lg:px-12">
            <div class="flex items-center gap-4">
                <h2 class="text-lg font-black text-primary tracking-tight">@yield('page_title', 'Instructor Panel')</h2>
            </div>
            <div class="flex items-center gap-6">
                <button class="p-2 rounded-xl bg-slate-50 text-slate-400 hover:text-primary transition-all relative">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-2.5 right-2.5 size-2 bg-accent rounded-full border-2 border-white"></span>
                </button>
                <div class="h-6 w-px bg-slate-200"></div>
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-black text-slate-900 leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Instructor</p>
                    </div>
                </div>
            </div>
        </header>

        <div class="px-8 py-4 lg:px-12 lg:py-6 max-w-7xl mx-auto">
            @yield('instructor_content')
        </div>
    </main>
</div>
@endsection

@push('scripts')
@yield('instructor_scripts')
@endpush
