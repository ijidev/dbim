<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    public function index(){
        $events = Event::Where('status', 'comming')->get()->take(2);
        return view('frontend.pages.index', compact('events'));
    }
    public function events(){
        $events = Event::Where('status', 'comming')->get();
        return view('frontend.pages.events', compact('events'));
    }

    public function eventSingle($id){
        $event = Event::findOrFail($id);
        return view('frontend.pages.events-single', compact('event'));
    }

    public function contact(){
        return view('frontend.pages.contact');
    }

    public function about(){
        return view('frontend.pages.about');
    }
}
