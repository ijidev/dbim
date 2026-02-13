<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InstructorCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::where('instructor_id', Auth::id())
            ->withCount(['students', 'modules'])
            ->latest()
            ->paginate(12);
            
        return view('frontend.instructor.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frontend.instructor.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'price' => 'numeric|min:0',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['instructor_id'] = Auth::id();

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('courses/thumbnails', 'public');
            $data['thumbnail'] = $path;
        }
        
        $data['is_published'] = $request->has('is_published');

        Course::create($data);

        return redirect()->route('instructor.courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);
        return view('frontend.instructor.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'price' => 'numeric|min:0',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $path = $request->file('thumbnail')->store('courses/thumbnails', 'public');
            $data['thumbnail'] = $path;
        }

        $data['is_published'] = $request->has('is_published');

        $course->update($data);

        return redirect()->route('instructor.courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);
        
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }
        
        $course->delete();
        
        return redirect()->route('instructor.courses.index')->with('success', 'Course deleted successfully.');
    }

    /**
     * Manage course content (modules and lessons)
     */
    public function content($id)
    {
        $course = Course::where('instructor_id', Auth::id())
            ->with(['modules.lessons'])
            ->findOrFail($id);
            
        return view('frontend.instructor.courses.content', compact('course'));
    }
}
