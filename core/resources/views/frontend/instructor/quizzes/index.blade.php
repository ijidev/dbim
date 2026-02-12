@extends('frontend.instructor.dashboard')

@section('dashboard_content')
<div class="p-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Quizzes</h1>
            <p class="text-slate-500 mt-1">Manage course assessments and quizzes</p>
        </div>
        <button onclick="document.getElementById('createQuizModal').classList.remove('hidden')" class="px-6 py-2.5 bg-primary text-white font-bold rounded-lg flex items-center gap-2 hover:bg-blue-700 transition-colors">
            <span class="material-symbols-outlined">add</span>
            Create New Quiz
        </button>
    </div>

    <!-- Quiz List -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4">Title</th>
                    <th class="px-6 py-4">Course</th>
                    <th class="px-6 py-4">Questions</th>
                    <th class="px-6 py-4">Time Limit</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($quizzes as $quiz)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-900">{{ $quiz->title }}</div>
                        <div class="text-xs text-slate-500">{{ $quiz->lesson ? 'Lesson: ' . $quiz->lesson->title : 'Standalone' }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $quiz->course->title }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $quiz->questions_count }} Questions</td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $quiz->time_limit ? $quiz->time_limit . ' mins' : 'Unlimited' }}</td>
                    <td class="px-6 py-4">
                        @if($quiz->is_published)
                            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full">Published</span>
                        @else
                            <span class="px-2 py-1 bg-slate-100 text-slate-600 text-xs font-bold rounded-full">Draft</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('instructor.quizzes.edit', $quiz->id) }}" class="p-2 text-slate-400 hover:text-primary hover:bg-slate-100 rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <form action="{{ route('instructor.quizzes.destroy', $quiz->id) }}" method="POST" onsubmit="return confirm('Are you sure? This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                        <span class="material-symbols-outlined text-4xl mb-2 text-slate-300">quiz</span>
                        <p>No quizzes created yet.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $quizzes->links() }}
    </div>
</div>

<!-- Create Modal -->
<div id="createQuizModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-lg font-bold">Create New Quiz</h3>
            <button onclick="document.getElementById('createQuizModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form action="{{ route('instructor.quizzes.create_step1') }}" method="GET" class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Select Course</label>
                <select name="course_id" class="w-full border-slate-200 rounded-lg focus:ring-primary focus:border-primary text-sm">
                    @foreach(\App\Models\Course::where('instructor_id', Auth::id())->get() as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="pt-4 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-primary text-white font-bold rounded-lg hover:bg-blue-700">
                    Start Building
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
