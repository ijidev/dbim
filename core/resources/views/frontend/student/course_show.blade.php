@extends('layouts.app')

@section('title', $course->title . ' - DBIM Academy')

@push('styles')
<style>
    .course-hero {
        background: linear-gradient(135deg, #0a192f 0%, #1754cf 100%);
        position: relative;
        min-height: 360px;
        display: flex;
        align-items: flex-end;
        padding-bottom: 48px;
    }
    
    .course-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url('{{ asset($course->thumbnail ?? "") }}') center/cover;
        opacity: 0.15;
    }
    
    .course-hero-content {
        position: relative;
        z-index: 2;
    }
    
    .course-badge {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.2);
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: white;
    }
    
    .course-badge.free {
        background: rgba(34, 197, 94, 0.2);
        border-color: rgba(34, 197, 94, 0.3);
        color: #22c55e;
    }
    
    .course-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 32px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
    }
    
    @media (min-width: 1024px) {
        .course-grid {
            grid-template-columns: 2fr 1fr;
        }
    }
    
    .course-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #e5e7eb;
    }
    
    .curriculum-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 0;
        border-bottom: 1px solid #f1f5f9;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .curriculum-item:hover {
        background: #f8fafc;
        margin: 0 -16px;
        padding-left: 16px;
        padding-right: 16px;
        border-radius: 8px;
    }
    
    .curriculum-item:last-child {
        border-bottom: none;
    }
    
    .curriculum-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(23, 84, 207, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        flex-shrink: 0;
    }
    
    .curriculum-icon.video {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }
    
    .curriculum-icon.text {
        background: rgba(34, 197, 94, 0.1);
        color: #22c55e;
    }
    
    .curriculum-icon.quiz {
        background: rgba(168, 85, 247, 0.1);
        color: #a855f7;
    }
    
    .module-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px;
        background: #f8fafc;
        border-radius: 12px;
        margin-bottom: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .module-header:hover {
        background: #f1f5f9;
    }
    
    .enroll-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #e5e7eb;
        position: sticky;
        top: 96px;
    }
    
    .price-tag {
        font-size: 32px;
        font-weight: 900;
        color: var(--text-main);
    }
    
    .price-tag.free {
        color: #22c55e;
    }
    
    .enroll-btn {
        width: 100%;
        padding: 16px 24px;
        background: var(--primary);
        color: white;
        font-size: 16px;
        font-weight: 700;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
    }
    
    .enroll-btn:hover {
        background: #1346b0;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(23, 84, 207, 0.3);
    }
    
    .enroll-btn.enrolled {
        background: #22c55e;
    }
    
    .feature-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .feature-item:last-child {
        border-bottom: none;
    }
    
    .instructor-card {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: #f8fafc;
        border-radius: 12px;
        transition: all 0.2s;
    }
    
    .instructor-card:hover {
        background: #f1f5f9;
    }
    
    .related-course {
        display: flex;
        gap: 16px;
        padding: 16px 0;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s;
    }
    
    .related-course:hover {
        background: #f8fafc;
        margin: 0 -16px;
        padding-left: 16px;
        padding-right: 16px;
    }
    
    .related-course:last-child {
        border-bottom: none;
    }
    
    .related-thumb {
        width: 80px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="course-hero">
    <div class="course-hero-content w-full max-w-6xl mx-auto px-6">
        <div class="flex flex-wrap gap-3 mb-4">
            <span class="course-badge">
                <span class="material-symbols-outlined text-sm mr-1">school</span>
                {{ $course->modules->count() }} Modules
            </span>
            <span class="course-badge">
                <span class="material-symbols-outlined text-sm mr-1">play_circle</span>
                {{ $totalLessons }} Lessons
            </span>
            @if($course->price == 0)
            <span class="course-badge free">Free Course</span>
            @endif
        </div>
        
        <h1 class="text-3xl md:text-4xl font-black text-white mb-4 max-w-3xl">{{ $course->title }}</h1>
        
        @if($course->description)
        <p class="text-white/80 text-lg max-w-2xl mb-6">{{ Str::limit($course->description, 200) }}</p>
        @endif
        
        @if($course->instructor)
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-bold">
                {{ strtoupper(substr($course->instructor->name, 0, 2)) }}
            </div>
            <div>
                <p class="text-white font-semibold">{{ $course->instructor->name }}</p>
                <p class="text-white/60 text-sm capitalize">{{ $course->instructor->role }}</p>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Main Content -->
<div class="py-10 bg-slate-50">
    <div class="course-grid">
        <!-- Left Column - Curriculum -->
        <div class="space-y-8">
            <!-- About -->
            <div class="course-card">
                <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">info</span>
                    About This Course
                </h2>
                <div class="text-slate-600 leading-relaxed">
                    {!! nl2br(e($course->description)) !!}
                </div>
            </div>
            
            <!-- Curriculum -->
            <div class="course-card">
                <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">menu_book</span>
                    Course Curriculum
                </h2>
                
                @forelse($course->modules as $module)
                <div class="mb-4">
                    <div class="module-header" onclick="this.parentElement.classList.toggle('collapsed')">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">folder</span>
                            <div>
                                <h3 class="font-bold">{{ $module->title }}</h3>
                                <p class="text-sm text-slate-500">{{ $module->lessons->count() }} lessons</p>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-slate-400 transition-transform module-chevron">expand_more</span>
                    </div>
                    
                    <div class="module-content pl-4">
                        @foreach($module->lessons as $index => $lesson)
                        <div class="curriculum-item">
                            <span class="font-bold text-slate-400 text-sm w-6">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <div class="curriculum-icon {{ $lesson->type ?? 'video' }}">
                                @if(($lesson->type ?? 'video') === 'video')
                                <span class="material-symbols-outlined">play_circle</span>
                                @elseif(($lesson->type ?? 'video') === 'quiz')
                                <span class="material-symbols-outlined">quiz</span>
                                @else
                                <span class="material-symbols-outlined">description</span>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="font-medium">{{ $lesson->title }}</p>
                                @if($lesson->duration)
                                <p class="text-sm text-slate-500">{{ $lesson->duration }} min</p>
                                @endif
                            </div>
                            @if(!$isEnrolled && !$course->is_free)
                            <span class="material-symbols-outlined text-slate-300">lock</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-slate-500">
                    <span class="material-symbols-outlined text-4xl mb-2">folder_off</span>
                    <p>No curriculum available yet.</p>
                </div>
                @endforelse
            </div>
            
            <!-- Instructor -->
            @if($course->instructor)
            <div class="course-card">
                <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">person</span>
                    Your Instructor
                </h2>
                <a href="{{ route('instructor.profile', $course->instructor->id) }}" class="instructor-card">
                    <div class="w-16 h-16 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-bold text-xl">
                        {{ strtoupper(substr($course->instructor->name, 0, 2)) }}
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-lg">{{ $course->instructor->name }}</h3>
                        <p class="text-sm text-slate-500 capitalize">{{ $course->instructor->role }}</p>
                        @if($course->instructor->bio)
                        <p class="text-sm text-slate-600 mt-2">{{ Str::limit($course->instructor->bio, 100) }}</p>
                        @endif
                    </div>
                    <span class="material-symbols-outlined text-slate-400">arrow_forward</span>
                </a>
            </div>
            @endif
        </div>
        
        <!-- Right Column - Enroll Card -->
        <div>
            <div class="enroll-card">
                <!-- Price -->
                <div class="mb-6">
                    @if($course->price > 0)
                    <p class="price-tag">₦{{ number_format($course->price) }}</p>
                    <p class="text-sm text-slate-500">One-time payment</p>
                    @else
                    <p class="price-tag free">Free</p>
                    <p class="text-sm text-slate-500">No payment required</p>
                    @endif
                </div>
                
                <!-- Enroll Button -->
                @if($isEnrolled)
                <a href="{{ route('student.course.learn', $course) }}" class="enroll-btn enrolled">
                    <span class="material-symbols-outlined">play_circle</span>
                    Continue Learning
                </a>
                @else
                <form action="{{ route('enrollment.enroll') }}" method="POST">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <button type="submit" class="enroll-btn">
                        <span class="material-symbols-outlined">school</span>
                        Enroll Now
                    </button>
                </form>
                @endif
                
                <!-- Features -->
                <div class="mt-6 pt-6 border-t border-slate-100">
                    <h4 class="font-bold text-sm text-slate-500 uppercase tracking-wider mb-4">What's Included</h4>
                    
                    <div class="feature-item">
                        <span class="material-symbols-outlined text-primary">folder</span>
                        <span class="text-sm">{{ $course->modules->count() }} learning modules</span>
                    </div>
                    <div class="feature-item">
                        <span class="material-symbols-outlined text-primary">play_circle</span>
                        <span class="text-sm">{{ $totalLessons }} video lessons</span>
                    </div>
                    <div class="feature-item">
                        <span class="material-symbols-outlined text-primary">all_inclusive</span>
                        <span class="text-sm">Lifetime access</span>
                    </div>
                    <div class="feature-item">
                        <span class="material-symbols-outlined text-primary">devices</span>
                        <span class="text-sm">Access on all devices</span>
                    </div>
                    <div class="feature-item">
                        <span class="material-symbols-outlined text-primary">workspace_premium</span>
                        <span class="text-sm">Certificate of completion</span>
                    </div>
                </div>
            </div>
            
            <!-- Related Courses -->
            @if($relatedCourses->count() > 0)
            <div class="course-card mt-6">
                <h4 class="font-bold mb-4">Related Courses</h4>
                
                @foreach($relatedCourses as $related)
                <a href="{{ route('course.show', $related) }}" class="related-course block">
                    <img src="{{ asset($related->thumbnail ?? 'assets/images/courses/default.jpg') }}" 
                         alt="{{ $related->title }}"
                         class="related-thumb"
                         onerror="this.src='https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=600&h=400&fit=crop'">
                    <div class="flex-1 min-w-0">
                        <h5 class="font-bold text-sm truncate">{{ $related->title }}</h5>
                        <p class="text-xs text-slate-500">{{ $related->instructor->name ?? 'DBIM' }}</p>
                        <p class="text-sm font-bold text-primary mt-1">
                            @if($related->price > 0)
                            ₦{{ number_format($related->price) }}
                            @else
                            Free
                            @endif
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Module collapse/expand
    const moduleHeaders = document.querySelectorAll('.module-header');
    moduleHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const content = this.nextElementSibling;
            const chevron = this.querySelector('.module-chevron');
            
            if (content.style.display === 'none') {
                content.style.display = 'block';
                chevron.style.transform = 'rotate(0deg)';
            } else {
                content.style.display = 'none';
                chevron.style.transform = 'rotate(-90deg)';
            }
        });
    });
});
</script>
@endpush
