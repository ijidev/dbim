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

    public function instructorProfile($id)
    {
        $instructor = \App\Models\User::where('role', 'instructor')->findOrFail($id);
        $courses = \App\Models\Course::where('instructor_id', $id)->with('modules')->get();
        
        // Get total students enrolled in instructor's courses
        $total_students = \App\Models\Enrollment::whereIn('course_id', $courses->pluck('id'))->count();
        
        // Get instructor's books if Book model exists
        $books = collect();
        if (class_exists(\App\Models\Book::class)) {
            $books = \App\Models\Book::where('author_id', $id)->take(3)->get();
        }
        
        // Get upcoming sessions/meetings hosted by instructor
        $upcoming_sessions = \App\Models\Meeting::where('host_id', $id)
            ->where('status', '!=', 'ended')
            ->orderBy('scheduled_at', 'asc')
            ->take(3)
            ->get();
        
        return view('frontend.student.instructor_profile', compact('instructor', 'courses', 'total_students', 'books', 'upcoming_sessions'));
    }

    public function learn($id)
    {
        $course = \App\Models\Course::with(['modules.lessons', 'instructor'])->findOrFail($id);
        
        $user = \Illuminate\Support\Facades\Auth::user();
        $isEnrolled = $user->enrollments()->where('course_id', $id)->exists();
        
        // Simplified auth check for development
        if(!$isEnrolled && !$course->is_free && $user->role !== 'admin') {
            // Logic for unauthorized access could go here
        }

        return view('frontend.student.learn', compact('course'));
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

    public function courseShow($id)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $course = \App\Models\Course::with(['instructor', 'modules.lessons'])->findOrFail($id);
        
        // Check if user is enrolled
        $isEnrolled = $user->enrollments()->where('course_id', $id)->exists();
        
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
        
        // For paid courses, redirect to checkout (future implementation)
        if ($course->price > 0 && !$course->is_free) {
            // For now, just enroll - payment integration can be added later
        }
        
        // Create enrollment
        $user->enrollments()->create([
            'course_id' => $course->id,
            'status' => 'active',
            'progress' => 0
        ]);
        
        return redirect()->route('student.course.learn', $course)
            ->with('success', 'Congratulations! You have successfully enrolled in ' . $course->title);
    }
    public function bookMeeting(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'instructor_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'scheduled_at' => 'required|date|after:now',
            'description' => 'nullable|string'
        ]);

        $meeting = new \App\Models\Meeting();
        $meeting->host_id = $request->instructor_id;
        $meeting->title = $request->title;
        $meeting->scheduled_at = $request->scheduled_at;
        $meeting->description = $request->description;
        $meeting->room_code = \Illuminate\Support\Str::random(10);
        $meeting->status = 'scheduled';
        $meeting->save();

        // In a real app, we would add the student as a participant here
        // $meeting->participants()->attach(auth()->id());

        return redirect()->route('meeting.booked', $meeting->id);
    }

    public function sessionBooked($id)
    {
        $meeting = \App\Models\Meeting::with('host')->findOrFail($id);
        return view('frontend.student.session_booked', compact('meeting'));
    }
}
