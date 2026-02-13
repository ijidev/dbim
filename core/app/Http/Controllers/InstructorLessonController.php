<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class InstructorLessonController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'title' => 'required|string|max:255',
        ]);

        // Ensure module's course belongs to instructor
        $module = Module::whereHas('course', function($q) {
            $q->where('instructor_id', Auth::id());
        })->where('id', $request->module_id)->firstOrFail();

        $data = $request->all();
        $data['type'] = $request->type ?? 'video'; // Default to video
        
        Lesson::create($data);

        return back()->with('success', 'Lesson created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lesson = Lesson::whereHas('module.course', function($q) {
            $q->where('instructor_id', Auth::id());
        })->findOrFail($id);

        $lesson->delete();

        return back()->with('success', 'Lesson deleted successfully.');
    }
}
