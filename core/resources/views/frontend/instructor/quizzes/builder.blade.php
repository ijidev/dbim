<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quiz Builder | {{ config('app.name') }}</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1A237E",
                        "accent": "#C5A059",
                        "background-light": "#f8f9fb",
                    },
                    fontFamily: {
                        "display": ["Lexend", "sans-serif"],
                        "body": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "2xl": "1.25rem",
                        "3xl": "2.5rem",
                    }
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fb; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Lexend', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .filled-icon { font-variation-settings: 'FILL' 1; }
        [x-cloak] { display: none !important; }
        
        /* Glassmorphism Header */
        .glass-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #dcdfe5;
        }

        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #dcdfe5; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#f8f9fb] text-slate-900 overflow-hidden font-body" x-data="quizBuilder()">

<div class="flex h-screen overflow-hidden">
    <!-- Redesigned Global-Style Sidebar -->
    <aside class="w-[280px] flex-shrink-0 bg-white border-r border-[#dcdfe5] flex flex-col z-20">
        <div class="p-8 flex flex-col gap-8">
            <div class="flex gap-4 items-center">
                <div class="bg-primary rounded-2xl size-12 flex items-center justify-center text-white shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined text-2xl font-bold">church</span>
                </div>
                <div class="flex flex-col">
                    <h1 class="text-slate-900 text-sm font-black leading-none tracking-tight">{{ config('app.name') }}</h1>
                    <p class="text-primary text-[10px] font-bold uppercase tracking-widest mt-1">Instructor</p>
                </div>
            </div>
            
            <nav class="flex flex-col gap-2">
                <a href="{{ route('instructor.dashboard') }}" class="flex items-center gap-4 px-4 py-3.5 text-slate-400 hover:bg-slate-50 hover:text-primary rounded-2xl transition-all group">
                    <span class="material-symbols-outlined text-xl group-hover:filled-icon">dashboard</span>
                    <span class="text-xs font-black uppercase tracking-widest">Dashboard</span>
                </a>
                <a href="{{ route('instructor.courses.index') }}" class="flex items-center gap-4 px-4 py-3.5 text-slate-400 hover:bg-slate-50 hover:text-primary rounded-2xl transition-all group">
                    <span class="material-symbols-outlined text-xl group-hover:filled-icon">book_2</span>
                    <span class="text-xs font-black uppercase tracking-widest">Courses</span>
                </a>
                <a href="{{ route('instructor.quizzes.index') }}" class="flex items-center gap-4 px-4 py-3.5 bg-primary/5 text-primary rounded-2xl font-black shadow-sm group">
                    <span class="material-symbols-outlined filled-icon text-xl">quiz</span>
                    <span class="text-xs uppercase tracking-widest">Quiz Builder</span>
                </a>
                 <a href="{{ route('instructor.students.index') }}" class="flex items-center gap-4 px-4 py-3.5 text-slate-400 hover:bg-slate-50 hover:text-primary rounded-2xl transition-all group">
                    <span class="material-symbols-outlined text-xl group-hover:filled-icon">group</span>
                    <span class="text-xs font-black uppercase tracking-widest">Students</span>
                </a>
            </nav>
        </div>
        
        <div class="mt-auto p-6 border-t border-[#dcdfe5] bg-[#f8f9fb]">
            <div class="flex items-center gap-4">
                <div class="size-10 rounded-xl bg-white shadow-sm border border-slate-100 bg-cover bg-center" style="background-image: url('{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}')"></div>
                <div class="flex flex-col">
                    <p class="text-xs font-black text-slate-900 leading-none">{{ Auth::user()->name }}</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-[9px] font-bold text-slate-400 hover:text-red-500 uppercase tracking-widest mt-1">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col overflow-hidden relative">
        <!-- Redesigned Glass Header -->
        <header class="h-20 glass-header flex items-center justify-between px-10 z-10">
            <div class="flex items-center gap-6">
                <a href="{{ route('instructor.quizzes.index') }}" class="size-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:text-primary hover:bg-white hover:shadow-sm transition-all">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <div class="h-8 w-px bg-slate-200"></div>
                <input type="text" x-model="quiz.title" class="text-xl font-black tracking-tight text-slate-900 border-none focus:ring-0 p-0 placeholder-slate-300 w-96 bg-transparent" placeholder="Assessment Title...">
            </div>
            
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-3">
                     <template x-if="status === 'saving'">
                        <div class="flex items-center gap-2">
                             <div class="size-1.5 bg-amber-400 rounded-full animate-pulse"></div>
                             <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Syncing Changes...</span>
                        </div>
                     </template>
                     <template x-if="status === 'saved'">
                        <div class="flex items-center gap-2">
                             <span class="material-symbols-outlined text-emerald-500 text-lg font-bold">check_circle</span>
                             <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">Saved to Cloud</span>
                        </div>
                     </template>
                </div>
                
                <div class="flex items-center bg-slate-50 p-1.5 rounded-2xl border border-slate-100">
                    <button @click="view = 'build'" :class="view === 'build' ? 'bg-white shadow-sm text-primary' : 'text-slate-400 hover:text-slate-600'" class="px-6 py-2 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all">Build</button>
                    <button @click="view = 'preview'" :class="view === 'preview' ? 'bg-white shadow-sm text-primary' : 'text-slate-400 hover:text-slate-600'" class="px-6 py-2 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all">Preview</button>
                </div>
                
                <div class="h-6 w-px bg-slate-200"></div>
                
                <button @click="saveQuiz(true)" class="h-12 px-8 bg-primary text-white text-[10px] font-black uppercase tracking-[0.1em] rounded-xl shadow-lg shadow-primary/20 hover:scale-105 active:scale-95 transition-all flex items-center gap-3">
                    <span class="material-symbols-outlined text-lg">cloud_upload</span>
                    Finalize & Exit
                </button>
            </div>
        </header>

        <div class="flex-1 flex overflow-hidden">
            <!-- Questions List Sidebar - Redesigned Card List -->
            <div class="w-[320px] flex-shrink-0 bg-white border-r border-[#dcdfe5] flex flex-col">
                <div class="p-6 border-b border-slate-50 flex items-center justify-between bg-[#f8f9fb]">
                    <div>
                        <h3 class="font-black text-xs text-slate-900 uppercase tracking-widest">Stack Inventory</h3>
                        <p class="text-[10px] font-bold text-slate-400 mt-0.5"><span x-text="quiz.questions.length"></span> Questions Active</p>
                    </div>
                    <div class="bg-primary/5 px-3 py-1.5 rounded-lg border border-primary/10">
                        <span class="text-[10px] text-primary font-black uppercase tracking-widest"><span x-text="totalPoints"></span> PTS</span>
                    </div>
                </div>
                
                <div class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar" id="questions-list">
                    <template x-for="(question, index) in quiz.questions" :key="index">
                        <div @click="activeQuestionIndex = index" 
                             :class="{'bg-[#f6f7fb] border-primary ring-2 ring-primary/5': activeQuestionIndex === index, 'bg-white border-slate-100 hover:border-slate-200': activeQuestionIndex !== index}"
                             class="flex flex-col gap-2 p-5 border rounded-[1.5rem] cursor-pointer transition-all group relative">
                            
                            <div class="flex justify-between items-start">
                                <span class="text-[9px] font-black uppercase tracking-[0.15em] px-2 py-0.5 rounded-md" 
                                      :class="activeQuestionIndex === index ? 'bg-primary text-white' : 'bg-slate-50 text-slate-400'">
                                    CH <span x-text="index + 1"></span> • <span x-text="question.points"></span> PTS
                                </span>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm text-slate-300 group-hover:text-primary cursor-move handle transition-colors">drag_indicator</span>
                                    <button @click.stop="deleteQuestion(index)" class="text-slate-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="material-symbols-outlined text-base">delete</span>
                                    </button>
                                </div>
                            </div>
                            
                            <p class="text-[13px] font-bold leading-relaxed text-slate-700 pr-4" x-text="question.question_text || 'Untitled Question'"></p>
                            
                            <div class="flex items-center gap-2 mt-1">
                                <span class="material-symbols-outlined text-xs text-slate-300" 
                                      :class="question.type === 'multiple_choice' ? 'text-blue-400' : 'text-amber-400'">
                                    <span x-text="question.type === 'multiple_choice' ? 'radio_button_checked' : 'notes'"></span>
                                </span>
                                <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest" x-text="question.type.replace('_', ' ')"></span>
                            </div>
                        </div>
                    </template>
                    
                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <button @click="addQuestion('multiple_choice')" class="flex flex-col items-center justify-center gap-3 p-5 border-2 border-dashed border-slate-100 rounded-2xl text-slate-400 hover:border-primary/40 hover:text-primary hover:bg-primary/5 transition-all group">
                            <div class="size-8 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-primary/10 transition-all">
                                <span class="material-symbols-outlined text-lg">radio_button_checked</span>
                            </div>
                            <span class="text-[9px] font-black uppercase tracking-widest">Multi Choice</span>
                        </button>
                        <button @click="addQuestion('open_ended')" class="flex flex-col items-center justify-center gap-3 p-5 border-2 border-dashed border-slate-100 rounded-2xl text-slate-400 hover:border-primary/40 hover:text-primary hover:bg-primary/5 transition-all group">
                            <div class="size-8 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-primary/10 transition-all">
                                <span class="material-symbols-outlined text-lg">notes</span>
                            </div>
                            <span class="text-[9px] font-black uppercase tracking-widest">Open Ended</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Editor Canvas - Redesigned Card Architecture -->
            <div x-show="view === 'build'" class="flex-1 bg-[#f8f9fb] overflow-y-auto p-10 custom-scrollbar" id="editor-canvas">
                <template x-if="quiz.questions.length > 0">
                    <div class="max-w-4xl mx-auto flex flex-col gap-10">
                        <!-- Breadcrumbs -->
                        <div class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">
                             <span class="hover:text-primary transition-colors cursor-pointer">Curriculum</span>
                             <span class="material-symbols-outlined text-sm">chevron_right</span>
                             <span class="text-slate-900">Assessment Editor</span>
                             <span class="material-symbols-outlined text-sm">chevron_right</span>
                             <span class="text-primary font-black">Question <span x-text="activeQuestionIndex + 1"></span></span>
                        </div>

                        <!-- Main Question Card -->
                        <div class="bg-white rounded-[2.5rem] shadow-sm border border-[#dcdfe5] p-12 transition-all hover:shadow-xl hover:shadow-primary/5">
                            <!-- Question Meta Header -->
                            <div class="flex items-center justify-between mb-12 pb-8 border-b border-slate-50">
                                <div class="flex items-center gap-6">
                                    <div class="bg-primary/5 text-primary p-4 rounded-2xl border border-primary/10">
                                        <span class="material-symbols-outlined text-3xl font-bold">dynamic_form</span>
                                    </div>
                                    <div>
                                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Component <span x-text="activeQuestionIndex + 1"></span></h2>
                                        <div class="flex items-center gap-4 mt-2">
                                            <div class="relative group">
                                                <select x-model="activeQuestion.type" class="text-[10px] font-black text-primary uppercase tracking-widest bg-primary/5 border-none rounded-xl py-2 pl-4 pr-10 focus:ring-4 focus:ring-primary/5 transition-all appearance-none cursor-pointer">
                                                    <option value="multiple_choice">MULTIPLE CHOICE</option>
                                                    <option value="open_ended">OPEN ENDED</option>
                                                </select>
                                                <span class="material-symbols-outlined absolute right-3 top-2 text-primary/40 text-sm pointer-events-none">expand_more</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-8 bg-[#f8f9fb] p-6 rounded-3xl border border-slate-100 shadow-inner">
                                    <div class="flex flex-col items-end">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 px-2">Weight Value</label>
                                        <div class="relative">
                                            <input x-model.number="activeQuestion.points" class="w-24 h-12 bg-white text-sm font-black border-none rounded-xl text-center focus:ring-4 focus:ring-primary/5 shadow-sm" type="number" min="0">
                                            <span class="absolute right-4 top-3.5 text-[10px] font-black text-slate-300 pointer-events-none">PTS</span>
                                        </div>
                                    </div>
                                    <div class="h-10 w-px bg-slate-200"></div>
                                    <div class="flex flex-col items-center">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Required</label>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" x-model="activeQuestion.is_required" class="sr-only peer">
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary shadow-inner"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Question Content -->
                            <div class="space-y-10">
                                <div class="space-y-4">
                                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] px-2 leading-none">Inquiry Statement</label>
                                    <textarea x-model="activeQuestion.question_text" class="w-full bg-[#f8f9fb] border-none rounded-3xl focus:ring-4 focus:ring-primary/5 text-base font-bold p-8 min-h-[140px] shadow-inner placeholder-slate-300 transition-all" placeholder="Formulate your inquiry assessment here..."></textarea>
                                </div>

                                <!-- Multiple Choice Options - Redesigned -->
                                <div x-show="activeQuestion.type === 'multiple_choice'" class="animate-in fade-in slide-in-from-bottom-4 duration-500">
                                    <div class="flex items-center justify-between mb-6 px-2">
                                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Response Permutations</label>
                                        <button @click="addOption()" class="h-10 px-6 bg-primary/5 text-primary text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-primary hover:text-white transition-all flex items-center gap-2">
                                            <span class="material-symbols-outlined text-sm font-bold">add</span>
                                            APPEND OPTION
                                        </button>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <template x-for="(option, optIndex) in activeQuestion.options" :key="optIndex">
                                            <div class="flex items-center gap-4 group transition-all">
                                                <div class="flex items-center justify-center p-2 cursor-pointer transition-transform hover:scale-110" @click="activeQuestion.correct_answer = optIndex">
                                                     <div class="size-8 rounded-xl border-2 flex items-center justify-center transition-all shadow-sm"
                                                          :class="activeQuestion.correct_answer === optIndex ? 'border-primary bg-primary shadow-primary/20' : 'border-slate-100 bg-slate-50 hover:border-primary/30'">
                                                          <span class="material-symbols-outlined text-white text-base font-black" x-show="activeQuestion.correct_answer === optIndex">check</span>
                                                     </div>
                                                </div>
                                                
                                                <div class="flex-1 relative">
                                                    <input type="text" x-model="activeQuestion.options[optIndex]" 
                                                           class="w-full text-sm font-black border-none bg-slate-50 rounded-2xl px-6 py-4 focus:ring-4 focus:ring-primary/5 shadow-inner transition-all hover:bg-[#f2f4f7]"
                                                           :class="{'ring-4 ring-primary/5 bg-white shadow-sm': activeQuestion.correct_answer === optIndex}"
                                                           placeholder="Definition of response...">
                                                </div>
                                                
                                                <button @click="removeOption(optIndex)" class="size-12 bg-red-50 text-red-400 rounded-2xl hover:bg-red-500 hover:text-white transition-all opacity-0 group-hover:opacity-100 flex items-center justify-center shadow-sm">
                                                    <span class="material-symbols-outlined text-lg">delete</span>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                    
                                    <div class="mt-8 p-4 bg-emerald-50/50 rounded-2xl border border-emerald-100/50 flex items-center gap-4">
                                        <div class="size-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center">
                                            <span class="material-symbols-outlined text-lg">info</span>
                                        </div>
                                        <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest italic leading-tight">
                                            Establish the canonical response by selecting the corresponding validation checkbox.
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Open Ended Settings - Redesigned -->
                                <div x-show="activeQuestion.type === 'open_ended'" class="animate-in fade-in slide-in-from-bottom-4 duration-500 bg-[#f8f9fb] p-8 rounded-[2rem] border border-slate-50 shadow-inner">
                                    <div class="flex items-center gap-3 mb-6">
                                        <span class="material-symbols-outlined text-primary text-xl">key_visualizer</span>
                                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Reference Canonical Response</label>
                                    </div>
                                    <textarea x-model="activeQuestion.correct_answer" class="w-full bg-white border-none rounded-2xl focus:ring-4 focus:ring-primary/5 text-sm font-bold p-6 h-32 shadow-sm placeholder-slate-300" placeholder="Specify the criteria for validation or key thematic anchor points for this assessment..."></textarea>
                                </div>
                            </div>
                            
                            <!-- Card Footer - Refined -->
                            <div class="mt-12 pt-10 border-t border-slate-50 flex justify-between items-center">
                                <button @click="deleteQuestion(activeQuestionIndex)" class="h-12 px-6 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all flex items-center gap-3 active:scale-95">
                                    <span class="material-symbols-outlined text-lg">delete_sweep</span>
                                    PURGE COMPONENT
                                </button>
                                <div class="flex gap-4">
                                    <button @click="duplicateQuestion(activeQuestionIndex)" class="h-12 px-8 border-2 border-slate-100 text-slate-400 hover:border-primary/20 hover:text-primary text-[10px] font-black uppercase tracking-widest rounded-xl transition-all active:scale-95">
                                        CLONE SOURCE
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Global Configuration Card - Redesigned -->
                        <div class="bg-white rounded-[2.5rem] shadow-sm border border-[#dcdfe5] p-10 hover:shadow-xl hover:shadow-primary/5 transition-all">
                            <div class="flex items-center gap-4 mb-8">
                                <div class="size-10 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center border border-amber-100">
                                    <span class="material-symbols-outlined text-xl">settings_input_component</span>
                                </div>
                                <div>
                                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-sm">Global Configuration</h3>
                                    <p class="text-[10px] font-bold text-slate-400 mt-0.5">Define universal threshold parameters for this assessment.</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-3">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-2">Compliance Threshold (%)</label>
                                    <div class="relative">
                                        <input type="number" x-model="quiz.passing_score" class="w-full h-14 bg-[#f8f9fb] border-none rounded-2xl focus:ring-4 focus:ring-primary/5 text-sm font-black px-8 transition-all">
                                        <span class="absolute right-6 top-4.5 text-[10px] font-black text-slate-300">THRESHOLD</span>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-2">Temporal Limit (Minutes)</label>
                                    <div class="relative group">
                                        <input type="number" x-model="quiz.time_limit" class="w-full h-14 bg-[#f8f9fb] border-none rounded-2xl focus:ring-4 focus:ring-primary/5 text-sm font-black px-8 transition-all" placeholder="INFINITE">
                                        <span class="material-symbols-outlined absolute right-6 top-4 text-slate-300 group-hover:text-amber-500 transition-colors">schedule</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                
                <!-- Empty State - Redesigned -->
                <template x-if="quiz.questions.length === 0">
                    <div class="flex flex-col items-center justify-center h-full text-center p-12">
                        <div class="size-48 bg-white border border-slate-100 shadow-2xl rounded-[3rem] flex items-center justify-center text-slate-200 mb-10 transition-transform hover:rotate-6 active:scale-95 cursor-pointer relative group">
                            <div class="absolute inset-0 bg-primary/5 rounded-[3rem] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <span class="material-symbols-outlined text-8xl font-light group-hover:text-primary/20 transition-colors">terminal</span>
                        </div>
                        <h3 class="text-3xl font-black text-slate-900 tracking-tight">Initiate Logic Sequence</h3>
                        <p class="text-slate-500 px-4 mt-4 max-w-sm font-medium leading-relaxed italic">"Let everything be done decently and in order." — 1 Corinthians 14:40</p>
                        <button @click="addQuestion()" class="mt-12 group relative inline-flex items-center justify-center px-10 py-5 font-black text-white transition-all duration-200 bg-primary rounded-[2rem] hover:ring-8 hover:ring-primary/10 active:scale-95 shadow-xl shadow-primary/20">
                            <span class="absolute right-0 flex h-full w-10 items-center justify-center transition-all duration-200 group-hover:w-full">
                                <span class="material-symbols-outlined text-2xl">rocket_launch</span>
                            </span>
                            <span class="relative w-full text-left transition-all duration-200 group-hover:opacity-0 uppercase tracking-widest text-xs">Bootstrap First Component</span>
                        </button>
                    </div>
                </template>
            </div>

            <!-- Preview Mode -->
            <div x-show="view === 'preview'" class="flex-1 bg-[#f8f9fb] overflow-y-auto p-10 custom-scrollbar" id="preview-canvas">
                <div class="max-w-3xl mx-auto space-y-10 py-10">
                    <div class="text-center space-y-4">
                        <h1 class="text-4xl font-black text-slate-900 tracking-tight" x-text="quiz.title"></h1>
                        <div class="flex items-center justify-center gap-6">
                            <span class="text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 px-4 py-2 rounded-xl border border-emerald-100">
                                Passing: <span x-text="quiz.passing_score"></span>%
                            </span>
                            <span class="text-[10px] font-black uppercase tracking-widest bg-blue-50 text-blue-600 px-4 py-2 rounded-xl border border-blue-100">
                                Time: <span x-text="quiz.time_limit ? quiz.time_limit + ' Min' : 'Unlimited'"></span>
                            </span>
                            <span class="text-[10px] font-black uppercase tracking-widest bg-primary/5 text-primary px-4 py-2 rounded-xl border border-primary/10">
                                <span x-text="quiz.questions.length"></span> Questions
                            </span>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <template x-for="(question, index) in quiz.questions" :key="index">
                            <div class="bg-white rounded-[2.5rem] border border-[#dcdfe5] shadow-sm p-10 hover:shadow-xl hover:shadow-primary/5 transition-all">
                                <div class="flex items-center gap-4 mb-6">
                                    <span class="size-10 bg-primary rounded-xl flex items-center justify-center text-white text-xs font-black shadow-lg shadow-primary/20" x-text="index + 1"></span>
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Question • <span x-text="question.points"></span> Points</span>
                                </div>
                                
                                <h3 class="text-xl font-bold text-slate-900 mb-8 leading-relaxed" x-text="question.question_text"></h3>

                                <!-- Multiple Choice Preview -->
                                <template x-if="question.type === 'multiple_choice'">
                                    <div class="grid grid-cols-1 gap-4">
                                        <template x-for="(option, optIndex) in question.options" :key="optIndex">
                                            <div @click="answers[index] = optIndex" 
                                                 class="group relative flex items-center gap-4 p-5 rounded-2xl border transition-all cursor-pointer"
                                                 :class="answers[index] === optIndex ? 'border-primary bg-primary/5' : 'border-slate-100 hover:border-primary/30 hover:bg-slate-50'">
                                                <div class="size-6 rounded-full border-2 flex items-center justify-center transition-all shadow-inner bg-white"
                                                     :class="answers[index] === optIndex ? 'border-primary' : 'border-slate-200 group-hover:border-primary'">
                                                    <div class="size-2.5 bg-primary rounded-full transition-opacity"
                                                         :class="answers[index] === optIndex ? 'opacity-100' : 'opacity-0 group-hover:opacity-30'"></div>
                                                </div>
                                                <span class="text-sm font-bold" :class="answers[index] === optIndex ? 'text-primary' : 'text-slate-700'" x-text="option"></span>
                                            </div>
                                        </template>
                                    </div>
                                </template>

                                <!-- Open Ended Preview -->
                                <template x-if="question.type === 'open_ended'">
                                    <div class="space-y-4">
                                        <textarea x-model="answers[index]" class="w-full h-32 bg-slate-50 border border-slate-100 rounded-2xl p-6 text-sm font-bold focus:ring-4 focus:ring-primary/5 transition-all" placeholder="Enter your response here..."></textarea>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>

                    <div class="flex justify-center pt-10">
                        <button @click="alert('Assessment Submitted! (Simulated Preview Result: Score depends on your answers)')" class="h-14 px-12 bg-primary text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-primary/20 hover:scale-105 transition-all flex items-center gap-3">
                            <span class="material-symbols-outlined text-xl">send</span>
                            Submit Assessment (Preview)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('quizBuilder', () => ({
            status: 'idle',
            view: 'build',
            activeQuestionIndex: 0,
            quiz: {
                id: {{ $quiz->id ?? 'null' }},
                title: '{{ $quiz->title ?? "Untitled Quiz" }}',
                course_id: {{ $selectedCourseId ?? 'null' }},
                lesson_id: {{ $selectedLessonId ?? 'null' }},
                passing_score: {{ $quiz->passing_score ?? 70 }},
                time_limit: {{ $quiz->time_limit ?? 'null' }},
                questions: @json($quiz->questions ?? [])
            },
            answers: {},
            
            init() {
                if (this.quiz.questions.length === 0) {
                    this.addQuestion();
                }
                
                // Initialize Sortable
                const el = document.getElementById('questions-list');
                Sortable.create(el, {
                    handle: '.handle',
                    animation: 150,
                    onEnd: (evt) => {
                        const item = this.quiz.questions.splice(evt.oldIndex, 1)[0];
                        this.quiz.questions.splice(evt.newIndex, 0, item);
                        this.activeQuestionIndex = evt.newIndex;
                    }
                });
            },
            
            get activeQuestion() {
                return this.quiz.questions[this.activeQuestionIndex];
            },
            
            get totalPoints() {
                return this.quiz.questions.reduce((sum, q) => sum + parseInt(q.points || 0), 0);
            },
            
            addQuestion(type = 'multiple_choice') {
                const newQuestion = {
                    question_text: 'New Question',
                    type: type,
                    points: type === 'multiple_choice' ? 5 : 10,
                    is_required: true,
                    options: type === 'multiple_choice' ? ['Option 1', 'Option 2'] : null,
                    correct_answer: type === 'multiple_choice' ? 0 : ''
                };
                this.quiz.questions.push(newQuestion);
                this.activeQuestionIndex = this.quiz.questions.length - 1;
                this.scrollToBottom();
            },
            
            duplicateQuestion(index) {
                const q = JSON.parse(JSON.stringify(this.quiz.questions[index]));
                this.quiz.questions.splice(index + 1, 0, q);
                this.activeQuestionIndex = index + 1;
            },
            
            deleteQuestion(index) {
                if (confirm('Delete this question?')) {
                    this.quiz.questions.splice(index, 1);
                    if (this.quiz.questions.length > 0) {
                        this.activeQuestionIndex = Math.max(0, index - 1);
                    }
                }
            },
            
            addOption() {
                if (!this.activeQuestion.options) this.activeQuestion.options = [];
                this.activeQuestion.options.push('New Option');
            },
            
            removeOption(index) {
                this.activeQuestion.options.splice(index, 1);
            },
            
            scrollToBottom() {
                this.$nextTick(() => {
                    const canvas = document.getElementById('editor-canvas');
                    canvas.scrollTop = canvas.scrollHeight;
                });
            },
            
            async saveQuiz(exit = false) {
                this.status = 'saving';
                
                const isEdit = this.quiz.id !== null;
                const url = isEdit 
                    ? '{{ route("instructor.quizzes.update", ":id") }}'.replace(':id', this.quiz.id)
                    : '{{ route("instructor.quizzes.store") }}';
                
                const method = isEdit ? 'PUT' : 'POST';

                try {
                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(this.quiz)
                    });
                    
                    if (response.ok) {
                        this.status = 'saved';
                        setTimeout(() => this.status = 'idle', 2000);
                        
                        if (exit) {
                            window.location.href = '{{ route("instructor.quizzes.index") }}';
                        } else if (!isEdit) {
                           const data = await response.json();
                           if (data.redirect) window.location.href = data.redirect;
                        }
                    } else {
                        // Handle non-JSON or error JSON
                        let errorMessage = 'Unknown error';
                        try {
                            const errorData = await response.json();
                            errorMessage = errorData.message || (errorData.errors ? Object.values(errorData.errors).flat().join(', ') : 'Server Error');
                        } catch (e) {
                            errorMessage = 'Server returned ' + response.status + ': ' + response.statusText;
                        }
                        alert('Error saving quiz: ' + errorMessage);
                        this.status = 'error';
                    }
                } catch (e) {
                    console.error('Fetch Error:', e);
                    alert('Request failed. Please check your connection or server logs.');
                    this.status = 'error';
                }
            }
        }));
    });
</script>
</body>
</html>
