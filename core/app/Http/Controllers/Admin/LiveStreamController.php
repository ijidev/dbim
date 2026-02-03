<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LiveStreamController extends Controller
{
    public function index()
    {
        $live_settings = \App\Models\Setting::where('key', 'live_embed_code')->first();
        $live_status = \App\Models\Setting::where('key', 'is_live')->first();
        return view('admin.livestream.index', compact('live_settings', 'live_status'));
    }

    public function update(Request $request)
    {
        \App\Models\Setting::updateOrCreate(
            ['key' => 'live_embed_code'],
            ['value' => $request->embed_code]
        );

        \App\Models\Setting::updateOrCreate(
            ['key' => 'is_live'],
            ['value' => $request->has('is_live') ? '1' : '0']
        );

        return back()->with('success', 'Live stream settings updated.');
    }
}
