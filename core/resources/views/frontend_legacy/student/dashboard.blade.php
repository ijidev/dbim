@extends('frontend.layouts.homelayout')

@section('content')
<div class="container mt-5 mb-5" style="min-height: 50vh;">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h2>My Learning Dashboard</h2>
            <p>Welcome back, {{ Auth::user()->name }}!</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">My Courses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Enrolled Courses</div>
                <div class="card-body">
                    <div class="row">
                        @forelse($enrollments as $enrollment)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                @if($enrollment->course->thumbnail)
                                    <img src="{{ asset($enrollment->course->thumbnail) }}" class="card-img-top" alt="{{ $enrollment->course->title }}">
                                @else
                                    <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 150px;">
                                        <span>No Image</span>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $enrollment->course->title }}</h5>
                                    <p class="card-text small text-muted">Instructor: {{ $enrollment->course->instructor->name ?? 'DBIM' }}</p>
                                    <a href="{{ route('student.course.learn', $enrollment->course->id) }}" class="btn btn-primary btn-sm w-100">Continue Learning</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">You are not enrolled in any courses yet.</p>
                            <a href="{{ route('home') }}#courses" class="btn btn-outline-primary">Browse Courses</a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
