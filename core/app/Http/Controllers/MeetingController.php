<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $meetings = Meeting::where('host_id', auth()->id())
            ->orWhere('status', 'active')
            ->latest()
            ->paginate(10);
            
        return view('frontend.meeting.index', compact('meetings'));
    }

    public function create()
    {
        return view('frontend.meeting.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'type' => 'required|in:instant,scheduled',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        $meeting = Meeting::create([
            'host_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'scheduled_at' => $request->type === 'scheduled' ? $request->scheduled_at : null,
            'status' => $request->type === 'instant' ? 'active' : 'pending',
        ]);

        if ($request->type === 'instant') {
            return redirect()->route('meeting.room', $meeting->room_code);
        }

        return redirect()->route('meeting.index')->with('success', 'Meeting scheduled successfully!');
    }

    public function room($code)
    {
        $meeting = Meeting::where('room_code', $code)->firstOrFail();
        
        if ($meeting->status === 'ended') {
            return redirect()->route('meeting.index')->with('error', 'This meeting has already ended.');
        }

        // Update status to active if pending (only for the host or first person)
        if ($meeting->status === 'pending') {
            $meeting->update(['status' => 'active']);
        }

        return view('frontend.meeting.room', compact('meeting'));
    }

    public function end(Meeting $meeting)
    {
        if ($meeting->host_id !== auth()->id()) {
            abort(403);
        }

        $meeting->update(['status' => 'ended']);
        return redirect()->route('meeting.index')->with('success', 'Meeting ended.');
    }
}
