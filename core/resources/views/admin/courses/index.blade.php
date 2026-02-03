@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Courses</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('courses.create') }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-plus-lg"></i> Create Course
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Price</th>
                <th>Instructor</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courses as $course)
            <tr>
                <td>{{ $course->title }}</td>
                <td>{{ $course->price > 0 ? '$'.number_format($course->price, 2) : 'Free' }}</td>
                <td>{{ $course->instructor ? $course->instructor->name : 'N/A' }}</td>
                <td>
                    <span class="badge bg-{{ $course->is_published ? 'success' : 'warning' }}">
                        {{ $course->is_published ? 'Published' : 'Draft' }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                    <a href="#" class="btn btn-sm btn-outline-info">Modules</a>
                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No courses found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $courses->links() }}
</div>
@endsection
