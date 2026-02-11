<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $enrollments = $user->enrollments()->with('course.instructor')->get();
        
        $enrolledCourseIds = $enrollments->pluck('course_id')->toArray();
        $featured_courses = \App\Models\Course::whereNotIn('id', $enrolledCourseIds)
            ->with(['instructor', 'modules'])
            ->latest()
            ->take(6)
            ->get();
            
        $is_live = \App\Models\Setting::where('key', 'is_live')->first();
        $completed_count = $user->enrollments()->where('status', 'completed')->count();
        $certificates_count = 0; // Placeholder for future certificate system

        // Fetch public meetings
        $public_meetings = \App\Models\Meeting::where('is_public', true)
            ->where('status', 'active')
            ->with('host')
            ->latest()
            ->get();
            
        return view('frontend.student.dashboard', compact('enrollments', 'featured_courses', 'is_live', 'completed_count', 'certificates_count', 'public_meetings'));
    }

    public function schedule()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        // Placeholder for schedule logic
        return view('frontend.student.schedule');
    }



    public function learn($id)
    {
        $course = \App\Models\Course::with(['modules.lessons', 'instructor'])->findOrFail($id);
        
        $user = \Illuminate\Support\Facades\Auth::user();
        $isEnrolled = $user->enrollments()->where('course_id', $id)->exists();
        
        // Simplified auth check for development
        if(!$isEnrolled && !$course->is_free && $user->role !== 'admin') {
            return redirect()->route('course.show', $id)->with('error', 'Please enroll to access this course.');
        }

        // Load quiz results for this course lessons
        $lessonIds = $course->modules->flatMap(fn($m) => $m->lessons->pluck('id'));
        $quizResults = \App\Models\QuizResult::where('user_id', $user->id)
            ->whereIn('lesson_id', $lessonIds)
            ->get()
            ->keyBy('lesson_id');

        $activeLessonId = request('lesson');

        return view('frontend.student.learn', compact('course', 'quizResults', 'activeLessonId'));
    }

    public function catalog()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        // Get user enrollments with course data
        $my_enrollments = $user->enrollments()->with('course.instructor', 'course.modules.lessons')->get();
        
        // Get all published courses with instructor and modules
        $courses = \App\Models\Course::where('is_published', true)
            ->with(['instructor', 'modules.lessons'])
            ->latest()
            ->get();
        
        // Check for any live meeting
        $live_meeting = \App\Models\Meeting::where('status', 'active')
            ->with('host')
            ->first();
        
        return view('frontend.student.catalog', compact('courses', 'my_enrollments', 'live_meeting'));
    }

    public function courseShow($id, $slug = null)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $course = \App\Models\Course::with(['instructor', 'modules.lessons'])->findOrFail($id);
        
        // SEO Redirect
        $expectedSlug = \Illuminate\Support\Str::slug($course->title);
        if ($slug !== $expectedSlug) {
            return redirect()->route('course.show', ['course' => $id, 'slug' => $expectedSlug]);
        }
        
        // Check if user is enrolled
        $isEnrolled = $user ? $user->enrollments()->where('course_id', $id)->exists() : false;
        
        // Get related courses (same instructor or category)
        $relatedCourses = \App\Models\Course::where('id', '!=', $id)
            ->where('is_published', true)
            ->with('instructor')
            ->inRandomOrder()
            ->take(3)
            ->get();
        
        // Calculate total lessons and duration
        $totalLessons = $course->modules->sum(fn($m) => $m->lessons->count());
        
        return view('frontend.student.course_show', compact('course', 'isEnrolled', 'relatedCourses', 'totalLessons'));
    }



    public function enroll(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id'
        ]);
        
        $user = \Illuminate\Support\Facades\Auth::user();
        $course = \App\Models\Course::findOrFail($request->course_id);
        
        // Check if already enrolled
        if ($user->enrollments()->where('course_id', $course->id)->exists()) {
            return redirect()->route('student.course.learn', $course)
                ->with('info', 'You are already enrolled in this course.');
        }
        
        // For paid courses, redirect to checkout
        if ($course->price > 0 && !$course->is_free) {
            return redirect()->route('student.course.checkout', $course->id);
        }
        
        // Create enrollment for free courses
        $user->enrollments()->create([
            'course_id' => $course->id,
            'status' => 'active',
            'progress' => 0
        ]);
        
        return redirect()->route('student.course.learn', $course)
            ->with('success', 'Congratulations! You have successfully enrolled in ' . $course->title);
    }

    public function courseCheckout($id)
    {
        $course = \App\Models\Course::with('instructor')->findOrFail($id);
        return view('frontend.student.checkout', ['course' => $course]);
    }

    public function processCoursePayment(Request $request, $id)
    {
        $course = \App\Models\Course::findOrFail($id);
        $user = auth()->user();

        // Simulate payment success and create enrollment
        $user->enrollments()->updateOrCreate(
            ['course_id' => $course->id],
            ['status' => 'active', 'progress' => 0]
        );

        return redirect()->route('student.course.learn', $course->id)
            ->with('success', 'Successfully enrolled in ' . $course->title);
    }
    public function bookMeeting(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'instructor_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'scheduled_at' => 'required|date|after:now',
            'description' => 'nullable|string',
            'visibility' => 'required|in:public,private',
            'price' => 'required|numeric|min:0',
            'type' => 'nullable|string'
        ]);

        $meeting = new \App\Models\Meeting();
        $meeting->host_id = $request->instructor_id;
        $meeting->title = $request->title;
        $meeting->scheduled_at = $request->scheduled_at;
        $meeting->description = $request->description;
        $meeting->room_code = \Illuminate\Support\Str::random(10);
        $meeting->status = 'pending'; // Start as pending until "payment"
        $meeting->visibility = $request->visibility;
        $meeting->price = $request->price;
        $meeting->type = $request->type ?? 'scheduled';
        
        // If private, add current student to allowed list
        if ($request->visibility === 'private') {
            $meeting->allowed_student_ids = json_encode([auth()->id()]);
        }
        
        $meeting->save();

        return redirect()->route('meeting.checkout', $meeting->id);
    }

    public function checkout($id)
    {
        $meeting = \App\Models\Meeting::with('host')->findOrFail($id);
        return view('frontend.student.checkout', compact('meeting'));
    }

    public function processPayment(Request $request, $id)
    {
        $meeting = \App\Models\Meeting::findOrFail($id);
        // Simulate payment success
        $meeting->status = 'scheduled';
        $meeting->save();

        return redirect()->route('meeting.booked', $meeting->id);
    }

    public function myBookings()
    {
        $user = auth()->user();
        // Meetings where user is host OR in allowed_student_ids
        $meetings = \App\Models\Meeting::where('host_id', $user->id)
            ->orWhereJsonContains('allowed_student_ids', $user->id)
            ->with('host')
            ->orderBy('scheduled_at', 'desc')
            ->get();

        return view('frontend.student.my_bookings', compact('meetings'));
    }

    public function sessionBooked($id)
    {
        $meeting = \App\Models\Meeting::with('host')->findOrFail($id);
        return view('frontend.student.session_booked', compact('meeting'));
    }
    public function myLearning()
    {
        $user = auth()->user();
        $enrollments = $user->enrollments()->with(['course.instructor', 'course.modules.lessons'])->get();
        
        $active_courses = $enrollments->where('progress', '<', 100);
        $completed_courses = $enrollments->where('progress', '>=', 100);
        
        // Count total lessons completed across all courses (mock logic for now if not tracked finely)
        //$certificates_count = $user->certificates()->count(); // Assuming Certificate model exists
        $certificates_count = 0; // Placeholder

        return view('frontend.student.my_learning', compact('active_courses', 'completed_courses', 'certificates_count'));
    }
    public function profile()
    {
        $user = auth()->user();
        $enrollments = $user->enrollments()->with('course')->get();
        return view('frontend.student.profile', compact('user', 'enrollments'));
    }

    public function settings()
    {
        return view('frontend.student.settings');
    }

    public function updateSettings(\Illuminate\Http\Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|max:2048'
        ]);

        $user->name = $request->name;
        $user->bio = $request->bio;

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                \Illuminate\Support\Facades\Storage::delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = auth()->user();

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password does not match.');
        }

        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->save();
        return back()->with('success', 'Password updated successfully.');
    }

    public function instructors()
    {
        $instructors = \App\Models\User::whereIn('role', ['instructor', 'admin'])->latest()->get();
        return view('frontend.student.instructors', compact('instructors'));
    }
    public function instructorProfile($id)
    {
        $instructor = \App\Models\User::whereIn('role', ['instructor', 'admin'])->findOrFail($id);
        $courses = \App\Models\Course::where('instructor_id', $id)->with('modules')->get();
        
        // Get total students enrolled in instructor's courses
        $total_students = \App\Models\Enrollment::whereIn('course_id', $courses->pluck('id'))->count();
        
        // Get instructor's books if Book model exists
        $books = collect();
        if (class_exists(\App\Models\Book::class)) {
            // Fetch books where author name matches instructor name
            $books = \App\Models\Book::where('author', $instructor->name)
                ->orWhere('author', 'like', '%' . $instructor->name . '%')
                ->latest()
                ->take(3)
                ->get();
        }
        
        // Get upcoming sessions/meetings hosted by instructor
        $upcoming_sessions = collect();
        if (class_exists(\App\Models\Meeting::class)) {
            $upcoming_sessions = \App\Models\Meeting::where('host_id', $id)
                ->where('status', '!=', 'ended')
                ->where('scheduled_at', '>=', now())
                ->orderBy('scheduled_at', 'asc')
                ->take(3)
                ->get();
        }
        
        return view('frontend.student.instructor_profile', compact('instructor', 'courses', 'total_students', 'books', 'upcoming_sessions'));
    }

    public function bookSession($id)
    {
        $instructor = \App\Models\User::whereIn('role', ['instructor', 'admin'])->findOrFail($id);
        return view('frontend.student.book_session', compact('instructor'));
    }
    public function submitQuiz(\Illuminate\Http\Request $request, $id)
    {
        $lesson = \App\Models\Lesson::findOrFail($id);
        if ($lesson->type !== 'quiz') {
            return response()->json(['success' => false, 'message' => 'Not a quiz lesson'], 400);
        }

        $quizData = $lesson->quiz_data;
        if (!$quizData || !isset($quizData['questions'])) {
            return response()->json(['success' => false, 'message' => 'Quiz data missing'], 400);
        }

        $user = \Illuminate\Support\Facades\Auth::user();
        $submittedAnswers = $request->input('answers', []); // Question Index => Option Index
        
        $correctCount = 0;
        $totalQuestions = count($quizData['questions']);
        
        foreach ($quizData['questions'] as $index => $question) {
            if (isset($submittedAnswers[$index]) && (int)$submittedAnswers[$index] === (int)$question['correct_answer']) {
                $correctCount++;
            }
        }

        $score = round(($correctCount / $totalQuestions) * 100);
        $passingScore = $quizData['passing_score'] ?? 70;
        $passed = $score >= $passingScore;

        // Save result
        $result = \App\Models\QuizResult::updateOrCreate(
            ['user_id' => $user->id, 'lesson_id' => $id],
            [
                'score' => $score,
                'passed' => $passed,
                'answers_json' => $submittedAnswers,
            ]
        );
        // Increment attempts if not first time
        if (!$result->wasRecentlyCreated) {
            $result->increment('attempts');
        }

        return response()->json([
            'success' => true,
            'score' => $score,
            'passed' => $passed,
            'passing_score' => $passingScore,
            'correct_count' => $correctCount,
            'total_questions' => $totalQuestions,
            'message' => $passed ? 'Congratulations! You passed.' : 'Keep studying and try again.'
        ]);
    }
}
