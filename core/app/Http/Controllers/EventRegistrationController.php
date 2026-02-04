<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;

class EventRegistrationController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        // Check if already registered
        $existing = EventRegistration::where('event_id', $event->id)
            ->where('email', $request->email)
            ->first();

        if ($existing) {
            return back()->with('error', 'You are already registered for this event.');
        }

        EventRegistration::create([
            'event_id' => $event->id,
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => 'registered',
        ]);

        return back()->with('success', 'You have been registered for this event!');
    }
}
