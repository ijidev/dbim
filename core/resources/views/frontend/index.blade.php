@extends('layouts.app')

@section('title', 'Empowering Believers for Kingdom Impact')

@push('styles')
<style>
    .fill-1 { font-variation-settings: 'FILL' 1; }
    
    .waveform-bar {
        width: 3px;
        background-color: var(--primary);
        border-radius: 1px;
        margin: 0 1px;
    }
</style>
@endpush

@section('content')
<main class="flex-1">
    <!-- Hero Section -->
    <section class="relative w-full overflow-hidden bg-slate-900 py-12 lg:py-24 min-h-[85vh] flex items-center">
        <!-- Background Overlay -->
        <div class="absolute inset-0 opacity-40">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
            <div class="w-full h-full bg-center bg-cover" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBpTnpaZtZPjvqFPHfeAj-5iVajQQnavIxgFAwQohXrZK2r4Y1mZ4WuZmYQsWCbGRNyViLSWOfMs98md4Wz8G72wBqNTCAVDXLlGFQMwhGEPypd6rdimHgMfzV462sdL00MWhC0In4Dq7OlVcGcEgOGixLap2bgcJn46bW7nK6TocckUEGNYDigrSAWGIfpmU9AKBZ4uVzBQniwirFpxE5RcaSTq2zRKNRBNLtfH1cz9mKogCxk5pdnYTy2iOh3GVW7Ub_wFaxcSMQ9');"></div>
        </div>

        <div class="relative mx-auto max-w-[1280px] px-6 lg:px-10 text-center flex flex-col items-center gap-8">
            @if(($is_live->value ?? '0') == '1')
            <a href="{{ route('live') }}" class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-red-500/10 border border-red-500/20 backdrop-blur-sm animate-bounce">
                <span class="size-2 rounded-full bg-red-500"></span>
                <span class="text-xs font-bold text-red-500 uppercase tracking-widest">WE ARE LIVE NOW</span>
            </a>
            @else
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 backdrop-blur-sm">
                <span class="size-2 rounded-full bg-amber-500"></span>
                <span class="text-xs font-bold text-white uppercase tracking-widest">Divine Business Impact Ministry</span>
            </div>
            @endif

            <h1 class="text-white text-5xl md:text-7xl lg:text-8xl font-black leading-[1.1] tracking-tight max-w-4xl">
                Raising <span class="text-primary italic">God's</span> Among Men
            </h1>
            
            <p class="text-white/70 text-lg md:text-xl max-w-2xl font-light leading-relaxed">
                Empowering believers for spiritual and kingdom impact through spiritual mastery, leadership development, and impact-driven faith.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 mt-4 w-full sm:w-auto">
                <a href="{{ route('live') }}" class="bg-primary text-white px-10 h-14 rounded-xl font-bold flex items-center justify-center gap-3 text-lg hover:shadow-2xl hover:shadow-primary/40 transition-all hover:scale-105">
                    <span class="material-symbols-outlined">play_circle</span>
                    Watch Live Service
                </a>
                <a href="{{ route('event') }}" class="bg-white/10 backdrop-blur-md text-white border border-white/20 px-10 h-14 rounded-xl font-bold flex items-center justify-center gap-3 text-lg hover:bg-white/20 transition-all">
                    Upcoming Events
                </a>
            </div>

            <div class="mt-12 flex items-center gap-6 text-white/50">
                <div class="flex -space-x-3">
                    <div class="size-10 rounded-full border-2 border-slate-900 bg-slate-300"></div>
                    <div class="size-10 rounded-full border-2 border-slate-900 bg-slate-400"></div>
                    <div class="size-10 rounded-full border-2 border-slate-900 bg-slate-500"></div>
                    <div class="size-10 rounded-full border-2 border-slate-900 bg-primary flex items-center justify-center text-[10px] font-bold text-white">+{{ $counts['students'] ?? '0' }}</div>
                </div>
                <p class="text-sm font-medium">Joined the Discipleship Academy</p>
            </div>
        </div>
    </section>

    <!-- Ministry Features Grid -->
    <section class="py-24 mx-auto max-w-[1280px] px-6 lg:px-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <a href="{{ route('calendar') }}" class="group bg-white p-8 rounded-2xl border border-slate-100 hover:border-primary/20 hover:shadow-xl transition-all">
                <div class="size-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">calendar_month</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Events & Calendar</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Stay updated with our latest conferences, services, and gatherings.</p>
            </a>

            <a href="{{ route('store.index') }}" class="group bg-white p-8 rounded-2xl border border-slate-100 hover:border-primary/20 hover:shadow-xl transition-all">
                <div class="size-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-6 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">shopping_bag</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Ministry Store</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Browse our collection of books, merchandise, and spiritual resources.</p>
            </a>

            <a href="{{ route('library.index') }}" class="group bg-white p-8 rounded-2xl border border-slate-100 hover:border-primary/20 hover:shadow-xl transition-all">
                <div class="size-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center mb-6 group-hover:bg-green-500 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">menu_book</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Digital Library</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Read impactful books and articles directly in your browser.</p>
            </a>

            <a href="{{ route('donate') }}" class="group bg-white p-8 rounded-2xl border border-slate-100 hover:border-primary/20 hover:shadow-xl transition-all">
                <div class="size-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center mb-6 group-hover:bg-red-500 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined">favorite</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Give & Support</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Partner with us to advance the Kingdom through your generosity.</p>
            </a>
        </div>
    </section>

    <!-- Recent Sermons / Live Feed Section -->
    <section class="py-24 bg-slate-50">
        <div class="mx-auto max-w-[1280px] px-6 lg:px-10">
            <div class="flex items-end justify-between mb-12 border-b border-slate-200 pb-8">
                <div>
                    <span class="text-primary font-bold text-sm uppercase tracking-widest block mb-1">Watch & Learn</span>
                    <h2 class="text-4xl font-black text-slate-900">Featured Ministry Content</h2>
                </div>
                <a href="{{ route('live') }}" class="text-primary font-bold text-sm flex items-center gap-1 group">
                    Go to Live Stream <span class="material-symbols-outlined transition-transform group-hover:translate-x-1">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($featured_courses as $course)
                <div class="group flex flex-col gap-4">
                    <div class="relative aspect-video rounded-2xl overflow-hidden bg-slate-200 shadow-lg">
                        <img src="{{ asset('storage/'.$course->thumbnail) }}" onerror="this.src='https://placehold.co/600x400?text=No+Image'" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $course->title }}">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors flex items-center justify-center">
                            <a href="{{ route('student.course.learn', $course->id) }}" class="size-16 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white scale-90 group-hover:scale-100 transition-transform">
                                <span class="material-symbols-outlined text-4xl fill-1">play_arrow</span>
                            </a>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-primary uppercase tracking-widest mb-1">Course</p>
                        <h3 class="text-2xl font-bold leading-tight group-hover:text-primary transition-colors cursor-pointer text-slate-900">
                            <a href="{{ route('student.course.learn', $course->id) }}">{{ $course->title }}</a>
                        </h3>
                        <p class="text-slate-500 text-sm mt-2 line-clamp-2">{{ Str::limit($course->description, 100) }}</p>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12 bg-white rounded-3xl border border-dashed border-slate-200">
                    <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">school</span>
                    <p class="text-slate-500 font-medium">New ministry content coming soon.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Upcoming Events Grid -->
    <section class="py-24 mx-auto max-w-[1280px] px-6 lg:px-10">
        <div class="flex flex-col items-center text-center mb-16">
            <span class="text-primary font-bold text-sm uppercase tracking-widest block mb-2">Save the Date</span>
            <h2 class="text-5xl font-black text-slate-900">Upcoming Gatherings</h2>
            <p class="text-slate-500 max-w-xl mt-4 text-lg">Be part of our vibrant community. From spiritual retreats to leadership workshops, there's a place for you.</p>
        </div>

        <div class="space-y-6">
            @forelse($events as $event)
            <div class="group bg-white p-6 rounded-3xl border border-slate-100 flex flex-col md:flex-row items-center gap-8 hover:shadow-2xl transition-all hover:border-primary/20">
                <div class="flex flex-col items-center justify-center size-28 rounded-2xl bg-primary text-white flex-shrink-0 shadow-xl shadow-primary/20">
                    <span class="text-3xl font-black">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                    <span class="text-xs font-bold uppercase tracking-widest">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</span>
                </div>
                <div class="flex-1 text-center md:text-left">
                    <div class="flex flex-wrap justify-center md:justify-start items-center gap-3 mb-2">
                        <span class="text-xs font-bold text-primary uppercase bg-primary/5 px-3 py-1 rounded-full border border-primary/10">Special Event</span>
                        <span class="text-xs text-slate-400 font-bold flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">schedule</span> {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}
                        </span>
                        <span class="text-xs text-slate-400 font-bold flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">location_on</span> {{ $event->location ?? 'Main Sanctuary' }}
                        </span>
                    </div>
                    <h3 class="text-3xl font-black text-slate-900">{{ $event->title }}</h3>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                    <a href="{{ route('event.single', $event->id) }}" class="px-8 h-14 rounded-xl border-2 border-slate-100 font-bold hover:bg-slate-50 transition-all flex items-center justify-center">Details</a>
                    <a href="{{ route('event.single', $event->id) }}#register" class="px-10 h-14 rounded-xl bg-primary text-white font-bold hover:scale-105 active:scale-95 transition-all shadow-lg shadow-primary/20 flex items-center justify-center">Join Event</a>
                </div>
            </div>
            @empty
            <div class="text-center py-20 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                <span class="material-symbols-outlined text-6xl text-slate-300 mb-4 font-light">calendar_today</span>
                <p class="text-slate-500 font-medium">No upcoming events scheduled at the moment.</p>
                <a href="{{ route('event') }}" class="text-primary font-bold mt-4 inline-block hover:underline">Check Full Calendar</a>
            </div>
            @endforelse
        </div>
    </section>

    <!-- Discipleship Academy CTA -->
    <section class="py-24 bg-primary relative overflow-hidden">
        <div class="absolute inset-0 bg-slate-900/10"></div>
        <div class="absolute -top-24 -right-24 size-96 bg-white/10 rounded-full blur-3xl"></div>
        <div class="mx-auto max-w-[1280px] px-6 lg:px-10 flex flex-col items-center text-center relative z-10 text-white">
            <span class="material-symbols-outlined text-7xl text-white/40 mb-6 font-light">school</span>
            <h2 class="text-5xl md:text-6xl font-black tracking-tight mb-8">Ministry Academy</h2>
            <p class="text-white/80 text-xl max-w-2xl mb-12 leading-relaxed">
                Join thousands of students worldwide in our structured spiritual learning path. Master the art of being a God-man in a modern world.
            </p>
            <div class="flex flex-wrap justify-center gap-6">
                <a href="{{ route('student.courses') }}" class="bg-white text-primary px-12 h-16 rounded-2xl font-black text-xl hover:shadow-2xl shadow-black/20 transition-all hover:-translate-y-1 flex items-center">Start Learning Free</a>
                <a href="{{ route('store.index') }}" class="bg-primary-dark/40 border-2 border-white/20 text-white px-12 h-16 rounded-2xl font-bold text-xl hover:bg-white/10 transition-all flex items-center">Library Resources</a>
            </div>
            
            <div class="mt-20 pt-16 border-t border-white/10 grid grid-cols-2 md:grid-cols-4 gap-12 w-full max-w-4xl">
                <div>
                    <p class="text-4xl font-black">{{ $counts['courses'] ?? '0' }}+</p>
                    <p class="text-white/50 text-xs font-bold uppercase tracking-widest mt-2">Courses</p>
                </div>
                <div>
                    <p class="text-4xl font-black">{{ $counts['students'] ?? '0' }}+</p>
                    <p class="text-white/50 text-xs font-bold uppercase tracking-widest mt-2">Students</p>
                </div>
                <div>
                    <p class="text-4xl font-black">98%</p>
                    <p class="text-white/50 text-xs font-bold uppercase tracking-widest mt-2">Success Rate</p>
                </div>
                <div>
                    <p class="text-4xl font-black">24/7</p>
                    <p class="text-white/50 text-xs font-bold uppercase tracking-widest mt-2">Mentor Access</p>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
