<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $enrollments = $user->enrollments()->with('course.instructor')->get();
        return view('frontend.student.dashboard', compact('enrollments'));
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
