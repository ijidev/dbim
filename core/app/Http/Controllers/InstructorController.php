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
            
        $activeCoursesCount = $courses->count();
        
        // Total Students (Unique)
        $totalStudents = Enrollment::whereIn('course_id', $courses->pluck('id'))
            ->distinct('user_id')
            ->count();
            
        // Live Attendees / Upcoming Meetings
        $meetings = Meeting::where('host_id', $user->id)
            ->whereIn('status', ['active', 'pending'])
            ->latest()
            ->get();

        $totalMeetings = $meetings->count();
            
        // Recent Enrollments
        $recentEnrollments = Enrollment::whereIn('course_id', $courses->pluck('id'))
            ->with(['user', 'course'])
            ->latest()
            ->take(10)
            ->get();

        return view('frontend.instructor.dashboard', compact(
            'courses',
            'activeCoursesCount',
            'totalStudents',
            'meetings',
            'totalMeetings',
            'recentEnrollments'
        ));
    }
}
