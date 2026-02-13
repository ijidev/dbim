@extends('layouts.instructor')

@section('title', 'Quiz Portfolio')
@section('page_title', 'Assessment Management Hub')

@section('instructor_content')
<div class="space-y-12">
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900 leading-tight tracking-tight">Quiz Portfolio</h1>
            <p class="text-slate-500 font-medium mt-1">Design, manage, and deploy course assessments with high precision.</p>
        </div>
        <button onclick="document.getElementById('createQuizModal').classList.remove('hidden')" class="h-14 px-8 bg-primary text-white rounded-[1.25rem] text-sm font-black flex items-center gap-3 shadow-xl shadow-primary/20 hover:scale-105 transition-all">
            <span class="material-symbols-outlined text-xl">add_box</span>
            CREATE NEW QUIZ
        </button>
    </div>

    <!-- Quiz Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($quizzes as $quiz)
        <div class="bg-white rounded-[2.5rem] border border-[#dcdfe5] shadow-sm overflow-hidden group hover:shadow-2xl hover:shadow-primary/5 transition-all flex flex-col">
            <!-- Header Section -->
            <div class="p-8 pb-4">
                <div class="flex items-center justify-between mb-6">
                    <div class="size-14 rounded-2xl bg-primary/5 text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all">
                        <span class="material-symbols-outlined text-2xl font-bold">quiz</span>
                    </div>
                    @if($quiz->is_published)
                        <span class="px-3 py-1.5 bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase rounded-lg tracking-widest border border-emerald-100">
                            PUBLISHED
                        </span>
                    @else
                        <span class="px-3 py-1.5 bg-slate-50 text-slate-400 text-[9px] font-black uppercase rounded-lg tracking-widest border border-slate-100">
                            DRAFT
                        </span>
                    @endif
                </div>
                
                <h3 class="text-xl font-black text-slate-900 group-hover:text-primary transition-colors leading-tight mb-2">
                    {{ $quiz->title }}
                </h3>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    {{ $quiz->course->title }}
                </p>
            </div>

            <!-- Stats Section -->
            <div class="px-8 py-6 bg-[#f8f9fb] border-y border-slate-50 grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Questions</p>
                    <p class="text-sm font-black text-slate-700 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-lg">format_list_bulleted</span>
                        {{ $quiz->questions_count }}
                    </p>
                </div>
                <div class="space-y-1 text-right">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Time Limit</p>
                    <p class="text-sm font-black text-slate-700 flex items-center gap-2 justify-end">
                        <span class="material-symbols-outlined text-amber-500 text-lg">timer</span>
                        {{ $quiz->time_limit ? $quiz->time_limit . ' Min' : 'No Limit' }}
                    </p>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="p-6 bg-white flex items-center gap-3">
                <a href="{{ route('instructor.quizzes.edit', $quiz->id) }}" class="flex-1 h-12 bg-slate-50 rounded-xl text-[10px] font-black text-slate-600 hover:bg-primary hover:text-white transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-base font-bold">edit_note</span>
                    OPEN BUILDER
                </a>
                <form action="{{ route('instructor.quizzes.destroy', $quiz->id) }}" method="POST" onsubmit="return confirm('Strict Warning: Delete this quiz assessment?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="size-12 bg-red-50 text-red-400 rounded-xl hover:bg-red-500 hover:text-white transition-all flex items-center justify-center">
                        <span class="material-symbols-outlined text-lg">delete</span>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full py-32 text-center">
            <div class="size-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center text-slate-200 mx-auto mb-8 transition-transform hover:rotate-12">
                <span class="material-symbols-outlined text-5xl font-light">edit_document</span>
            </div>
            <h3 class="text-2xl font-black text-slate-900">Quiz bank is empty</h3>
            <p class="text-slate-500 max-w-sm mx-auto mt-4 font-medium italic">"Test me, Lord, and try me, examine my heart and my mind." — Psalm 26:2</p>
            <div class="mt-10">
                <button onclick="document.getElementById('createQuizModal').classList.remove('hidden')" class="inline-flex h-14 px-10 bg-primary text-white rounded-[1.25rem] text-sm font-black items-center gap-3 shadow-xl shadow-primary/20 hover:scale-105 transition-all">
                    START YOUR FIRST ASSESSMENT
                </button>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($quizzes->hasPages())
    <div class="mt-12 flex justify-center">
        {{ $quizzes->links() }}
    </div>
    @endif
</div>

<!-- Create Modal -->
<div id="createQuizModal" class="fixed inset-0 z-[100] hidden bg-slate-900/40 backdrop-blur-md flex items-center justify-center p-4">
    <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="p-10 border-b border-slate-50 flex items-center justify-between bg-[#f8f9fb]">
            <h3 class="text-2xl font-black text-slate-900 tracking-tight">New Assessment</h3>
            <button onclick="document.getElementById('createQuizModal').classList.add('hidden')" class="size-10 bg-white rounded-xl text-slate-400 hover:text-slate-600 transition-all flex items-center justify-center shadow-sm">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form action="{{ route('instructor.quizzes.create_step1') }}" method="GET" class="p-10 space-y-8">
            <div class="space-y-4">
                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] px-2">Target Course Engagement</label>
                <div class="relative group">
                    <select name="course_id" class="w-full h-16 bg-[#f8f9fb] border-none rounded-2xl px-8 text-sm font-black focus:ring-4 focus:ring-primary/5 transition-all appearance-none cursor-pointer">
                        @foreach(\App\Models\Course::where('instructor_id', Auth::id())->get() as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined absolute right-6 top-5 text-slate-300 pointer-events-none group-hover:text-primary transition-colors">expand_more</span>
                </div>
                <p class="text-[10px] font-bold text-slate-400 italic px-2">Select the course you wish to build an assessment for.</p>
            </div>
            
            <div class="flex gap-4">
                <button type="submit" class="flex-1 h-16 bg-primary text-white font-black rounded-2xl text-xs tracking-widest flex items-center justify-center gap-3 shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                    START BUILDER <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
