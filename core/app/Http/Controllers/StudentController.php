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
        $courses = \App\Models\Course::where('instructor_id', $id)->get();
        return view('frontend.student.instructor_profile', compact('instructor', 'courses'));
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
}
