<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = \App\Models\Course::with('instructor')->latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'numeric|min:0',
            'thumbnail' => 'nullable|image',
        ]);

        $data = $request->all();

        if ($request->hasFile('thumbnail')) {
            $imageName = time().'.'.$request->thumbnail->extension();  
            $request->thumbnail->move(public_path('assets/images/courses'), $imageName);
            $data['thumbnail'] = 'assets/images/courses/'.$imageName;
        }
        
        // Ensure checkbox is handled correctly
        $data['is_published'] = $request->has('is_published');
        // Default instructor to current user if not set (though logic allows selection)
        if(empty($data['instructor_id'])) {
             $data['instructor_id'] = Auth::id();
        }

        \App\Models\Course::create($data);

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $course = \App\Models\Course::findOrFail($id);
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $course = \App\Models\Course::findOrFail($id);
        
        $request->validate([
            'title' => 'required',
            'price' => 'numeric|min:0',
            'thumbnail' => 'nullable|image',
        ]);

        $data = $request->all();

        if ($request->hasFile('thumbnail')) {
            $imageName = time().'.'.$request->thumbnail->extension();  
            $request->thumbnail->move(public_path('assets/images/courses'), $imageName);
            $data['thumbnail'] = 'assets/images/courses/'.$imageName;
        }

        $data['is_published'] = $request->has('is_published');

        $course->update($data);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy($id)
    {
        $course = \App\Models\Course::findOrFail($id);
        // Optional: Delete thumbnail from storage
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }

    public function content($id)
    {
        $course = \App\Models\Course::with(['modules.lessons'])->findOrFail($id);
        return view('admin.courses.content', compact('course'));
    }
}
