@extends('layouts.app')

@section('title', 'Church Digital Library')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&display=swap');
    
    .font-serif-premium {
        font-family: 'Newsreader', serif;
    }
    
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .bg-ivory { background-color: #FAF9F6; }
</style>
@endpush

@section('content')
<div class="bg-ivory min-h-screen font-serif-premium text-slate-800">
    <main class="max-w-[1440px] mx-auto w-full px-6 lg:px-20 py-12">
        <!-- Search & Filters -->
        <div class="flex flex-col gap-8 mb-16">
            <div class="max-w-3xl w-full">
                <form action="{{ route('library.index') }}" method="GET" class="relative block group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-5 text-slate-400 group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined text-2xl">search</span>
                    </span>
                    <input name="search" value="{{ request('search') }}" class="block w-full h-16 pl-14 pr-6 bg-white border border-slate-200 rounded-[24px] shadow-sm focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all placeholder:italic placeholder:text-slate-400 text-xl font-medium" placeholder="Search for theology, devotionals, or sacred texts..." type="text"/>
                </form>
            </div>
            
            <div class="flex gap-4 overflow-x-auto pb-4 no-scrollbar">
                <a href="{{ route('library.index') }}" class="px-8 py-3 rounded-full {{ !request('category') ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'bg-white text-slate-600 border border-slate-100 hover:border-primary/30' }} font-bold text-sm transition-all whitespace-nowrap">All Works</a>
                @foreach(['Theology', 'Devotionals', 'History', 'Liturgy', 'Biographies'] as $cat)
                    <a href="{{ route('library.index', ['category' => $cat]) }}" class="px-8 py-3 rounded-full {{ request('category') == $cat ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'bg-white text-slate-600 border border-slate-100 hover:border-primary/30' }} font-bold text-sm transition-all whitespace-nowrap">{{ $cat }}</a>
                @endforeach
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-20">
            <!-- Main Content Grid -->
            <div class="flex-1">
                <div class="flex items-baseline justify-between mb-12 border-b border-slate-100 pb-6">
                    <h3 class="text-4xl font-black italic tracking-tight">Spiritual Literature</h3>
                    <span class="text-sm text-slate-400 font-bold uppercase tracking-widest">{{ $books->total() }} volumes available</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-12">
                    @forelse($books as $book)
                    <div class="group flex flex-col gap-6">
                        <div class="relative w-full aspect-[3/4.2] rounded-[32px] overflow-hidden shadow-2xl transition-all duration-500 hover:-translate-y-2">
                            <img src="{{ $book->cover_image ? asset('storage/'.$book->cover_image) : 'https://placehold.co/600x800?text='.$book->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-x-0 bottom-0 p-6 bg-gradient-to-t from-black/80 via-black/40 to-transparent flex flex-col justify-end">
                                <div class="flex items-center justify-between">
                                    <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-[10px] font-black text-white uppercase tracking-widest">{{ $book->category ?? 'Theology' }}</span>
                                    @if($book->is_free)
                                        <span class="text-white text-[10px] font-black uppercase tracking-widest opacity-80">Free Access</span>
                                    @endif
                                </div>
                            </div>
                            <!-- Overlay Actions -->
                            <div class="absolute inset-0 bg-primary/20 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col items-center justify-center gap-4">
                                <a href="{{ route('student.library.read', $book->slug) }}" class="px-10 py-4 bg-white text-primary font-black rounded-2xl shadow-2xl transform translate-y-8 group-hover:translate-y-0 transition-all duration-500 hover:scale-105 active:scale-95">Preview Intro</a>
                                <button onclick="addToCollection('{{ $book->id }}', '{{ $book->is_free ? 'free' : 'paid' }}')" class="text-white text-xs font-black uppercase tracking-widest hover:underline underline-offset-8 transition-all">Add to Sanctuary</button>
                            </div>
                        </div>
                        <div class="px-2">
                            <h4 class="text-2xl font-black leading-tight mb-2 group-hover:text-primary transition-colors line-clamp-2 italic">{{ $book->title }}</h4>
                            <p class="text-slate-500 font-bold italic mb-6">By {{ $book->author }}</p>
                            <a href="{{ route('student.library.read', $book->slug) }}" class="w-full flex items-center justify-center gap-3 py-5 bg-white border border-slate-100 rounded-3xl font-black text-slate-900 group-hover:bg-primary group-hover:text-white group-hover:border-primary group-hover:shadow-2xl group-hover:shadow-primary/30 transition-all">
                                <span class="material-symbols-outlined text-xl">auto_stories</span>
                                Read Now
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-24 text-center">
                        <span class="material-symbols-outlined text-6xl text-slate-200 mb-4 block">book_5</span>
                        <p class="text-slate-400 italic text-xl">No works found matching your search.</p>
                    </div>
                    @endforelse
                </div>

                <div class="mt-20">
                    {{ $books->links() }}
                </div>
            </div>

            <!-- Right Sidebar -->
            <aside class="w-full lg:w-[400px] shrink-0 flex flex-col gap-12 lg:sticky lg:top-32 h-fit">
                <!-- User Sanctuary Section -->
                <div class="bg-white p-10 rounded-[48px] shadow-sm border border-slate-100">
                    <div class="flex items-center gap-4 mb-10">
                        <div class="size-12 bg-primary/5 rounded-2xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-2xl">bookmark_heart</span>
                        </div>
                        <h3 class="text-2xl font-black italic">Your Sanctuary</h3>
                    </div>

                    <div class="space-y-10">
                        <!-- Recently Read -->
                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-6 font-sans">Recently Read</h4>
                            @if(auth()->check() && $recentRead)
                                <a href="{{ route('student.library.read', $recentRead->book->slug) }}" class="flex gap-6 group items-center">
                                    <div class="w-20 h-24 bg-slate-100 rounded-2xl overflow-hidden shadow-xl flex-shrink-0 transition-transform group-hover:scale-105">
                                        <img src="{{ $recentRead->book->cover_image ? asset('storage/'.$recentRead->book->cover_image) : 'https://placehold.co/200x300?text='.$recentRead->book->title }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-lg font-black text-slate-900 line-clamp-1 group-hover:text-primary transition-colors italic leading-tight">{{ $recentRead->book->title }}</p>
                                        <div class="mt-3 w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                            <div class="bg-primary h-full rounded-full" style="width: {{ $recentRead->percentage_complete }}%"></div>
                                        </div>
                                        <p class="text-[10px] text-slate-500 font-extrabold uppercase tracking-widest mt-2">{{ round($recentRead->percentage_complete) }}% complete</p>
                                    </div>
                                </a>
                            @else
                                <div class="flex gap-6 group cursor-pointer items-center opacity-60">
                                    <div class="size-20 bg-slate-50 border border-dashed border-slate-200 rounded-[28px] flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-slate-300 text-3xl">auto_stories</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-slate-400 italic">No recent reading found. Start your journey today.</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Recommendations -->
                        <div>
                            <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-6 font-sans">For Meditation</h4>
                            <div class="space-y-6">
                                @foreach($books->take(3) as $rec)
                                <a href="{{ route('student.library.read', $rec->slug) }}" class="flex items-center gap-5 group p-2 -ml-2 rounded-3xl hover:bg-slate-50 transition-all">
                                    <div class="w-14 h-14 bg-slate-100 rounded-2xl overflow-hidden flex-shrink-0 shadow-sm border border-white">
                                        <img src="{{ $rec->cover_image ? asset('storage/'.$rec->cover_image) : 'https://placehold.co/100x100?text='.$rec->title }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-900 leading-tight mb-1">{{ $rec->title }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold italic">{{ $rec->author }}</p>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Quote -->
                    <div class="pt-10 mt-10 border-t border-slate-50 relative">
                        <span class="material-symbols-outlined absolute -top-4 -right-4 text-8xl opacity-[0.03] rotate-12 text-slate-900 pointer-events-none select-none">format_quote</span>
                        <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-6 font-sans">Words of Grace</h4>
                        <p class="text-xl italic font-medium leading-relaxed text-slate-800 mb-6">"{{ $wisdomText }}"</p>
                        <p class="text-xs font-black uppercase tracking-widest text-primary">— {{ $wisdomAuthor }}</p>
                    </div>
                </div>

                <!-- Stats/Community Card -->
                <div class="bg-slate-900 p-10 rounded-[48px] text-white relative overflow-hidden group">
                    <div class="absolute -top-12 -right-12 size-40 bg-primary/20 rounded-full blur-[60px] group-hover:bg-primary/30 transition-colors"></div>
                    <h4 class="text-3xl font-black italic mb-6 leading-tight">Illuminating the <span class="text-primary italic-normal">Soul</span> through Study.</h4>
                    <p class="text-slate-400 text-sm font-medium leading-relaxed mb-10 opacity-80">Explore thousands of volumes preserved across generations to deepen your understanding of the Divine.</p>
                    <div class="grid grid-cols-2 gap-8 pt-6 border-t border-white/10">
                        <div>
                            <p class="text-3xl font-black tracking-tight">{{ $books->total() }}</p>
                            <p class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-500 mt-2">Volumes</p>
                        </div>
                        <div>
                            <p class="text-3xl font-black tracking-tight">2.4k</p>
                            <p class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-500 mt-2">Active Readers</p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function addToCollection(bookId, type) {
        @guest
            Swal.fire({
                title: 'Membership Required',
                text: 'Please log in to add books to your personal collection.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#0f49bd',
                cancelButtonText: 'Browse More',
                confirmButtonText: 'Log In Now'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });
            return;
        @endguest

        if (type === 'paid') {
            Swal.fire({
                title: 'Premium Book',
                text: 'This volume requires a one-time purchase. Would you like to proceed to checkout?',
                icon: 'lock',
                showCancelButton: true,
                confirmButtonColor: '#0f49bd',
                confirmButtonText: 'Add to Cart',
                cancelButtonText: 'Later'
            }).then((result) => {
                // Future purchase flow integration
            });
            return;
        }

        fetch("{{ url('/my-library/add') }}/" + bookId, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    title: 'Added to Collection!',
                    text: data.message,
                    icon: 'success',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            } else {
                Swal.fire({
                    title: 'Already in Library',
                    text: data.message,
                    icon: 'info'
                });
            }
        });
    }
</script>
@endpush
