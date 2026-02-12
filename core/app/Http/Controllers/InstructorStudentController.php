<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InstructorStudentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get instructor's courses
        $instructorCourses = Course::where('instructor_id', $user->id)->pluck('id');
        
        // Base query for enrollments
        $query = Enrollment::with(['user', 'course'])
            ->whereIn('course_id', $instructorCourses);
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Course filter
        if ($request->filled('course') && $request->course != 'all') {
            $query->where('course_id', $request->course);
        }
        
        // Status filter
        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        // Progress range filter
        if ($request->filled('progress') && $request->progress != 'all') {
            switch ($request->progress) {
                case '0-25':
                    $query->whereBetween('progress_percentage', [0, 25]);
                    break;
                case '26-50':
                    $query->whereBetween('progress_percentage', [26, 50]);
                    break;
                case '51-75':
                    $query->whereBetween('progress_percentage', [51, 75]);
                    break;
                case '76-100':
                    $query->whereBetween('progress_percentage', [76, 100]);
                    break;
            }
        }
        
        // Get stats
        $total_enrolled = Enrollment::whereIn('course_id', $instructorCourses)
            ->distinct('user_id')
            ->count();
            
        $avg_progress = Enrollment::whereIn('course_id', $instructorCourses)
            ->avg('progress_percentage');
            
        $active_this_week = Enrollment::whereIn('course_id', $instructorCourses)
            ->where('last_access_at', '>=', now()->subWeek())
            ->distinct('user_id')
            ->count();
            
        $engagement_rate = $total_enrolled > 0 ? round(($active_this_week / $total_enrolled) * 100) : 0;
        
        // Get paginated results
        $students = $query->latest('created_at')->paginate(10);
        
        // Get courses for filter dropdown
        $courses = Course::where('instructor_id', $user->id)->get();
        
        return view('frontend.instructor.students.index', compact(
            'students',
            'courses',
            'total_enrolled',
            'avg_progress',
            'engagement_rate',
            'active_this_week'
        ));
    }
    
    public function export(Request $request)
    {
        $user = Auth::user();
        $instructorCourses = Course::where('instructor_id', $user->id)->pluck('id');
        
        // Build query with same filters as index
        $query = Enrollment::with(['user', 'course'])
            ->whereIn('course_id', $instructorCourses);
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('course') && $request->course != 'all') {
            $query->where('course_id', $request->course);
        }
        
        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('progress') && $request->progress != 'all') {
            switch ($request->progress) {
                case '0-25':
                    $query->whereBetween('progress_percentage', [0, 25]);
                    break;
                case '26-50':
                    $query->whereBetween('progress_percentage', [26, 50]);
                    break;
                case '51-75':
                    $query->whereBetween('progress_percentage', [51, 75]);
                    break;
                case '76-100':
                    $query->whereBetween('progress_percentage', [76, 100]);
                    break;
            }
        }
        
        $enrollments = $query->get();
        
        // Generate CSV
        $filename = 'students_export_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];
        
        $callback = function() use ($enrollments) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, ['Student Name', 'Email', 'Course', 'Join Date', 'Last Active', 'Progress %', 'Status']);
            
            // Add data
            foreach ($enrollments as $enrollment) {
                fputcsv($file, [
                    $enrollment->user->name,
                    $enrollment->user->email,
                    $enrollment->course->title,
                    $enrollment->created_at->format('Y-m-d'),
                    $enrollment->last_access_at ? $enrollment->last_access_at->diffForHumans() : 'Never',
                    $enrollment->progress_percentage,
                    ucfirst($enrollment->status)
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
