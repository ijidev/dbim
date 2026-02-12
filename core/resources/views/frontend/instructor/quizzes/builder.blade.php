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
                        "primary": "#1754cf",
                        "background-light": "#f6f6f8",
                        "background-dark": "#111621",
                    },
                    fontFamily: {
                        "display": ["Lexend", "sans-serif"],
                        "body": ["Inter", "sans-serif"]
                    },
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Lexend', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .fill-icon { font-variation-settings: 'FILL' 1; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-background-light text-slate-900 overflow-hidden" x-data="quizBuilder()">

<div class="flex h-screen overflow-hidden">
    <!-- Side Navigation Bar (Matches Stitch Design) -->
    <aside class="w-64 flex-shrink-0 bg-white border-r border-slate-200 flex flex-col z-20">
        <div class="p-6 flex flex-col gap-6">
            <div class="flex gap-3 items-center">
                <div class="bg-primary rounded-lg size-10 flex items-center justify-center text-white">
                    <span class="material-symbols-outlined">church</span>
                </div>
                <div class="flex flex-col">
                    <h1 class="text-slate-900 text-sm font-bold leading-none">{{ config('app.name') }}</h1>
                    <p class="text-slate-500 text-xs mt-1">Instructor Panel</p>
                </div>
            </div>
            
            <nav class="flex flex-col gap-1">
                <a href="{{ route('instructor.dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-slate-500 hover:bg-slate-50 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-xl">dashboard</span>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
                <a href="{{ route('instructor.courses.index') }}" class="flex items-center gap-3 px-3 py-2 text-slate-500 hover:bg-slate-50 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-xl">book_2</span>
                    <span class="text-sm font-medium">Courses</span>
                </a>
                <a href="{{ route('instructor.quizzes.index') }}" class="flex items-center gap-3 px-3 py-2 bg-primary/10 text-primary rounded-lg font-bold">
                    <span class="material-symbols-outlined fill-icon text-xl">quiz</span>
                    <span class="text-sm">Quiz Builder</span>
                </a>
                 <a href="{{ route('instructor.students.index') }}" class="flex items-center gap-3 px-3 py-2 text-slate-500 hover:bg-slate-50 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-xl">group</span>
                    <span class="text-sm font-medium">Students</span>
                </a>
            </nav>
        </div>
        
        <div class="mt-auto p-4 border-t border-slate-200">
            <div class="flex items-center gap-3">
                <div class="size-8 rounded-full bg-slate-200 bg-cover bg-center" style="background-image: url('{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}')"></div>
                <div class="flex flex-col">
                    <p class="text-xs font-bold text-slate-900">{{ Auth::user()->name }}</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-[10px] text-slate-500 hover:text-red-500">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col overflow-hidden relative">
        <!-- Top Nav Bar -->
        <header class="h-16 flex items-center justify-between px-8 bg-white border-b border-slate-200 z-10">
            <div class="flex items-center gap-4">
                <a href="{{ route('instructor.quizzes.index') }}" class="material-symbols-outlined text-slate-400 hover:text-primary transition-colors">arrow_back</a>
                <div class="h-8 w-px bg-slate-200"></div>
                <input type="text" x-model="quiz.title" class="text-lg font-bold tracking-tight border-none focus:ring-0 p-0 placeholder-slate-400 w-96" placeholder="Untitled Quiz">
            </div>
            
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 mr-4">
                     <span class="text-xs font-bold text-slate-500 uppercase">Saving...</span>
                     <template x-if="status === 'saved'">
                        <span class="material-symbols-outlined text-emerald-500 text-lg">check_circle</span>
                     </template>
                </div>
                
                <div class="flex items-center bg-slate-100 p-1 rounded-lg">
                    <button class="px-3 py-1 text-xs font-bold rounded-md bg-white shadow-sm text-slate-900">Edit</button>
                    <button class="px-3 py-1 text-xs font-bold text-slate-500 hover:text-slate-900">Preview</button>
                </div>
                
                <div class="h-6 w-px bg-slate-200 mx-2"></div>
                
                <button @click="saveQuiz(true)" class="px-4 py-2 bg-primary text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">save</span>
                    Save & Exit
                </button>
            </div>
        </header>

        <div class="flex-1 flex overflow-hidden">
            <!-- Questions List Sidebar -->
            <div class="w-80 flex-shrink-0 bg-white border-r border-slate-200 flex flex-col">
                <div class="p-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
                    <h3 class="font-bold text-sm text-slate-700">Questions (<span x-text="quiz.questions.length"></span>)</h3>
                    <span class="text-xs text-primary font-bold">Total: <span x-text="totalPoints"></span> pts</span>
                </div>
                
                <div class="flex-1 overflow-y-auto p-4 space-y-2" id="questions-list">
                    <template x-for="(question, index) in quiz.questions" :key="index">
                        <div @click="activeQuestionIndex = index" 
                             :class="{'bg-primary/5 border-primary/30 ring-1 ring-primary/20': activeQuestionIndex === index, 'bg-white border-slate-200 hover:border-slate-300': activeQuestionIndex !== index}"
                             class="flex flex-col gap-1 p-3 border rounded-xl cursor-pointer transition-all group relative">
                            
                            <div class="flex justify-between items-start">
                                <span class="text-[10px] font-bold uppercase tracking-wider" 
                                      :class="activeQuestionIndex === index ? 'text-primary' : 'text-slate-500'">
                                    Question <span x-text="index + 1"></span> • <span x-text="question.points"></span> pts
                                </span>
                                <span class="material-symbols-outlined text-sm text-slate-300 group-hover:text-slate-400 cursor-move handle">drag_indicator</span>
                            </div>
                            
                            <p class="text-sm font-medium line-clamp-2 text-slate-700" x-text="question.text || 'New Question'"></p>
                            
                            <button @click.stop="deleteQuestion(index)" class="absolute right-2 bottom-2 text-slate-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity">
                                <span class="material-symbols-outlined text-lg">delete</span>
                            </button>
                        </div>
                    </template>
                    
                    <button @click="addQuestion()" class="w-full py-4 border-2 border-dashed border-slate-200 rounded-xl text-slate-400 hover:border-primary/50 hover:text-primary hover:bg-primary/5 transition-all flex flex-col items-center gap-1 mt-4">
                        <span class="material-symbols-outlined">add_circle</span>
                        <span class="text-xs font-bold">Add Question</span>
                    </button>
                </div>
            </div>

            <!-- Editor Canvas -->
            <div class="flex-1 bg-background-light overflow-y-auto p-8" id="editor-canvas">
                <template x-if="quiz.questions.length > 0">
                    <div class="max-w-3xl mx-auto flex flex-col gap-6">
                        <!-- Breadcrumbs -->
                        <div class="flex items-center gap-2 text-xs text-slate-500 mb-2">
                             <span>{{ $selectedCourse->title ?? 'Select Course' }}</span>
                             <span class="material-symbols-outlined text-sm">chevron_right</span>
                             <span class="text-slate-900 font-bold">Question <span x-text="activeQuestionIndex + 1"></span> Editor</span>
                        </div>

                        <!-- Main Question Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 transition-all">
                            <!-- Question Meta Header -->
                            <div class="flex items-center justify-between mb-8 pb-6 border-b border-slate-100">
                                <div class="flex items-center gap-4">
                                    <div class="bg-primary/10 text-primary p-2.5 rounded-lg">
                                        <span class="material-symbols-outlined">quiz</span>
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-bold text-slate-900">Question <span x-text="activeQuestionIndex + 1"></span></h2>
                                        <div class="flex items-center gap-4 mt-2">
                                            <select x-model="activeQuestion.type" class="text-xs font-bold text-slate-600 bg-slate-50 border-none rounded-md py-1 pl-2 pr-8 focus:ring-primary">
                                                <option value="multiple_choice">Multiple Choice</option>
                                                <option value="open_ended">Open Ended</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-6 bg-slate-50 p-3 rounded-lg border border-slate-100">
                                    <div class="flex flex-col items-end">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Points</label>
                                        <input x-model.number="activeQuestion.points" class="w-16 h-8 text-sm font-bold border-slate-200 rounded-md text-center focus:ring-primary focus:border-primary" type="number" min="0">
                                    </div>
                                    <div class="h-8 w-px bg-slate-200"></div>
                                    <div class="flex flex-col items-end">
                                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Required</label>
                                        <input type="checkbox" x-model="activeQuestion.required" class="rounded text-primary focus:ring-primary h-5 w-5 border-slate-300">
                                    </div>
                                </div>
                            </div>

                            <!-- Question Content -->
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Question Text</label>
                                    <textarea x-model="activeQuestion.text" class="w-full border-slate-200 rounded-lg focus:ring-primary focus:border-primary text-sm p-4 min-h-[100px] shadow-sm" placeholder="Enter your question here..."></textarea>
                                </div>

                                <!-- Multiple Choice Options -->
                                <div x-show="activeQuestion.type === 'multiple_choice'" class="animate-fade-in">
                                    <div class="flex items-center justify-between mb-4">
                                        <label class="block text-sm font-bold text-slate-700">Answer Options</label>
                                        <button @click="addOption()" class="text-xs font-bold text-primary flex items-center gap-1 hover:bg-primary/5 px-2 py-1 rounded-md transition-colors">
                                            <span class="material-symbols-outlined text-sm">add</span>
                                            Add Option
                                        </button>
                                    </div>
                                    
                                    <div class="space-y-3">
                                        <template x-for="(option, optIndex) in activeQuestion.options" :key="optIndex">
                                            <div class="flex items-center gap-3 group relative">
                                                <div class="flex items-center justify-center p-2 cursor-pointer" @click="activeQuestion.correct_answer = optIndex">
                                                     <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all"
                                                          :class="activeQuestion.correct_answer === optIndex ? 'border-primary bg-primary' : 'border-slate-300 hover:border-primary'">
                                                          <span class="material-symbols-outlined text-white text-[14px]" x-show="activeQuestion.correct_answer === optIndex">check</span>
                                                     </div>
                                                </div>
                                                
                                                <div class="flex-1 relative">
                                                    <input type="text" x-model="activeQuestion.options[optIndex]" 
                                                           class="w-full text-sm border-slate-200 rounded-lg px-4 py-2.5 focus:ring-primary focus:border-primary shadow-sm"
                                                           :class="{'ring-2 ring-primary/20 border-primary': activeQuestion.correct_answer === optIndex}"
                                                           placeholder="Answer option...">
                                                </div>
                                                
                                                <button @click="removeOption(optIndex)" class="text-slate-300 hover:text-red-500 p-2 rounded-full hover:bg-red-50 transition-all opacity-0 group-hover:opacity-100">
                                                    <span class="material-symbols-outlined text-xl">delete</span>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                    
                                    <p class="text-xs text-slate-400 mt-3 italic flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">info</span>
                                        Click the circle to mark the correct answer.
                                    </p>
                                </div>
                                
                                <!-- Open Ended Settings -->
                                <div x-show="activeQuestion.type === 'open_ended'" class="animate-fade-in bg-slate-50 p-4 rounded-xl border border-slate-100">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Ideal Answer (For Grading Reference)</label>
                                    <textarea x-model="activeQuestion.correct_answer" class="w-full border-slate-200 rounded-lg focus:ring-primary focus:border-primary text-sm p-3 h-24" placeholder="Enter a sample correct answer or key points to look for..."></textarea>
                                </div>
                            </div>
                            
                            <!-- Card Footer -->
                            <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end gap-3">
                                <button @click="duplicateQuestion(activeQuestionIndex)" class="px-4 py-2 border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-bold rounded-lg transition-colors">
                                    Duplicate
                                </button>
                                <button @click="deleteQuestion(activeQuestionIndex)" class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 text-sm font-bold rounded-lg transition-colors flex items-center gap-2">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                    Delete
                                </button>
                            </div>
                        </div>
                        
                        <!-- Settings Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                            <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-slate-400">tune</span>
                                Quiz Settings
                            </h3>
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Passing Score (%)</label>
                                    <input type="number" x-model="quiz.passing_score" class="w-full border-slate-200 rounded-lg focus:ring-primary focus:border-primary text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Time Limit (Minutes)</label>
                                    <input type="number" x-model="quiz.time_limit" class="w-full border-slate-200 rounded-lg focus:ring-primary focus:border-primary text-sm" placeholder="No Limit">
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                
                <template x-if="quiz.questions.length === 0">
                    <div class="flex flex-col items-center justify-center h-full text-center">
                        <div class="bg-slate-100 p-6 rounded-full mb-4">
                            <span class="material-symbols-outlined text-4xl text-slate-400">quiz</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Start Building Your Quiz</h3>
                        <p class="text-slate-500 px-4 mt-2 max-w-sm">Add questions from the left sidebar to begin creating your assessment.</p>
                        <button @click="addQuestion()" class="mt-6 px-6 py-3 bg-primary text-white font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-lg shadow-primary/20">
                            Add First Question
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </main>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('quizBuilder', () => ({
            status: 'idle',
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
            
            addQuestion() {
                this.quiz.questions.push({
                    text: 'New Question',
                    type: 'multiple_choice',
                    points: 5,
                    required: true,
                    options: ['Option 1', 'Option 2'],
                    correct_answer: 0
                });
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
                
                try {
                    const response = await fetch('{{ route("instructor.quizzes.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(this.quiz)
                    });
                    
                    if (response.ok) {
                        this.status = 'saved';
                        setTimeout(() => this.status = 'idle', 2000);
                        if (exit) window.location.href = '{{ route("instructor.quizzes.index") }}';
                    } else {
                        alert('Error saving quiz');
                        this.status = 'error';
                    }
                } catch (e) {
                    console.error(e);
                    alert('Network error');
                    this.status = 'error';
                }
            }
        }));
    });
</script>
</body>
</html>
