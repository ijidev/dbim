@extends('layouts.app')

@push('styles')
<style>
    .dashboard-header {
        background: white;
        border-bottom: 1px solid #e2e8f0;
        padding: 3rem 1rem;
    }
    .stats-card {
        background: white;
        padding: 1.5rem;
        border-radius: 1rem;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .stats-icon {
        width: 48px;
        height: 48px;
        background: #eff6ff;
        color: var(--primary-color);
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    .course-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    .student-course-card {
        background: white;
        border-radius: 1rem;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        transition: transform 0.2s;
    }
    .student-course-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    }
    .course-thumb {
        height: 160px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .course-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .course-details {
        padding: 1.5rem;
    }
    .instructor-meta {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        font-size: 0.85rem;
        color: #64748b;
    }
    .instructor-avatar {
        width: 24px;
        height: 24px;
        background: #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
    }
</style>
@endpush

@section('content')
<div class="dashboard-header">
    <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h1 style="font-size: 2.25rem; font-weight: 800; color: #1e293b; margin-bottom: 0.5rem;">My Learning</h1>
            <p style="color: #64748b; margin: 0;">Welcome back, <strong>{{ Auth::user()->name }}</strong>. Keep growing in faith and knowledge.</p>
        </div>
    </div>
</div>

<div style="max-width: 1200px; margin: 2rem auto; padding: 0 1rem;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
        <div class="stats-card">
            <div class="stats-icon">📘</div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 800; color: #1e293b;">{{ $enrollments->count() }}</div>
                <div style="font-size: 0.875rem; color: #64748b; font-weight: 500;">Active Courses</div>
            </div>
        </div>
        <div class="stats-card">
            <div class="stats-icon">✅</div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 800; color: #1e293b;">0</div>
                <div style="font-size: 0.875rem; color: #64748b; font-weight: 500;">Completed</div>
            </div>
        </div>
        <div class="stats-card">
            <div class="stats-icon">🏆</div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 800; color: #1e293b;">0</div>
                <div style="font-size: 0.875rem; color: #64748b; font-weight: 500;">Certificates</div>
            </div>
        </div>
    </div>

    <h2 style="font-size: 1.5rem; font-weight: 700; color: #1e293b;">Continue My Courses</h2>
    
    @if($enrollments->count() > 0)
        <div class="course-grid">
            @foreach($enrollments as $enrollment)
            <div class="student-course-card">
                <div class="course-thumb">
                    @if($enrollment->course->thumbnail)
                        <img src="{{ asset($enrollment->course->thumbnail) }}" alt="{{ $enrollment->course->title }}">
                    @else
                        <span style="font-size: 3rem; opacity: 0.2;">🎓</span>
                    @endif
                </div>
                <div class="course-details">
                    <div class="instructor-meta">
                        <div class="instructor-avatar">👤</div>
                        <span>{{ $enrollment->course->instructor->name ?? 'DBIM' }}</span>
                    </div>
                    <h3 style="font-size: 1.125rem; font-weight: 700; color: #1e293b; margin-bottom: 1.5rem; line-height: 1.4;">{{ $enrollment->course->title }}</h3>
                    <a href="{{ route('student.course.learn', $enrollment->course->id) }}" style="display: block; background: var(--primary-color); color: white; text-align: center; padding: 0.75rem; border-radius: 0.5rem; font-weight: 600; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#1a4ebd'" onmouseout="this.style.background='var(--primary-color)'">
                        Go to Lessons
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 4rem 1rem; background: white; border-radius: 1rem; border: 1px dashed #cbd5e1; margin-top: 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">📦</div>
            <p style="color: #64748b; font-size: 1.1rem; margin-bottom: 1.5rem;">You are not enrolled in any courses yet.</p>
            <a href="{{ route('index') }}#courses" style="background: var(--primary-color); color: white; padding: 0.75rem 2rem; border-radius: 0.5rem; font-weight: 600; text-decoration: none;">Browse Courses</a>
        </div>
    @endif
</div>
@endsection
