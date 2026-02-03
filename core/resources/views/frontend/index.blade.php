@extends('layouts.app')

@section('content')
<div style="min-height: 80vh; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; padding: 1rem;">
    <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; letter-spacing: -0.05em;">
        Coming Soon
    </h1>
    <p style="font-size: 1.125rem; color: #475569; max-width: 600px; line-height: 1.6;">
        We are rebuilding our digital experience to serve you better. <br>
        Mobile-first, live streaming, and interactive learning.
    </p>
    <div style="margin-top: 2rem; padding: 1rem 2rem; background-color: var(--primary-color); color: white; border-radius: 9999px; font-weight: 600;">
        New Experience Loading...
    </div>
</div>
@endsection
