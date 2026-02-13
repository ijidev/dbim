@extends('layouts.instructor')

@section('title', 'Curriculum Builder - ' . $course->title)
@section('page_title', 'Curriculum Builder')

@section('instructor_content')
<div class="max-w-5xl mx-auto space-y-12">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="space-y-2">
            <a href="{{ route('instructor.courses.index') }}" class="inline-flex items-center gap-2 text-xs font-black text-slate-400 hover:text-primary transition-all group">
                <span class="material-symbols-outlined text-lg group-hover:-translate-x-1 transition-transform">arrow_back</span>
                BACK TO PORTFOLIO
            </a>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">{{ $course->title }}</h1>
            <p class="text-slate-500 font-medium">Design your learning journey by organizing modules and lessons.</p>
        </div>
        <button onclick="openModal('moduleModal')" class="h-14 px-8 bg-primary text-white rounded-[1.25rem] text-sm font-black flex items-center gap-3 shadow-xl shadow-primary/20 hover:scale-105 transition-all">
            <span class="material-symbols-outlined text-xl">add_box</span>
            ADD NEW MODULE
        </button>
    </div>

    <!-- Stats Bar -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="size-12 rounded-xl bg-primary/5 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined font-bold">view_module</span>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Modules</p>
                <p class="text-lg font-black text-slate-900">{{ $course->modules->count() }} Total</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="size-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <span class="material-symbols-outlined font-bold">play_lesson</span>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Lessons</p>
                <p class="text-lg font-black text-slate-900">{{ $course->modules->sum(fn($m) => $m->lessons->count()) }} Total</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="size-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <span class="material-symbols-outlined font-bold">timer</span>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Duration</p>
                <p class="text-lg font-black text-slate-900">Est. 4.5 hrs</p>
            </div>
        </div>
    </div>

    <!-- Curriculum Modules -->
    <div id="moduleList" class="space-y-8">
        @forelse($course->modules as $module)
        <div class="module-card bg-white rounded-[2.5rem] border border-[#dcdfe5] shadow-sm overflow-hidden group">
            <!-- Module Header -->
            <div class="p-8 bg-[#f8f9fb] border-b border-slate-50 flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <div class="size-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-primary font-black shadow-sm group-hover:bg-primary group-hover:text-white transition-all">
                        {{ $loop->iteration }}
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900">{{ $module->title }}</h3>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-0.5">{{ $module->lessons->count() }} LESSONS</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="openLessonModal({{ $module->id }})" class="h-10 px-5 bg-white border border-slate-100 rounded-xl text-[10px] font-black text-primary hover:bg-primary hover:text-white hover:border-primary transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-base">add_circle</span>
                        ADD LESSON
                    </button>
                    <form action="{{ route('instructor.modules.destroy', $module->id) }}" method="POST" onsubmit="return confirm('Strict Warning: This will delete the module and ALL associated lessons. Proceed?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="size-10 bg-white border border-slate-100 rounded-xl text-slate-300 hover:text-red-500 hover:border-red-50 transition-all flex items-center justify-center">
                            <span class="material-symbols-outlined text-xl">delete</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Lessons List -->
            <div class="lesson-list divide-y divide-slate-50">
                @forelse($module->lessons as $lesson)
                <div class="px-8 py-6 flex items-center justify-between hover:bg-slate-50 transition-all group/lesson">
                    <div class="flex items-center gap-6">
                        <div class="size-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300 group-hover/lesson:bg-primary/10 group-hover/lesson:text-primary transition-all">
                            <span class="material-symbols-outlined text-xl fill-1">play_circle</span>
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-sm font-black text-slate-800 tracking-tight">{{ $lesson->title }}</h4>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Video Lesson</span>
                                <span class="size-1 bg-slate-200 rounded-full"></span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $lesson->duration ?? '5:00' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 opacity-0 group-hover/lesson:opacity-100 transition-opacity">
                        <button class="p-2 text-slate-300 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-xl">edit</span>
                        </button>
                        <form action="{{ route('instructor.lessons.destroy', $lesson->id) }}" method="POST" onsubmit="return confirm('Delete this lesson?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-slate-300 hover:text-red-500 transition-colors">
                                <span class="material-symbols-outlined text-xl">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="p-16 text-center">
                    <div class="size-14 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-200 mx-auto mb-4">
                        <span class="material-symbols-outlined text-3xl">post_add</span>
                    </div>
                    <p class="text-sm font-black text-slate-400 tracking-tight italic">Your module awaits its first lesson.</p>
                </div>
                @endforelse
            </div>
        </div>
        @empty
        <div class="py-32 bg-white rounded-[2.5rem] border-2 border-dashed border-slate-100 flex flex-col items-center justify-center text-center p-12">
            <div class="size-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center text-slate-200 mb-8">
                <span class="material-symbols-outlined text-5xl">auto_stories</span>
            </div>
            <h3 class="text-2xl font-black text-slate-900">Your curriculum is a blank canvas</h3>
            <p class="text-slate-400 max-w-sm mx-auto mt-4 font-medium italic">"Commit your work to the Lord, and your plans will be established." — Proverbs 16:3</p>
            <button onclick="openModal('moduleModal')" class="mt-10 h-14 px-10 bg-primary text-white rounded-2xl text-sm font-black flex items-center gap-3 shadow-xl shadow-primary/20 hover:scale-105 transition-all">
                CREATE YOUR FIRST MODULE
            </button>
        </div>
        @endforelse
    </div>
</div>

<!-- Add Module Modal -->
<div id="moduleModal" class="fixed inset-0 z-[100] hidden bg-slate-900/60 backdrop-blur-md flex items-center justify-center p-4">
    <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="p-10 border-b border-slate-50 flex items-center justify-between bg-[#f8f9fb]">
            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Create Module</h3>
            <button onclick="closeModal('moduleModal')" class="size-10 bg-white rounded-xl text-slate-400 hover:text-slate-600 transition-all flex items-center justify-center shadow-sm">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form action="{{ route('instructor.modules.store') }}" method="POST" class="p-10 space-y-8">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <div class="space-y-3">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-2">Module Title</label>
                <input type="text" name="title" class="w-full h-16 bg-[#f8f9fb] border-none rounded-2xl px-8 text-sm font-black focus:ring-4 focus:ring-primary/5 transition-all" placeholder="e.g., Foundations of Divine Leadership" required>
            </div>
            <div class="flex gap-4">
                <button type="submit" class="flex-1 h-16 bg-primary text-white rounded-2xl font-black text-sm shadow-xl shadow-primary/20 hover:scale-[1.02] transition-all">
                    CREATE MODULE
                </button>
                <button type="button" onclick="closeModal('moduleModal')" class="flex-1 h-16 bg-slate-50 text-slate-500 rounded-2xl font-black text-sm">CANCEL</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Lesson Modal -->
<div id="lessonModal" class="fixed inset-0 z-[100] hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="p-10 border-b border-slate-50 flex items-center justify-between bg-[#f8f9fb]">
            <h3 class="text-2xl font-black text-slate-900 tracking-tight">New Lesson</h3>
            <button onclick="closeModal('lessonModal')" class="size-10 bg-white rounded-xl text-slate-400 hover:text-slate-600 transition-all flex items-center justify-center shadow-sm">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form action="{{ route('instructor.lessons.store') }}" method="POST" class="p-10 space-y-8">
            @csrf
            <input type="hidden" name="module_id" id="modalModuleId">
            <div class="space-y-6">
                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-2">Lesson Title</label>
                    <input type="text" name="title" class="w-full h-16 bg-[#f8f9fb] border-none rounded-2xl px-8 text-sm font-black focus:ring-4 focus:ring-primary/5 transition-all" placeholder="e.g., The Theology of Work" required>
                </div>
                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-2">Video Resource (Youtube/Vimeo ID)</label>
                    <input type="text" name="video_url" class="w-full h-16 bg-[#f8f9fb] border-none rounded-2xl px-8 text-sm font-black focus:ring-4 focus:ring-primary/5 transition-all" placeholder="e.g., dQw4w9WgXcQ">
                </div>
            </div>
            <div class="flex gap-4">
                <button type="submit" class="flex-1 h-16 bg-primary text-white rounded-2xl font-black text-sm shadow-xl shadow-primary/20 hover:scale-[1.02] transition-all">
                    ADD TO CURRICULUM
                </button>
            </div>
        </form>
    </div>
</div>

@section('instructor_scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).style.display = 'flex';
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(id).style.display = 'none';
    }
    function openLessonModal(moduleId) {
        document.getElementById('modalModuleId').value = moduleId;
        openModal('lessonModal');
    }

    // Initialize Sortable for Lessons
    document.querySelectorAll('.lesson-list').forEach(list => {
        new Sortable(list, {
            animation: 150,
            ghostClass: 'bg-primary/5',
            handle: '.group/lesson',
            onEnd: function() {
                // Here we would normally persist the order to the backend
                console.log('Lesson reordered');
            }
        });
    });
</script>
@endsection
@endsection
