<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;

class EventRegistrationController extends Controller
{
    public function index(Event $event)
    {
        $registrations = $event->registrations()->latest()->paginate(20);
        return view('admin.events.registrations', compact('event', 'registrations'));
    }

    public function updateStatus(Request $request, EventRegistration $registration)
    {
        $request->validate([
            'status' => 'required|in:registered,confirmed,cancelled',
        ]);

        $registration->update(['status' => $request->status]);
        
        return back()->with('success', 'Registration status updated.');
    }

    public function destroy(EventRegistration $registration)
    {
        $registration->delete();
        return back()->with('success', 'Registration deleted.');
    }
}
