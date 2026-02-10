@extends('layouts.app')

@section('title', 'Our Instructors - Grace LMS')

@push('styles')
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .instructor-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
@endpush

@section('content')
<main class="flex-1 bg-[#f6f6f8] min-h-screen">
    <div class="px-8 py-12 max-w-7xl mx-auto w-full">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
                <h1 class="text-4xl font-black text-slate-900 mb-3">Our Instructors</h1>
                <p class="text-slate-500 text-lg font-medium max-w-2xl">Learn from dedicated leaders and theologians committed to your spiritual and ministerial growth.</p>
            </div>
            <div class="flex bg-white p-1 rounded-xl border border-gray-200 shadow-sm">
                <button class="px-6 py-2 bg-primary text-white rounded-lg font-bold text-sm">All Mentors</button>
                <button class="px-6 py-2 text-slate-500 rounded-lg font-bold text-sm hover:bg-slate-50 transition-colors">By Topic</button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($instructors as $instructor)
            <div class="instructor-card bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm transition-all duration-300 flex flex-col group">
                <div class="aspect-[4/3] bg-slate-200 relative overflow-hidden">
                    @if($instructor->avatar)
                    <img src="{{ asset($instructor->avatar) }}" alt="{{ $instructor->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-slate-400 text-white text-4xl font-black">
                        {{ substr($instructor->name, 0, 1) }}
                    </div>
                    @endif
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-lg border border-white/20 shadow-lg text-[10px] font-black uppercase tracking-wider text-primary">
                        {{ $instructor->role }}
                    </div>
                </div>
                
                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-xl font-black text-slate-900 mb-1 group-hover:text-primary transition-colors">{{ $instructor->name }}</h3>
                    <p class="text-sm font-bold text-primary mb-4 uppercase tracking-tighter">{{ $instructor->headline ?? 'Spiritual Mentor' }}</p>
                    
                    <p class="text-xs text-slate-500 font-medium leading-relaxed mb-6 flex-1">
                        {{ Str::limit($instructor->bio ?? 'Dedicated to empowering the next generation of ministry leaders through biblical wisdom.', 100) }}
                    </p>
                    
                    <div class="grid grid-cols-2 border-t border-slate-100 pt-6 gap-4">
                        <div class="text-center border-r border-slate-100">
                            <p class="text-lg font-black text-slate-900">{{ $instructor->courses_count ?? $instructor->courses()->count() }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Courses</p>
                        </div>
                        <div class="text-center">
                            <p class="text-lg font-black text-slate-900">{{ number_format($instructor->rating ?? 5.0, 1) }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Rating</p>
                        </div>
                    </div>
                    
                    <div class="mt-8 flex gap-3">
                        <a href="{{ route('instructor.profile', $instructor->id) }}" class="flex-1 bg-primary text-white text-center py-3 rounded-xl text-xs font-black shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                            View Profile
                        </a>
                        <a href="{{ route('instructor.book', $instructor->id) }}" class="inline-flex items-center justify-center size-10 bg-slate-50 border border-slate-200 text-slate-400 rounded-xl hover:bg-primary/5 hover:text-primary hover:border-primary/20 transition-all">
                            <span class="material-symbols-outlined text-sm">calendar_month</span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>
@endsection
