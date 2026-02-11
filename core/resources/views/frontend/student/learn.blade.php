@extends('layouts.app')

@section('title', $course->title . ' | Lesson Player')

@push('styles')
<link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
<style>
    [x-cloak] { display: none !important; }
    
    .custom-player-bg {
        background: radial-gradient(circle at center, #1a1a1a 0%, #0a0a0a 100%);
    }
    
    .glass-nav {
        background: rgba(18, 18, 18, 0.8);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    
    .sidebar-scroll::-webkit-scrollbar {
        width: 4px;
    }
    .sidebar-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
    .sidebar-scroll::-webkit-scrollbar-thumb {
        background: #333;
        border-radius: 10px;
    }
    .sidebar-scroll::-webkit-scrollbar-thumb:hover {
        background: #f4c025;
    }
    
    .quiz-option-card {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .quiz-option-card:hover:not(.selected) {
        border-color: rgba(244, 192, 37, 0.3);
        background: rgba(244, 192, 37, 0.05);
    }
    .quiz-option-card.selected {
        border-color: #f4c025;
        background: rgba(244, 192, 37, 0.1);
    }
    
    .vjs-big-play-button {
        background-color: rgba(244, 192, 37, 0.9) !important;
        border-radius: 50% !important;
        width: 80px !important;
        height: 80px !important;
        line-height: 80px !important;
        border: none !important;
    }
    .video-js .vjs-play-progress {
        background-color: #f4c025 !important;
    }
    .video-js .vjs-slider-bar {
        background-color: #f4c025 !important;
    }
</style>
@endpush

@section('content')
<div class="h-screen flex flex-col overflow-hidden bg-[#0a0a0a] text-slate-100 font-display" 
     x-data="lessonPlayer()" 
     x-init="initPlayer()">
    
    <!-- Premium Top Navigation -->
    <header class="h-16 flex-shrink-0 flex items-center justify-between px-6 border-b border-white/5 glass-nav z-50">
        <div class="flex items-center gap-4">
            <a href="{{ route('student.dashboard') }}" class="p-2 hover:bg-white/5 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-slate-400">arrow_back</span>
            </a>
            <div class="h-8 w-px bg-white/10 mx-2"></div>
            <div>
                <h1 class="text-sm font-bold tracking-tight text-white">{{ $course->title }}</h1>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-0.5" x-text="currentLesson.title"></p>
            </div>
        </div>
        
        <div class="flex items-center gap-6">
            <div class="hidden md:flex flex-col items-end gap-1">
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-primary">Progress</span>
                    <span class="text-xs font-bold text-white">{{ round($course->progress ?? 0) }}%</span>
                </div>
                <div class="w-32 h-1 bg-white/10 rounded-full overflow-hidden">
                    <div class="h-full bg-primary" x-transition style="width: {{ $course->progress ?? 0 }}%;"></div>
                </div>
            </div>
            
            <div class="h-8 w-px bg-white/10 mx-2"></div>
            
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold text-white">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-500">Student Account</p>
                </div>
                <div class="size-9 rounded-full bg-primary/20 border border-primary/30 flex items-center justify-center overflow-hidden">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset(auth()->user()->avatar) }}" class="size-full object-cover">
                    @else
                        <span class="material-symbols-outlined text-primary text-xl">person</span>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 flex overflow-hidden">
        <!-- Center Content Area -->
        <div class="flex-1 flex flex-col overflow-y-auto custom-player-bg relative">
            
            <!-- Player/Quiz Section -->
            <div class="w-full relative group">
                <div class="aspect-video w-full max-h-[70vh] bg-black shadow-2xl overflow-hidden relative">
                    
                    <!-- Video Embed Case -->
                    <template x-if="currentLesson.type === 'video' && !isQuiz">
                        <div class="w-full h-full">
                            <template x-if="isVideoUrl(currentLesson.video_url)">
                                <div class="w-full h-full bg-zinc-900 flex items-center justify-center relative">
                                    <template x-if="isYoutube(currentLesson.video_url)">
                                        <iframe class="w-full h-full" :src="getYoutubeUrl(currentLesson.video_url)" frameborder="0" allowfullscreen></iframe>
                                    </template>
                                    <template x-if="!isYoutube(currentLesson.video_url)">
                                        <video id="main-lesson-player" class="video-js vjs-big-play-centered" controls preload="auto" width="640" height="264" style="width:100%; height:100%">
                                            <source :src="currentLesson.video_url" type="video/mp4" />
                                        </video>
                                    </template>
                                </div>
                            </template>
                            <template x-if="!isVideoUrl(currentLesson.video_url)">
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-500 gap-4">
                                    <span class="material-symbols-outlined text-6xl opacity-20">video_library</span>
                                    <p class="text-sm font-bold uppercase tracking-widest">No video source provided</p>
                                </div>
                            </template>
                        </div>
                    </template>

                    <!-- Quiz UI Case -->
                    <template x-if="isQuiz">
                        <div class="w-full h-full flex items-center justify-center p-8 overflow-y-auto" x-data="quizHandler(currentLesson)">
                            <div class="w-full max-w-2xl bg-[#1e1e1e] border border-white/5 rounded-3xl p-8 shadow-2xl">
                                
                                <!-- Quiz Intro -->
                                <div x-show="step === 'intro'" class="text-center py-8">
                                    <div class="size-20 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto mb-6">
                                        <span class="material-symbols-outlined text-4xl">quiz</span>
                                    </div>
                                    <h2 class="text-2xl font-black text-white mb-2" x-text="quizData.title || 'Knowledge Assessment'"></h2>
                                    <p class="text-slate-400 mb-8 max-w-md mx-auto">This quiz covers core concepts from this lesson. You need <span class="text-white font-bold" x-text="quizData.passing_score"></span>% to pass.</p>
                                    
                                    <div class="grid grid-cols-2 gap-4 mb-8">
                                        <div class="p-4 bg-white/5 rounded-2xl border border-white/5">
                                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Total Questions</p>
                                            <p class="text-xl font-black text-white" x-text="quizData.questions.length"></p>
                                        </div>
                                        <div class="p-4 bg-white/5 rounded-2xl border border-white/5">
                                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Previous Best</p>
                                            <p class="text-xl font-black text-white" x-text="previousResult ? previousResult.score + '%' : 'N/A'"></p>
                                        </div>
                                    </div>
                                    
                                    <button @click="startQuiz()" class="px-8 py-3 bg-primary text-black font-black rounded-xl hover:opacity-90 transition-all">
                                        Start Assessment
                                    </button>
                                </div>

                                <!-- Quiz Questions -->
                                <div x-show="step === 'active'" class="space-y-6">
                                    <!-- Error state if no questions -->
                                    <template x-if="!quizData.questions || quizData.questions.length === 0">
                                        <div class="text-center py-12">
                                            <div class="size-20 bg-amber-500/10 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-6">
                                                <span class="material-symbols-outlined text-4xl">error</span>
                                            </div>
                                            <h3 class="text-xl font-black text-white mb-2">No Questions Available</h3>
                                            <p class="text-slate-400 mb-8">This quiz hasn't been set up yet. Please contact your instructor.</p>
                                            <button @click="step = 'intro'" class="px-6 py-3 bg-white/10 text-white font-bold rounded-xl hover:bg-white/20 transition-colors">
                                                Go Back
                                            </button>
                                        </div>
                                    </template>
                                    
                                    <!-- Questions UI -->
                                    <template x-if="quizData.questions && quizData.questions.length > 0 && quizData.questions[currentQuestionIndex]">
                                    <div class="flex items-center justify-between mb-8">
                                        <span class="text-[10px] font-bold text-primary uppercase tracking-widest" 
                                              x-text="'Question ' + (currentQuestionIndex + 1) + ' of ' + quizData.questions.length"></span>
                                        <div class="flex gap-1">
                                            <template x-for="(q, i) in quizData.questions" :key="i">
                                                <div class="w-8 h-1 rounded-full transition-colors" 
                                                     :class="i === currentQuestionIndex ? 'bg-primary' : (answers[i] !== undefined ? 'bg-white/40' : 'bg-white/10')"></div>
                                            </template>
                                        </div>
                                    </div>

                                    <h3 class="text-lg font-bold text-white mb-6 leading-relaxed" x-text="quizData.questions[currentQuestionIndex].question"></h3>

                                    <div class="grid gap-3">
                                        <template x-for="(option, idx) in quizData.questions[currentQuestionIndex].options" :key="idx">
                                            <button @click="selectOption(idx)" 
                                                    class="quiz-option-card flex items-center justify-between p-4 rounded-2xl border border-white/5 text-left group transition-all"
                                                    :class="{ 'selected': answers[currentQuestionIndex] === idx }">
                                                <div class="flex items-center gap-4">
                                                    <div class="size-6 rounded-full border border-white/20 flex items-center justify-center text-[10px] font-bold text-slate-400 group-hover:border-primary/50 transition-colors"
                                                         :class="{ 'bg-primary border-primary text-black': answers[currentQuestionIndex] === idx }">
                                                        <span x-text="String.fromCharCode(65 + idx)"></span>
                                                    </div>
                                                    <span class="text-sm font-medium" :class="answers[currentQuestionIndex] === idx ? 'text-white' : 'text-slate-400'" x-text="option"></span>
                                                </div>
                                                <span x-show="answers[currentQuestionIndex] === idx" class="material-symbols-outlined text-primary text-lg">check_circle</span>
                                            </button>
                                        </template>
                                    </div>

                                    <div class="flex items-center justify-between mt-10 pt-6 border-t border-white/5">
                                        <button @click="currentQuestionIndex--" 
                                                class="px-5 py-2 rounded-xl text-xs font-bold text-slate-500 hover:text-white transition-colors"
                                                :disabled="currentQuestionIndex === 0"
                                                :class="{ 'opacity-0': currentQuestionIndex === 0 }">
                                            Previous
                                        </button>
                                        
                                        <template x-if="currentQuestionIndex < quizData.questions.length - 1">
                                            <button @click="currentQuestionIndex++" 
                                                    class="px-6 py-2 bg-white/10 text-white text-xs font-bold rounded-xl hover:bg-white/20 transition-colors"
                                                    :disabled="answers[currentQuestionIndex] === undefined">
                                                Next Question
                                            </button>
                                        </template>
                                        
                                        <template x-if="currentQuestionIndex === quizData.questions.length - 1">
                                            <button @click="submitQuiz()" 
                                                    class="px-8 py-2 bg-primary text-black text-xs font-black rounded-xl hover:opacity-90 transition-all shadow-lg shadow-primary/10"
                                                    x-text="loading ? 'Submitting...' : 'Finish Assessment'">
                                            </button>
                                        </template>
                                    </div>
                                    </template>
                                </div>

                                <!-- Quiz Results -->
                                <div x-show="step === 'results'" class="text-center py-8">
                                    <div class="size-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-2xl"
                                         :class="lastSubmission.passed ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500'">
                                        <span class="material-symbols-outlined text-4xl" x-text="lastSubmission.passed ? 'celebration' : 'refresh'"></span>
                                    </div>
                                    <h2 class="text-3xl font-black text-white mb-2" x-text="lastSubmission.passed ? 'Congratulations!' : 'Keep Practicing'"></h2>
                                    <p class="text-slate-400 mb-8" x-text="lastSubmission.passed ? 'You have successfully completed this assessment.' : 'You didn\'t reach the passing score yet.'"></p>
                                    
                                    <div class="flex items-center justify-center gap-12 mb-10">
                                        <div class="flex flex-col items-center">
                                            <p class="text-4xl font-black text-white" x-text="lastSubmission.score + '%'"></p>
                                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-1">Your Score</p>
                                        </div>
                                        <div class="h-10 w-px bg-white/10"></div>
                                        <div class="flex flex-col items-center">
                                            <p class="text-4xl font-black text-slate-400" x-text="quizData.passing_score + '%'"></p>
                                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-1">Required</p>
                                        </div>
                                    </div>

                                    <div class="flex flex-col gap-3">
                                        <button @click="resetQuiz()" class="w-full py-3 bg-white/5 border border-white/10 text-xs font-bold rounded-xl hover:bg-white/10 transition-colors">
                                            Re-attempt Quiz
                                        </button>
                                        <button @click="$dispatch('next-lesson')" x-show="lastSubmission.passed" class="w-full py-3 bg-primary text-black font-black text-xs rounded-xl hover:opacity-90 transition-all">
                                            Continue to Next Lesson
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Content Area Below Player -->
            <div class="flex-1 flex flex-col">
                <div class="border-b border-white/5 glass-nav px-8 sticky top-0 z-20">
                    <nav class="flex gap-10">
                        <button @click="tab = 'overview'" 
                                class="py-5 border-b-2 text-xs font-black transition-all flex items-center gap-2"
                                :class="tab === 'overview' ? 'border-primary text-primary' : 'border-transparent text-slate-500 hover:text-white'">
                            <span class="material-symbols-outlined text-lg">subject</span>
                            OVERVIEW
                        </button>
                        <button @click="tab = 'notes'" 
                                class="py-5 border-b-2 text-xs font-black transition-all flex items-center gap-2"
                                :class="tab === 'notes' ? 'border-primary text-primary' : 'border-transparent text-slate-500 hover:text-white'">
                            <span class="material-symbols-outlined text-lg">edit_note</span>
                            MY REFLECTIONS
                        </button>
                        <button @click="tab = 'resources'" 
                                class="py-5 border-b-2 text-xs font-black transition-all flex items-center gap-2"
                                :class="tab === 'resources' ? 'border-primary text-primary' : 'border-transparent text-slate-500 hover:text-white'">
                            <span class="material-symbols-outlined text-lg">attachment</span>
                            RESOURCES
                        </button>
                    </nav>
                </div>

                <div class="p-8 pb-32 max-w-5xl mx-auto w-full">
                    
                    <!-- Overview Tab -->
                    <div x-show="tab === 'overview'" x-transition>
                        <div class="mb-10">
                            <h2 class="text-3xl font-black text-white mb-4 leading-tight tracking-tight" x-text="currentLesson.title"></h2>
                            <div class="flex items-center gap-4 text-xs font-bold text-slate-400">
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-sm text-primary">schedule</span>
                                    <span>24 MINS</span>
                                </div>
                                <div class="size-1 bg-white/20 rounded-full"></div>
                                <div class="flex items-center gap-1.5 uppercase tracking-widest">
                                    <span class="material-symbols-outlined text-sm text-primary" x-text="getIcon(currentLesson.type)"></span>
                                    <span x-text="currentLesson.type"></span>
                                </div>
                            </div>
                        </div>

                        <div class="prose prose-invert max-w-none text-slate-400 leading-relaxed font-serif text-lg">
                            <div x-html="currentLesson.content || '<p class=\'italic text-slate-600\'>No description provided for this lesson.</p>'"></div>
                        </div>

                        <!-- Author Section -->
                        <div class="mt-16 pt-10 border-t border-white/5 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="size-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center overflow-hidden">
                                    @if($course->instructor->avatar)
                                        <img src="{{ asset($course->instructor->avatar) }}" class="size-full object-cover">
                                    @else
                                        <span class="material-symbols-outlined text-primary text-2xl">account_circle</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-black text-white">{{ $course->instructor->name }}</p>
                                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Course Instructor</p>
                                </div>
                            </div>
                            <a href="{{ route('instructor.profile', $course->instructor->id) }}" class="px-5 py-2.5 rounded-xl border border-white/10 text-xs font-bold text-white hover:bg-white/5 transition-colors">
                                View Profile
                            </a>
                        </div>
                    </div>

                    <!-- Notes Tab -->
                    <div x-show="tab === 'notes'" x-transition x-cloak>
                        <div class="bg-[#1e1e1e] border border-white/5 rounded-3xl p-8 min-h-[400px]">
                            <h3 class="text-lg font-bold text-white mb-6">Personal Reflection Journal</h3>
                            <textarea class="w-full h-80 bg-transparent border-none focus:ring-0 text-slate-300 font-serif text-xl leading-relaxed outline-none resize-none" 
                                      placeholder="Start writing your thoughts here..."></textarea>
                            <div class="flex justify-end mt-4">
                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest flex items-center gap-2">
                                    <span class="size-1.5 rounded-full bg-green-500"></span>
                                    Auto-saved locally
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Resources Tab -->
                    <div x-show="tab === 'resources'" x-transition x-cloak>
                        <template x-if="currentLesson.resources && currentLesson.resources.length > 0">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <template x-for="resource in currentLesson.resources" :key="resource.id">
                                    <a :href="resource.file_path" download 
                                       class="p-4 bg-[#1e1e1e] border border-white/5 rounded-2xl flex items-center gap-4 group hover:border-primary/30 transition-all cursor-pointer">
                                        <div class="size-12 bg-red-500/10 text-red-500 rounded-xl flex items-center justify-center group-hover:bg-red-500/20">
                                            <span class="material-symbols-outlined text-2xl">picture_as_pdf</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-black text-white truncate" x-text="resource.title"></p>
                                            <p class="text-[10px] font-bold text-slate-500 uppercase mt-0.5" x-text="resource.file_type + ' • ' + resource.file_size"></p>
                                        </div>
                                        <span class="material-symbols-outlined text-slate-600 group-hover:text-primary">download</span>
                                    </a>
                                </template>
                            </div>
                        </template>
                        
                        <template x-if="!currentLesson.resources || currentLesson.resources.length === 0">
                            <div class="text-center py-20">
                                <div class="size-16 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="material-symbols-outlined text-slate-600 text-3xl">folder_open</span>
                                </div>
                                <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">No Resources Available</p>
                                <p class="text-xs text-slate-600 mt-2">Check back later for downloadable materials</p>
                            </div>
                        </template>
                    </div>

                </div>
            </div>

            <!-- Sticky Footer Actions -->
            <footer class="mt-auto border-t border-white/5 glass-nav px-8 py-5 flex items-center justify-between z-30">
                <button @click="previousLesson()" 
                        class="flex items-center gap-2 text-xs font-black text-slate-500 hover:text-white transition-all group"
                        :disabled="isFirstLesson"
                        :class="isFirstLesson ? 'opacity-20 cursor-not-allowed' : ''">
                    <span class="material-symbols-outlined text-icon group-hover:-translate-x-1 transition-transform">arrow_back_ios</span>
                    PREVIOUS LESSON
                </button>
                
                <div class="flex items-center gap-4">
                    <button class="px-6 h-11 bg-white/5 border border-white/10 text-xs font-bold text-slate-300 rounded-xl hover:bg-white/10 transition-colors uppercase tracking-widest">
                        Discussion
                    </button>
                    <button @click="nextLesson()" 
                            class="px-8 h-11 bg-primary text-black text-xs font-black rounded-xl hover:opacity-90 transition-all shadow-lg shadow-primary/10 flex items-center gap-2 group">
                        <span x-text="isLastLesson ? 'FINISH COURSE' : 'NEXT LESSON'"></span>
                        <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward_ios</span>
                    </button>
                </div>
            </footer>

        </div>

        <!-- Right Curriculum Sidebar (Desktop) -->
        <aside class="w-96 flex-shrink-0 border-l border-white/5 bg-[#121212] flex flex-col hidden lg:flex">
            <div class="p-6 border-b border-white/5">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3">Course Curriculum</p>
                <div class="flex items-center justify-between bg-white/5 p-3 rounded-xl border border-white/5">
                    <div class="flex-1">
                        <div class="flex items-center justify-between text-[10px] font-bold text-white mb-2">
                            <span>COURSE PROGRESS</span>
                            <span>{{ round($course->progress ?? 0) }}%</span>
                        </div>
                        <div class="h-1 bg-white/10 rounded-full overflow-hidden">
                            <div class="h-full bg-primary" style="width: {{ $course->progress ?? 0 }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto sidebar-scroll">
                @foreach($course->modules as $module)
                <div class="border-b border-white/5">
                    <div class="p-5 flex items-center justify-between cursor-pointer hover:bg-white/5 transition-colors group">
                        <div class="flex items-center gap-3">
                            <span class="text-[10px] font-black text-primary bg-primary/10 size-6 rounded flex items-center justify-center">0{{ $loop->iteration }}</span>
                            <span class="text-xs font-black text-slate-300 uppercase tracking-widest">{{ $module->title }}</span>
                        </div>
                        <span class="material-symbols-outlined text-slate-600 text-sm">expand_more</span>
                    </div>
                    
                    <div class="flex flex-col">
                        @foreach($module->lessons as $lesson)
                        <button @click="switchLesson({{ $lesson->id }})" 
                                class="flex items-start gap-4 px-6 py-5 border-l-4 transition-all text-left"
                                :class="currentLesson.id === {{ $lesson->id }} ? 'bg-primary/5 border-primary' : 'border-transparent hover:bg-white/5'">
                            
                            <div class="mt-0.5">
                                <template x-if="results[{{ $lesson->id }}] && results[{{ $lesson->id }}].passed">
                                    <span class="material-symbols-outlined text-primary text-xl filled-icon">check_circle</span>
                                </template>
                                <template x-if="!(results[{{ $lesson->id }}] && results[{{ $lesson->id }}].passed)">
                                    <span class="material-symbols-outlined text-slate-700 text-xl" 
                                          :class="currentLesson.id === {{ $lesson->id }} ? 'text-primary' : ''"
                                          x-text="getIcon('{{ $lesson->type }}')"></span>
                                </template>
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold leading-tight truncate mb-1" 
                                   :class="currentLesson.id === {{ $lesson->id }} ? 'text-white' : 'text-slate-400'"
                                   x-text="'{{ $lesson->title }}'"></p>
                                <div class="flex items-center gap-2">
                                    <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">{{ $lesson->type }}</span>
                                    <template x-if="results[{{ $lesson->id }}]">
                                        <span class="text-[9px] font-bold text-primary bg-primary/10 px-1.5 py-0.5 rounded" x-text="results[{{ $lesson->id }}].score + '% SCALED'"></span>
                                    </template>
                                </div>
                            </div>
                        </button>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </aside>

    </main>

    <!-- Modal for Finish Celebrate (Hidden initially) -->
</div>
@endsection

@push('scripts')
<script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
<script>
    function lessonPlayer() {
        return {
            tab: 'overview',
            course: @json($course),
            results: @json($quizResults),
            currentLessonId: null,
            currentLesson: {},
            isFirstLesson: false,
            isLastLesson: false,
            isQuiz: false,
            lessonsMap: [],
            
            initPlayer() {
                // Flatten lessons for easier navigation
                this.lessonsMap = [];
                this.course.modules.forEach(m => {
                    m.lessons.forEach(l => this.lessonsMap.push(l));
                });
                
                // Check if a specific lesson ID was passed
                const activeLessonId = {{ $activeLessonId ?? 'null' }};
                
                // Start with specified lesson or first lesson
                if(activeLessonId && this.lessonsMap.find(l => l.id === activeLessonId)) {
                    this.switchLesson(activeLessonId);
                } else if(this.lessonsMap.length > 0) {
                    this.switchLesson(this.lessonsMap[0].id);
                }
            },
            
            switchLesson(lessonId) {
                const lesson = this.lessonsMap.find(l => l.id === lessonId);
                if(!lesson) return;
                
                this.currentLessonId = lessonId;
                this.currentLesson = lesson;
                this.isFirstLesson = this.lessonsMap[0].id === lessonId;
                this.isLastLesson = this.lessonsMap[this.lessonsMap.length - 1].id === lessonId;
                this.isQuiz = lesson.type === 'quiz';
                
                // Update scroll
                window.scrollTo({ top: 0, behavior: 'smooth' });
            },
            
            nextLesson() {
                const idx = this.lessonsMap.findIndex(l => l.id === this.currentLessonId);
                if(idx < this.lessonsMap.length - 1) {
                    this.switchLesson(this.lessonsMap[idx + 1].id);
                }
            },
            
            previousLesson() {
                const idx = this.lessonsMap.findIndex(l => l.id === this.currentLessonId);
                if(idx > 0) {
                    this.switchLesson(this.lessonsMap[idx - 1].id);
                }
            },
            
            getIcon(type) {
                switch(type) {
                    case 'video': return 'play_circle';
                    case 'quiz': return 'quiz';
                    case 'live_stream': return 'sensors';
                    case 'audio': return 'headset';
                    default: return 'description';
                }
            },
            
            isVideoUrl(url) {
                return url && url.length > 5;
            },
            
            isYoutube(url) {
                return url.includes('youtube.com') || url.includes('youtu.be');
            },
            
            getYoutubeUrl(url) {
                const videoId = url.includes('v=') ? url.split('v=')[1].split('&')[0] : url.split('/').pop();
                return `https://www.youtube.com/embed/${videoId}?autoplay=1`;
            }
        }
    }

    function quizHandler(lesson) {
        return {
            step: 'intro',
            quizData: {},
            currentQuestionIndex: 0,
            answers: {},
            loading: false,
            lastSubmission: {},
            previousResult: null,
            
            init() {
                try {
                    this.quizData = JSON.parse(lesson.content);
                    if(!this.quizData.questions) this.quizData.questions = [];
                } catch(e) {
                    this.quizData = { questions: [], passing_score: 70 };
                }
                
                // Get previous result from parent scope
                this.previousResult = this.$data.results[lesson.id] || null;
            },
            
            startQuiz() {
                this.step = 'active';
            },
            
            selectOption(idx) {
                this.answers[this.currentQuestionIndex] = idx;
            },
            
            async submitQuiz() {
                if(this.loading) return;
                this.loading = true;
                
                try {
                    const response = await fetch(`/lesson/${lesson.id}/quiz-submit`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ answers: this.answers })
                    });
                    
                    const data = await response.json();
                    if(data.success) {
                        this.lastSubmission = data;
                        this.step = 'results';
                        // Update parent state
                        this.$data.results[lesson.id] = {
                            score: data.score,
                            passed: data.passed
                        };
                    }
                } catch(e) {
                    console.error('Quiz submission failed', e);
                    alert('Submission failed. Please check your connection.');
                } finally {
                    this.loading = false;
                }
            },
            
            resetQuiz() {
                this.step = 'intro';
                this.currentQuestionIndex = 0;
                this.answers = {};
            }
        }
    }
</script>
@endpush
