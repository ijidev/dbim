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
            ->with('instructor')
            ->latest()
            ->take(3)
            ->get();
            
        $is_live = \App\Models\Setting::where('key', 'is_live')->first();
        
        return view('frontend.student.dashboard', compact('enrollments', 'featured_courses', 'is_live'));
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
