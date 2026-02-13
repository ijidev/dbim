<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class InstructorModuleController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
        ]);

        // Ensure course belongs to instructor
        $course = Course::where('id', $request->course_id)
            ->where('instructor_id', Auth::id())
            ->firstOrFail();

        Module::create($request->all());

        return back()->with('success', 'Module created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $module = Module::whereHas('course', function($q) {
            $q->where('instructor_id', Auth::id());
        })->findOrFail($id);

        $module->delete();

        return back()->with('success', 'Module deleted successfully.');
    }
}
