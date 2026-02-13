@extends('layouts.instructor')

@section('title', 'My Courses')
@section('page_title', 'Course Portfolio Management')

@section('instructor_content')
<div class="space-y-12">
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 leading-tight">Your Courses</h1>
            <p class="text-slate-500 font-medium">Manage your curriculum, track student progress, and publish new content.</p>
        </div>
        <a href="{{ route('instructor.courses.create') }}" class="h-14 px-8 bg-primary text-white rounded-[1.25rem] text-sm font-black flex items-center gap-3 shadow-xl shadow-primary/20 hover:scale-105 transition-all">
            <span class="material-symbols-outlined text-xl">add_box</span>
            CREATE NEW COURSE
        </a>
    </div>

    <!-- Course Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($courses as $course)
        <div class="bg-white rounded-[2.5rem] border border-[#dcdfe5] shadow-sm overflow-hidden group hover:shadow-2xl hover:shadow-primary/5 transition-all flex flex-col">
            <!-- Thumbnail -->
            <div class="relative aspect-video overflow-hidden">
                <img src="{{ $course->thumbnail ? asset('storage/'.$course->thumbnail) : 'https://images.unsplash.com/photo-1501504905252-473c47e087f8?auto=format&fit=crop&q=80&w=800' }}" 
                     alt="{{ $course->title }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute top-4 left-4">
                    <span class="px-3 py-1.5 bg-white/90 backdrop-blur-md rounded-lg text-[10px] font-black text-primary uppercase tracking-widest shadow-sm">
                        {{ $course->level ?? 'Open Level' }}
                    </span>
                </div>
                <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between text-white">
                    <p class="text-[10px] font-black uppercase tracking-widest flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-xs">category</span>
                        {{ $course->category ?? 'General' }}
                    </p>
                    <span class="px-2 py-0.5 bg-accent text-white text-[9px] font-black rounded-full uppercase">
                        {{ $course->status ?? 'Active' }}
                    </span>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8 flex-1 flex flex-col">
                <div class="flex-1">
                    <h3 class="text-xl font-black text-slate-900 group-hover:text-primary transition-colors leading-tight mb-4">
                        {{ $course->title }}
                    </h3>
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="space-y-1">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Students</p>
                            <p class="text-sm font-black text-slate-700 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-lg">groups</span>
                                {{ $course->enrollments_count ?? 0 }}
                            </p>
                        </div>
                        <div class="space-y-1 text-right">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Price</p>
                            <p class="text-sm font-black text-accent">
                                @if($course->is_free)
                                    FREE
                                @else
                                    ${{ number_format($course->price, 2) }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                    <a href="{{ route('instructor.courses.edit', $course->id) }}" class="h-11 px-5 bg-slate-50 rounded-xl text-[10px] font-black text-slate-600 hover:bg-primary hover:text-white transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-base">edit</span>
                        SETTINGS
                    </a>
                    <a href="{{ route('instructor.courses.content', $course->id) }}" class="h-11 px-5 bg-primary/10 rounded-xl text-[10px] font-black text-primary hover:bg-primary hover:text-white transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-base font-bold">menu_book</span>
                        CURRICULUM
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-32 text-center">
            <div class="size-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center text-slate-200 mx-auto mb-8">
                <span class="material-symbols-outlined text-5xl font-light">library_add</span>
            </div>
            <h3 class="text-2xl font-black text-slate-900">Your portfolio is empty</h3>
            <p class="text-slate-500 max-w-sm mx-auto mt-4 font-medium italic">"Write the vision and make it plain." — Habakkuk 2:2</p>
            <div class="mt-10">
                <a href="{{ route('instructor.courses.create') }}" class="inline-flex h-14 px-10 bg-primary text-white rounded-[1.25rem] text-sm font-black items-center gap-3 shadow-xl shadow-primary/20 hover:scale-105 transition-all">
                    START YOUR FIRST COURSE
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-12 flex justify-center">
        {{ $courses->links() }}
    </div>
</div>
@endsection
