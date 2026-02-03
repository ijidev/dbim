@extends('frontend.layouts.homelayout')
@section('content')
<div class="row hero-banner">
    <div class="card banner">
        <div class="card-body d-flex justify-content-center align-items-center" style="background-color: #000; min-height: 400px; color: #fff;">
            @if(isset($is_live->value) && $is_live->value == '1' && isset($live_settings->value))
                <div class="ratio ratio-16x9" style="width: 100%; max-width: 1000px;">
                    {!! $live_settings->value !!}
                </div>
            @else
                <div class="text-center">
                    <i class="bi bi-broadcast fs-1 mb-3"></i>
                    <h2>We are currently offline</h2>
                    <p>Join us for our next service.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="row p-4 mt-4 bg-white">
    <div class="col-md-12">
        <h3>Live Service Broadcast</h3>
        <p>Watch our services live from anywhere in the world. Join us in worship and the word.</p>
    </div>
</div>
@endsection
