<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $courses = Course::where('instructor_id', $user->id)->pluck('id');
        $quizzes = Quiz::whereIn('course_id', $courses)->withCount('questions')->latest()->paginate(10);
        
        return view('frontend.instructor.quizzes.index', compact('quizzes'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $courseId = $request->query('course_id');
        $lessonId = $request->query('lesson_id');
        
        $courses = Course::where('instructor_id', $user->id)->get();
        $selectedCourse = $courseId ? Course::find($courseId) : null;
        $lessons = $selectedCourse ? $selectedCourse->lessons : collect();

        return view('frontend.instructor.quizzes.builder', [
            'courses' => $courses,
            'lessons' => $lessons,
            'selectedCourseId' => $courseId,
            'selectedLessonId' => $lessonId,
            'quiz' => new Quiz()
        ]);
    }

    public function edit(Quiz $quiz)
    {
        $user = Auth::user();
        $quiz->load('questions');
        $courses = Course::where('instructor_id', $user->id)->get();
        $lessons = Lesson::where('course_id', $quiz->course_id)->get();

        return view('frontend.instructor.quizzes.builder', [
            'quiz' => $quiz,
            'courses' => $courses,
            'lessons' => $lessons,
            'selectedCourseId' => $quiz->course_id,
            'selectedLessonId' => $quiz->lesson_id,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'lesson_id' => 'nullable|exists:lessons,id',
            'passing_score' => 'required|integer|min:0|max:100',
            'time_limit' => 'nullable|integer|min:1',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|in:multiple_choice,open_ended',
            'questions.*.points' => 'required|integer|min:0',
            'questions.*.options' => 'nullable|array',
            'questions.*.correct_answer' => 'nullable',
        ]);

        $quiz = Quiz::create([
            'title' => $validated['title'],
            'course_id' => $validated['course_id'],
            'lesson_id' => $validated['lesson_id'],
            'passing_score' => $validated['passing_score'],
            'time_limit' => $validated['time_limit'],
            'is_published' => $request->has('publish'),
        ]);

        foreach ($validated['questions'] as $index => $qData) {
            $quiz->questions()->create([
                'question_text' => $qData['text'],
                'type' => $qData['type'],
                'points' => $qData['points'] ?? 1,
                'options' => $qData['options'] ?? null,
                'correct_answer' => $qData['correct_answer'] ?? null,
                'order' => $index,
            ]);
        }

        return response()->json(['message' => 'Quiz saved successfully', 'redirect' => route('instructor.quizzes.index')]);
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'passing_score' => 'required|integer|min:0|max:100',
            'time_limit' => 'nullable|integer|min:1',
            'questions' => 'required|array|min:1',
        ]);

        $quiz->update([
            'title' => $validated['title'],
            'passing_score' => $validated['passing_score'],
            'time_limit' => $validated['time_limit'],
            'is_published' => $request->has('publish'),
        ]);

        // Simple sync: delete old and recreate
        // In a real app we might want to keep IDs, but for a builder syncing is easier
        $quiz->questions()->delete();

        foreach ($request->input('questions') as $index => $qData) {
             $quiz->questions()->create([
                'question_text' => $qData['text'],
                'type' => $qData['type'],
                'points' => $qData['points'] ?? 1,
                'options' => $qData['options'] ?? null,
                'correct_answer' => $qData['correct_answer'] ?? null,
                'order' => $index,
            ]);
        }

        return response()->json(['message' => 'Quiz updated successfully']);
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('instructor.quizzes.index')->with('success', 'Quiz deleted successfully');
    }
}
