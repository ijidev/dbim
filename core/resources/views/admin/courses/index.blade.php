@extends('admin.layouts.app')

@section('title', 'Courses')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0;">All Courses</h2>
            <p style="color: #64748b; margin: 0.25rem 0 0;">Manage LMS courses and content</p>
        </div>
        <a href="{{ route('courses.create') }}" class="btn btn-primary">+ Create Course</a>
    </div>

    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="data-card">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th class="hide-mobile">Instructor</th>
                        <th>Price</th>
                        <th class="hide-mobile">Modules</th>
                        <th class="hide-mobile">Students</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                    <tr>
                        <td>
                            <div style="font-weight: 600;">{{ $course->title }}</div>
                            <div style="font-size: 0.8125rem; color: #64748b;">{{ Str::limit($course->description, 50) }}</div>
                        </td>
                        <td class="hide-mobile">{{ $course->instructor ? $course->instructor->name : 'Not assigned' }}</td>
                        <td style="font-weight: 600;">
                            @if($course->price > 0)
                                ₦{{ number_format($course->price, 2) }}
                            @else
                                <span style="color: #22c55e;">Free</span>
                            @endif
                        </td>
                        <td class="hide-mobile">{{ $course->modules->count() }}</td>
                        <td class="hide-mobile">{{ $course->enrollments->count() ?? 0 }}</td>
                        <td>
                            @if($course->is_published)
                                <span class="badge badge-success">Published</span>
                            @else
                                <span class="badge badge-warning">Draft</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('courses.content', $course->id) }}" class="btn btn-primary" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem;">Content</a>
                                <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-outline" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem;">Edit</a>
                                <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline" style="padding: 0.375rem 0.75rem; font-size: 0.8125rem; color: #ef4444; border-color: #fecaca;" onclick="return confirm('Delete this course?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 3rem; color: #94a3b8;">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">📚</div>
                            No courses found. <a href="{{ route('courses.create') }}" style="color: var(--primary-color); font-weight: 600;">Create your first course</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div style="margin-top: 1.5rem;">
        {{ $courses->links() }}
    </div>
@endsection
