@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Events</div>
            <div class="card-body">
                <h5 class="card-title">0 Active</h5>
                <p class="card-text">Upcoming events.</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">Courses</div>
            <div class="card-body">
                <h5 class="card-title">0 Published</h5>
                <p class="card-text">Available courses.</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning mb-3">
            <div class="card-header">Students</div>
            <div class="card-body">
                <h5 class="card-title">0 Enrolled</h5>
                <p class="card-text">Active learners.</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-danger mb-3">
            <div class="card-header">Live</div>
            <div class="card-body">
                <h5 class="card-title">Offline</h5>
                <p class="card-text">Current stream status.</p>
            </div>
        </div>
    </div>
</div>
@endsection
