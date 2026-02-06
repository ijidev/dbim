<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    public function index(){
        $events = Event::Where('status', 'comming')->latest('date')->take(3)->get();
        $is_live = \App\Models\Setting::where('key', 'is_live')->first();
        $featured_courses = \App\Models\Course::with('instructor')->latest()->take(3)->get();
        $counts = [
            'courses' => \App\Models\Course::count(),
            'students' => \App\Models\User::where('role', 'student')->count(),
        ];
        
        return view('frontend.index', compact('events', 'is_live', 'featured_courses', 'counts'));
    }
    public function events(){
        $events = Event::orderBy('date', 'asc')->paginate(9);
        return view('frontend.events.index', compact('events'));
    }

    public function eventSingle($id){
        $event = Event::findOrFail($id);
        return view('frontend.events.show', compact('event'));
    }

    public function contact(){
        return view('frontend.contact');
    }

    public function about(){
        return view('frontend.about');
    }

    public function live(){
        $live_settings = \App\Models\Setting::where('key', 'live_embed_code')->first();
        $is_live = \App\Models\Setting::where('key', 'is_live')->first();
        $source_type = \App\Models\Setting::where('key', 'live_source_type')->first();
        $playback_url = \App\Models\Setting::where('key', 'playback_url')->first();
        $latest_sermon = \App\Models\Event::where('status', 'past')->latest()->first();
        
        $next_event = \App\Models\Event::whereDate('date', '>=', now()->toDateString())
            ->whereTime('time', '>', now()->toTimeString())
            ->orderBy('date')
            ->orderBy('time')
            ->first();

        if (!$next_event) {
             $next_event = \App\Models\Event::whereDate('date', '>', now()->toDateString())
                ->orderBy('date')
                ->orderBy('time')
                ->first();
        }

        return view('frontend.live', compact('live_settings', 'is_live', 'source_type', 'playback_url', 'latest_sermon', 'next_event'));
    }

    public function calendar()
    {
        return view('frontend.calendar');
    }

    public function getEvents()
    {
        $events = \App\Models\Event::all();
        $calendarEvents = [];
        
        foreach($events as $event) {
            $startDate = \Carbon\Carbon::parse($event->date);
            $endDate = $event->end_date ? \Carbon\Carbon::parse($event->end_date) : $startDate->copy();
            $duration = $startDate->diffInMinutes(\Carbon\Carbon::parse($event->date . ' ' . $event->time)->addMinutes(120)); // Assume 2h if no end time

            $recurrence = $event->recurrence ?? 'none';
            
            if ($recurrence === 'none') {
                $calendarEvents[] = $this->formatCalendarEvent($event, $startDate);
            } else {
                // Generate occurrences for the next year
                $limit = \Carbon\Carbon::now()->addYear();
                $current = $startDate->copy();

                while ($current->lte($limit)) {
                    $calendarEvents[] = $this->formatCalendarEvent($event, $current);
                    
                    if ($recurrence === 'daily') {
                        $current->addDay();
                    } elseif ($recurrence === 'weekly') {
                        $current->addWeek();
                    } elseif ($recurrence === 'monthly') {
                        $current->addMonth();
                    } elseif ($recurrence === 'yearly') {
                        $current->addYear();
                    } else {
                        break;
                    }
                }
            }
        }
        return response()->json($calendarEvents);
    }

    private function formatCalendarEvent($event, $date)
    {
        return [
            'id' => $event->id,
            'title' => $event->title,
            'start' => $date->format('Y-m-d') . 'T' . $event->time,
            'end' => $date->format('Y-m-d') . 'T' . ($event->end_time ?? \Carbon\Carbon::parse($event->time)->addHours(2)->format('H:i:s')),
            'url' => route('event.single', $event->id),
            'color' => $event->status == 'comming' ? '#1754cf' : '#64748b',
            'extendedProps' => [
                'location' => $event->location,
                'type' => $event->type,
                'status' => $event->status,
                'description' => $event->description,
                'image' => $event->image ? asset('storage/'.$event->image) : null,
            ]
        ];
    }
}
