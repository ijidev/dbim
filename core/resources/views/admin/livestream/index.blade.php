@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Live Stream Management</h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Broadcast Settings</div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('livestream.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="embed_code" class="form-label">Embed Code / Live URL</label>
                        <textarea class="form-control" id="embed_code" name="embed_code" rows="5" placeholder="Paste YouTube/Facebook embed code here...">{{ $live_settings->value ?? '' }}</textarea>
                        <div class="form-text">Paste the full &lt;iframe&gt; code from YouTube or Facebook.</div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_live" name="is_live" value="1" {{ ($live_status->value ?? '0') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_live">We are currently LIVE</label>
                    </div>
                    <button type="submit" class="btn btn-danger">Update Stream System</button>
                </form>
            </div>
        </div>
        
        <div class="mt-4">
            <h5>Preview</h5>
            <div class="ratio ratio-16x9 border bg-light d-flex align-items-center justify-content-center">
                @if(isset($live_settings->value))
                    {!! $live_settings->value !!}
                @else
                    <span class="text-muted">No stream configured</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
