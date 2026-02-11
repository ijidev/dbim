@extends('layouts.app')

@section('title', $course->title . ' - DBIM Academy')

@push('styles')
<style>
    .course-hero-bg {
        position: absolute;
        inset: 0;
        background-color: #0f172a;
        background-image: linear-gradient(to bottom, rgba(15, 23, 42, 0.8), #0f172a), url('{{ asset($course->thumbnail ?? "") }}');
        background-size: cover;
        background-position: center;
        z-index: 0;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
    <div class="course-hero-bg"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-6">
        <div class="max-w-3xl">
            <div class="flex flex-wrap gap-3 mb-6">
                <span class="bg-primary/20 text-blue-200 border border-blue-500/30 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider backdrop-blur-sm">
                    {{ $course->category ?? 'Course' }}
                </span>
                @if($course->price == 0)
                <span class="bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider backdrop-blur-sm">
                    Free
                </span>
                @endif
            </div>
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-6 leading-tight">
                {{ $course->title }}
            </h1>
            
            @if($course->description)
            <p class="text-lg text-slate-300 mb-8 leading-relaxed max-w-2xl">
                {{ Str::limit(strip_tags($course->description), 150) }}
            </p>
            @endif
            
            <div class="flex items-center gap-6 text-slate-300 font-medium text-sm">
                @if($course->instructor)
                <div class="flex items-center gap-3">
                    @if($course->instructor->avatar)
                        <img src="{{ asset('storage/'.$course->instructor->avatar) }}" alt="{{ $course->instructor->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-slate-700">
                    @else
                        <div class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center text-white font-bold border-2 border-slate-600">
                            {{ strtoupper(substr($course->instructor->name, 0, 2)) }}
                        </div>
                    @endif
                    <span>
                        <span class="block text-xs text-slate-400 uppercase tracking-wider">Instructor</span>
                        <a href="{{ route('instructor.profile', $course->instructor->id) }}" class="text-white hover:text-primary transition-colors">{{ $course->instructor->name }}</a>
                    </span>
                </div>
                @endif
                
                <div class="hidden sm:flex items-center gap-2">
                    <span class="material-symbols-outlined text-amber-400">star</span>
                    <span class="text-white">4.9</span>
                    <span class="text-slate-500">(120 reviews)</span>
                </div>
                
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-slate-400">schedule</span>
                    <span>{{ $totalLessons * 15 }}m approx</span> <!-- Mock duration -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-slate-50 min-h-screen pb-20">
    <div class="max-w-7xl mx-auto px-6 -mt-20 relative z-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Tabs (Optional, sticking to sections for now) -->
                
                <!-- About -->
                <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm">
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-primary flex items-center justify-center">
                            <span class="material-symbols-outlined">description</span>
                        </div>
                        About This Course
                    </h2>
                    <div class="prose prose-slate max-w-none prose-img:rounded-xl">
                        {!! nl2br($course->description) !!}
                    </div>
                </div>
                
                <!-- Curriculum -->
                <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-slate-900 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                                <span class="material-symbols-outlined">menu_book</span>
                            </div>
                            Curriculum
                        </h2>
                        <span class="text-sm font-bold text-slate-500">{{ $course->modules->count() }} Modules • {{ $totalLessons }} Lessons</span>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($course->modules as $module)
                        <div x-data="{ expanded: {{ $loop->first ? 'true' : 'false' }} }" class="border border-slate-200 rounded-xl overflow-hidden mb-4">
                            <button @click="expanded = !expanded" class="w-full flex items-center justify-between p-4 bg-slate-50 hover:bg-slate-100 transition-colors text-left">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-slate-400 transition-transform duration-200" :class="{ 'rotate-90': expanded }">chevron_right</span>
                                    <span class="font-bold text-slate-900">{{ $module->title }}</span>
                                </div>
                                <span class="text-xs font-bold text-slate-400 uppercase">{{ $module->lessons->count() }} Lessons</span>
                            </button>
                            
                            <div x-show="expanded" x-collapse class="divide-y divide-slate-100 bg-white">
                                @foreach($module->lessons as $lesson)
                                @if($isEnrolled)
                                <a href="{{ route('student.course.learn', ['course' => $course->id, 'lesson' => $lesson->id]) }}" class="p-4 pl-12 flex items-center justify-between group hover:bg-slate-50 transition-colors h-full">
                                @else
                                <div class="p-4 pl-12 flex items-center justify-between group hover:bg-slate-50 transition-colors cursor-default">
                                @endif
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded bg-slate-100 flex items-center justify-center text-slate-500 group-hover:bg-blue-50 group-hover:text-primary transition-colors">
                                            <span class="material-symbols-outlined text-lg">
                                                {{ ($lesson->type ?? 'video') === 'quiz' ? 'quiz' : 'play_circle' }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-slate-700 group-hover:text-slate-900">{{ $lesson->title }}</p>
                                            @if($lesson->duration)
                                            <p class="text-xs text-slate-400">{{ $lesson->duration }} min</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if(!$isEnrolled && !$course->is_free)
                                    <span class="material-symbols-outlined text-slate-300 text-sm">lock</span>
                                    @endif
                                @if($isEnrolled)
                                </a>
                                @else
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        @empty
                        <p class="text-slate-500 italic text-center py-4">No modules available yet.</p>
                        @endforelse
                    </div>
                </div>
                
                <!-- Instructor -->
                @if($course->instructor)
                <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm">
                     <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <span class="material-symbols-outlined">person</span>
                        </div>
                        Instructor
                    </h2>
                    
                    <div class="flex flex-col sm:flex-row gap-6">
                        <a href="{{ route('instructor.profile', $course->instructor->id) }}" class="shrink-0 group relative">
                            @if($course->instructor->avatar)
                                <img src="{{ asset('storage/'.$course->instructor->avatar) }}" alt="{{ $course->instructor->name }}" class="w-24 h-24 rounded-2xl object-cover shadow-md group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-24 h-24 rounded-2xl bg-slate-800 flex items-center justify-center text-white font-black text-2xl shadow-md group-hover:scale-105 transition-transform duration-300">
                                    {{ strtoupper(substr($course->instructor->name, 0, 2)) }}
                                </div>
                            @endif
                        </a>
                        <div class="flex-1">
                             <a href="{{ route('instructor.profile', $course->instructor->id) }}" class="text-lg font-bold text-slate-900 hover:text-primary transition-colors mb-1 inline-block">
                                {{ $course->instructor->name }}
                            </a>
                            <p class="text-slate-500 text-sm font-medium uppercase tracking-wider mb-4">{{ $course->instructor->role }} at DBIM</p>
                            
                            @if($course->instructor->bio)
                            <p class="text-slate-600 leading-relaxed mb-4">{{ Str::limit($course->instructor->bio, 300) }}</p>
                            @endif
                            
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-1.5 text-slate-500 text-sm font-medium">
                                    <span class="material-symbols-outlined text-amber-500 text-lg">star</span>
                                    4.9 Instructor Rating
                                </div>
                                <div class="flex items-center gap-1.5 text-slate-500 text-sm font-medium">
                                    <span class="material-symbols-outlined text-primary text-lg">school</span>
                                    1,203 Students
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column (Sticky Sidebar) -->
            <div class="lg:col-span-1">
                <div class="sticky top-24 space-y-6">
                    <!-- Enrollment Card -->
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xl shadow-slate-200/50 overflow-hidden relative">
                         <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary via-purple-500 to-pink-500"></div>
                        
                        <div class="mb-6">
                            @if($course->price > 0)
                            <div class="flex items-end gap-2 mb-1">
                                <span class="text-4xl font-black text-slate-900">₦{{ number_format($course->price) }}</span>
                            </div>
                            <p class="text-slate-500 text-sm font-medium">One-time payment • Lifetime access</p>
                            @else
                            <div class="flex items-end gap-2 mb-1">
                                <span class="text-4xl font-black text-emerald-600">Free</span>
                            </div>
                            <p class="text-slate-500 text-sm font-medium">Free enrollment • Full access</p>
                            @endif
                        </div>
                        
                        @if($isEnrolled)
                        <a href="{{ route('student.course.learn', $course) }}" class="block w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl text-center shadow-lg shadow-emerald-600/20 transition-all hover:-translate-y-1 mb-4 flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">play_circle</span>
                            Continue Learning
                        </a>
                        @else
                        <form action="{{ route('enrollment.enroll') }}" method="POST">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <button type="submit" class="w-full bg-primary hover:bg-blue-700 text-white font-bold py-4 rounded-xl text-center shadow-lg shadow-primary/20 transition-all hover:-translate-y-1 mb-4 flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">school</span>
                                {{ $course->price > 0 ? 'Buy Course' : 'Enroll Now' }}
                            </button>
                        </form>
                        @endif
                        
                        @if(!$isEnrolled)
                        <p class="text-center text-xs text-slate-400 mb-6">30-Day Money-Back Guarantee</p>
                        @endif
                        
                        <div class="space-y-4 pt-6 border-t border-slate-100">
                             <h4 class="font-bold text-xs text-slate-900 uppercase tracking-widest mb-2">This course includes:</h4>
                             <ul class="space-y-3">
                                 <li class="flex items-center gap-3 text-sm text-slate-600">
                                     <span class="material-symbols-outlined text-primary text-lg">videocam</span>
                                     <span>{{ $totalLessons }} video lessons</span>
                                 </li>
                                 <li class="flex items-center gap-3 text-sm text-slate-600">
                                     <span class="material-symbols-outlined text-primary text-lg">folder_zip</span>
                                     <span>{{ $course->modules->count() }} downloadable resources</span>
                                 </li>
                                 <li class="flex items-center gap-3 text-sm text-slate-600">
                                     <span class="material-symbols-outlined text-primary text-lg">all_inclusive</span>
                                     <span>Full lifetime access</span>
                                 </li>
                                 <li class="flex items-center gap-3 text-sm text-slate-600">
                                     <span class="material-symbols-outlined text-primary text-lg">devices</span>
                                     <span>Access on mobile and TV</span>
                                 </li>
                                 <li class="flex items-center gap-3 text-sm text-slate-600">
                                     <span class="material-symbols-outlined text-primary text-lg">card_membership</span>
                                     <span>Certificate of completion</span>
                                 </li>
                             </ul>
                        </div>
                    </div>
                    
                    <!-- Related Courses -->
                    @if($relatedCourses->count() > 0)
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                        <h3 class="font-bold text-slate-900 mb-4">Related Courses</h3>
                        <div class="space-y-4">
                            @foreach($relatedCourses as $related)
                            <a href="{{ route('course.show', $related) }}" class="flex gap-4 group">
                                <div class="w-20 h-16 rounded-lg bg-slate-100 overflow-hidden shrink-0">
                                    <img src="{{ asset($related->thumbnail ?? 'assets/images/courses/default.jpg') }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-slate-900 text-sm leading-tight truncate group-hover:text-primary transition-colors">{{ $related->title }}</h4>
                                    <p class="text-xs text-slate-500 mt-1">{{ $related->category ?? 'General' }}</p>
                                    <p class="text-xs font-bold text-primary mt-1">{{ $related->price > 0 ? '₦'.number_format($related->price) : 'Free' }}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add any specific course landing page scripts here if needed
</script>
@endpush
