@extends('layouts.app')

@section('title', $instructor->name . ' - Instructor Profile')

@push('styles')
<style>
    .profile-hero {
        background: white;
        border-bottom: 1px solid #e2e8f0;
        padding: 4rem 0;
    }
    .instructor-avatar {
        width: 120px;
        height: 120px;
        border-radius: 2rem;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 800;
        color: var(--primary-color);
        border: 4px solid white;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    .booking-card {
        background: white;
        border-radius: 2rem;
        padding: 2.5rem;
        border: 1px solid #e2e8f0;
        position: sticky;
        top: 2rem;
    }
    .form-input {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        margin-bottom: 1rem;
        font-family: inherit;
    }
    .form-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(23, 84, 207, 0.1);
    }
    .course-mini-card {
        background: white;
        border-radius: 1rem;
        padding: 1rem;
        border: 1px solid #f1f5f9;
        display: flex;
        gap: 1rem;
        align-items: center;
        transition: all 0.2s;
    }
    .course-mini-card:hover {
        border-color: var(--primary-color);
        transform: translateX(5px);
    }
</style>
@endpush

@section('content')
<div class="profile-hero">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center gap-8">
            <div class="instructor-avatar">
                {{ substr($instructor->name, 0, 1) }}
            </div>
            <div class="text-center md:text-left">
                <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                    <span class="px-3 py-1 bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest rounded-full">Certified Instructor</span>
                </div>
                <h1 class="text-4xl font-black text-slate-900 mb-2">{{ $instructor->name }}</h1>
                <p class="text-slate-500 text-lg max-w-2xl">{{ $instructor->bio ?? 'Business and Spiritual Mentor at Divine Business Impact Ministry. Helping you scale your impact and income.' }}</p>
                
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-6 mt-6">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">book</span>
                        <span class="text-sm font-bold text-slate-700">{{ $courses->count() }} Courses</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-500">groups</span>
                        <span class="text-sm font-bold text-slate-700">1.2k+ Students</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-6 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Left: About & Courses -->
        <div class="lg:col-span-2">
            <section class="mb-12">
                <h2 class="text-2xl font-black text-slate-900 mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined">description</span> About Instructor
                </h2>
                <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed">
                    <p>{{ $instructor->about ?? 'Dedicated to empowering the next generation of spiritual and business leaders. With years of experience in ministry and entrepreneurship, I bring a unique perspective to combining faith with professional excellence.' }}</p>
                </div>
            </section>

            <section>
                <h2 class="text-2xl font-black text-slate-900 mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined">library_books</span> Courses by {{ explode(' ', $instructor->name)[0] }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($courses as $course)
                    <a href="{{ route('student.course.learn', $course->id) }}" class="course-mini-card">
                        <img src="{{ $course->thumbnail ? asset('storage/'.$course->thumbnail) : 'https://placehold.co/100x100?text=Course' }}" class="size-16 rounded-lg object-cover">
                        <div>
                            <h4 class="font-black text-slate-900 leading-tight mb-1">{{ $course->title }}</h4>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $course->modules->count() }} Modules</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>
        </div>

        <!-- Right: Booking Form -->
        <div>
            <div class="booking-card shadow-2xl shadow-primary/5">
                <h3 class="text-xl font-black text-slate-900 mb-2">Book Private Session</h3>
                <p class="text-sm text-slate-500 mb-6">Schedule a one-on-one mentorship call to discuss your progress and goals.</p>

                @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 rounded-xl text-sm font-bold border border-emerald-100 italic">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('meeting.book') }}" method="POST">
                    @csrf
                    <input type="hidden" name="instructor_id" value="{{ $instructor->id }}">
                    
                    <div class="mb-4">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2 block">Session Title</label>
                        <input type="text" name="title" class="form-input" placeholder="e.g., Business Strategy Call" required>
                    </div>

                    <div class="mb-4">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2 block">Preferred Date & Time</label>
                        <input type="datetime-local" name="scheduled_at" class="form-input" required>
                    </div>

                    <div class="mb-6">
                        <label class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2 block">Brief Agenda</label>
                        <textarea name="description" class="form-input" rows="3" placeholder="What would you like to discuss?"></textarea>
                    </div>

                    <button type="submit" class="w-full py-4 bg-primary text-white rounded-xl text-sm font-black shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                        Request Booking
                    </button>
                    <p class="text-[10px] text-center text-slate-400 mt-4 uppercase tracking-tighter">Instructor will confirm via email/portal</p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
