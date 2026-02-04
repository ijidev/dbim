<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::with('host')->latest()->paginate(15);
        return view('admin.meetings.index', compact('meetings'));
    }

    public function destroy(Meeting $meeting)
    {
        $meeting->delete();
        return back()->with('success', 'Meeting record deleted.');
    }

    public function end(Meeting $meeting)
    {
        $meeting->update(['status' => 'ended']);
        return back()->with('success', 'Meeting forced to end.');
    }
}
