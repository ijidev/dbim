<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Meeting;
use Illuminate\Support\Facades\Auth;

class InstructorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Active Courses
        $courses = Course::where('instructor_id', $user->id)
            ->with(['modules', 'students'])
            ->latest()
            ->get();
            
        $active_courses_count = $courses->count();
        
        // Total Students (Unique)
        $total_students_count = Enrollment::whereIn('course_id', $courses->pluck('id'))
            ->distinct('user_id')
            ->count();
            
        // Live Attendees / Upcoming Meetings
        $upcoming_meetings = Meeting::where('host_id', $user->id)
            ->whereIn('status', ['active', 'pending'])
            ->latest()
            ->get();
            
        // Recent Enrollments
        $recent_enrollments = Enrollment::whereIn('course_id', $courses->pluck('id'))
            ->with(['user', 'course'])
            ->latest()
            ->take(10)
            ->get();

        return view('frontend.instructor.dashboard', compact(
            'courses',
            'active_courses_count',
            'total_students_count',
            'upcoming_meetings',
            'recent_enrollments'
        ));
    }
}
