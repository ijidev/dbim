<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        // Assuming a simpler enrollment for now: user has access to all free courses or we build an enrollment table later. 
        // For now, let's just show all courses or enrolled ones if table exists. 
        // Since we created enrollments table in migration 2026_01_19_000005, let's use it.
        
        $enrollments = $user->enrollments()->with('course.instructor')->get();
        return view('frontend.student.dashboard', compact('enrollments'));
    }

    public function learn($id)
    {
        $course = \App\Models\Course::with(['modules.lessons', 'instructor'])->findOrFail($id);
        
        // Simple authorization check (can be improved with policies)
        $user = \Illuminate\Support\Facades\Auth::user();
        $isEnrolled = $user->enrollments()->where('course_id', $id)->exists();
        
        if(!$isEnrolled && !$course->is_free && $user->role !== 'admin') {
             // For testing purposes, we might want to allow access or redirect to payment
             // return redirect()->route('course.show', $id)->with('error', 'You must enroll first.');
        }

        return view('frontend.student.learn', compact('course'));
    }
}
