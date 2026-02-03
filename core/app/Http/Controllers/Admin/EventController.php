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

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required',
            'time' => 'required',
            'location' => 'required',
            'image' => 'required|image'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('assets/images/events'), $imageName);
            $data['image'] = 'assets/images/events/'.$imageName;
        }

        // Auto-fill day, month, year from date
        $date = \Carbon\Carbon::parse($request->date);
        $data['day'] = $date->format('l'); // Full day name (e.g., Monday)
        // Fix: Enum expects specific values, ensuring compatibility
        //$data['month'] = $date->format('M'); // Abbreviated month name (e.g., Jan)
         $months = ['Jan','Feb','March','April','May','Jun','July','Augt','Sep','Oct' , 'Nov', 'Dec' ];
         $data['month'] = $months[$date->month - 1];

        $data['year'] = $date->year;

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
            'date' => 'required',
            'time' => 'required',
            'location' => 'required',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('assets/images/events'), $imageName);
            $data['image'] = 'assets/images/events/'.$imageName;
        }

        // Auto-fill day, month, year from date
        $date = \Carbon\Carbon::parse($request->date);
        $data['day'] = $date->format('l'); // Full day name (e.g., Monday)
        
         $months = ['Jan','Feb','March','April','May','Jun','July','Augt','Sep','Oct' , 'Nov', 'Dec' ];
         $data['month'] = $months[$date->month - 1];

        $data['year'] = $date->year;

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
