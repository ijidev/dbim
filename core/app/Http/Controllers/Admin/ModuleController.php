<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModuleController extends Controller
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
            'course_id' => 'required|exists:courses,id',
            'title' => 'required',
        ]);

        \App\Models\Module::create($request->all());

        return back()->with('success', 'Module created successfully.');
    }

    public function destroy($id)
    {
        $module = \App\Models\Module::findOrFail($id);
        $module->delete();
        return back()->with('success', 'Module deleted successfully.');
    }
}
