<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = \App\Models\Event::latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $path = base_path('../assets/images/events');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move($path, $imageName);
            $data['image'] = 'assets/images/events/'.$imageName;
        }

        // Auto-fill day, month, year from date
        $date = \Carbon\Carbon::parse($request->date);
        $data['day'] = $date->format('l');
        $months = ['Jan','Feb','March','April','May','Jun','July','Augt','Sep','Oct' , 'Nov', 'Dec' ];
        $data['month'] = $months[$date->month - 1];
        $data['year'] = $date->year;

        // Ensure status and recurrence are set
        $data['status'] = $request->status ?? 'comming';
        $data['recurrence'] = $request->recurrence ?? 'none';
        $data['type'] = $request->type ?? 'program';
        $data['loop_extra_dates'] = $request->has('loop_extra_dates');

        \App\Models\Event::create($data);

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
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
        $event = \App\Models\Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = \App\Models\Event::findOrFail($id);
        
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $path = base_path('../assets/images/events');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move($path, $imageName);
            $data['image'] = 'assets/images/events/'.$imageName;
        }

        // Auto-fill day, month, year from date
        $date = \Carbon\Carbon::parse($request->date);
        $data['day'] = $date->format('l');
        $months = ['Jan','Feb','March','April','May','Jun','July','Augt','Sep','Oct' , 'Nov', 'Dec' ];
        $data['month'] = $months[$date->month - 1];
        $data['year'] = $date->year;

        $data['loop_extra_dates'] = $request->has('loop_extra_dates');

        $event->update($data);

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy($id)
    {
        $event = \App\Models\Event::findOrFail($id);
        // Optional: Delete image file from storage
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
