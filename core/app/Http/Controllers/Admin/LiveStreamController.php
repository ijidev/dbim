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
        $source_type = \App\Models\Setting::where('key', 'live_source_type')->first();
        $stream_url = \App\Models\Setting::where('key', 'stream_server_url')->first();
        $stream_key = \App\Models\Setting::where('key', 'stream_key')->first();
        $playback_url = \App\Models\Setting::where('key', 'playback_url')->first();

        // Default stream URL if not set
        if (!$stream_url || !$stream_url->value) {
            $default_url = "rtmp://" . request()->getHost() . "/live";
        } else {
            $default_url = $stream_url->value;
        }

        // Generate initial key if none exists
        if (!$stream_key || !$stream_key->value) {
            $new_key = bin2hex(random_bytes(16));
            \App\Models\Setting::updateOrCreate(['key' => 'stream_key'], ['value' => $new_key]);
            $stream_key = (object)['value' => $new_key];
        }

        return view('admin.livestream.index', compact(
            'live_settings', 
            'live_status', 
            'source_type', 
            'stream_url', 
            'stream_key', 
            'playback_url',
            'default_url'
        ));
    }

    public function update(Request $request)
    {
        if ($request->has('regenerate_key')) {
            $new_key = bin2hex(random_bytes(16));
            \App\Models\Setting::updateOrCreate(['key' => 'stream_key'], ['value' => $new_key]);
            return back()->with('success', 'New stream key generated successfully.');
        }

        \App\Models\Setting::updateOrCreate(
            ['key' => 'live_source_type'],
            ['value' => $request->live_source_type ?? 'embed']
        );

        \App\Models\Setting::updateOrCreate(
            ['key' => 'live_embed_code'],
            ['value' => $request->embed_code]
        );

        \App\Models\Setting::updateOrCreate(
            ['key' => 'stream_server_url'],
            ['value' => $request->stream_server_url]
        );

        \App\Models\Setting::updateOrCreate(
            ['key' => 'playback_url'],
            ['value' => $request->playback_url]
        );

        \App\Models\Setting::updateOrCreate(
            ['key' => 'is_live'],
            ['value' => $request->has('is_live') ? '1' : '0']
        );

        return back()->with('success', 'Live stream settings updated.');
    }
}
