<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'title' => 'required',
            'type' => 'required',
        ]);

        $data = $request->all();
        $data['is_free'] = $request->has('is_free');
        // Map video_url to live_url if type matches, or keep versatile
        if($data['type'] == 'zoom_meeting' || $data['type'] == 'live_stream') {
             $data['live_url'] = $data['video_url']; 
        }

        \App\Models\Lesson::create($data);

        return back()->with('success', 'Lesson created successfully.');
    }

    public function destroy($id)
    {
        $lesson = \App\Models\Lesson::findOrFail($id);
        $lesson->delete();
        return back()->with('success', 'Lesson deleted successfully.');
    }
}
