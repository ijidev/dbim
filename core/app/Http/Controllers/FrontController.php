<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    public function index(){
        $events = Event::Where('status', 'comming')->get()->take(2);
        return view('frontend.index', compact('events'));
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
        
        return view('frontend.live', compact('live_settings', 'is_live', 'source_type', 'playback_url'));
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
            $calendarEvents[] = [
                'title' => $event->title,
                'start' => $event->date . 'T' . $event->time,
                'end' => $event->end_date ? ($event->end_date . 'T' . ($event->end_time ?? '23:59:00')) : null,
                'url' => route('event.single', $event->id),
                'color' => $event->status == 'comming' ? '#28a745' : '#6c757d',
            ];
        }
        return response()->json($calendarEvents);
    }
}
