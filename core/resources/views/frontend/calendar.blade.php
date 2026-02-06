@extends('layouts.app')

@section('title', 'Church Calendar')

@push('styles')
<style>
    /* FullCalendar Customization to match Premium Design */
    :root {
        --fc-border-color: #f1f5f9;
        --fc-button-bg-color: var(--primary);
        --fc-button-border-color: var(--primary);
        --fc-button-hover-bg-color: var(--primary-dark);
        --fc-button-active-bg-color: var(--primary-dark);
        --fc-event-bg-color: rgba(23, 84, 207, 0.08);
        --fc-event-border-color: transparent;
        --fc-event-text-color: var(--primary);
        --fc-today-bg-color: #eff6ff;
    }

    .fc { font-family: 'Inter', sans-serif; }
    .fc-toolbar-title { font-size: 1.25rem !important; font-weight: 800 !important; color: #1e293b; }
    .fc-col-header-cell { background: #f8fafc; padding: 12px 0 !important; }
    .fc-col-header-cell-cushion { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #64748b; tracking: 0.05em; }
    .fc-daygrid-day-number { font-weight: 600; color: #94a3b8; padding: 8px !important; }
    .fc-event { border-radius: 6px; padding: 4px 8px; font-weight: 700; border-left: 3px solid var(--primary) !important; margin: 2px 4px !important; }
    .fc-day-today .fc-daygrid-day-number { color: var(--primary); font-bold: 800; }
    
    .filter-btn.active {
        background-color: var(--primary);
        color: white;
    }
</style>
@endpush

@section('content')
<main class="flex-1 px-4 lg:px-10 py-12 max-w-[1440px] mx-auto">
    <!-- Page Heading -->
    <div class="flex flex-wrap justify-between items-end gap-6 mb-12">
        <div class="flex flex-col gap-2">
            <h1 class="text-slate-900 text-5xl font-black leading-tight tracking-tight">Church Calendar</h1>
            <p class="text-slate-500 text-lg max-w-lg">Engage with our diverse programs. Join services, youth activities, and community outreach.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="calendar.today()" class="flex items-center gap-2 rounded-xl h-12 px-6 bg-white border border-slate-200 text-sm font-bold shadow-sm hover:bg-slate-50 transition-all">
                <span class="material-symbols-outlined text-[20px]">calendar_today</span>
                <span>Today</span>
            </button>
            <a href="{{ route('event') }}" class="flex items-center gap-2 rounded-xl h-12 px-6 bg-primary text-white text-sm font-bold shadow-lg shadow-primary/20 hover:bg-primary-dark transition-all">
                <span class="material-symbols-outlined text-[20px]">list</span>
                <span>List View</span>
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap items-center justify-between gap-6 mb-8">
        <div class="flex gap-3 flex-wrap">
            <button class="filter-btn active flex h-10 items-center justify-center gap-2 rounded-full bg-slate-100 text-slate-600 px-5 text-sm font-bold border border-transparent hover:border-slate-200 transition-all">
                <span class="material-symbols-outlined text-[20px]">grid_view</span>
                <span>All Events</span>
            </button>
            <button class="filter-btn flex h-10 items-center justify-center gap-2 rounded-full bg-white border border-slate-200 text-slate-600 px-5 text-sm font-bold hover:border-primary transition-all">
                <span class="material-symbols-outlined text-primary text-[20px]">church</span>
                <span>Services</span>
            </button>
            <button class="filter-btn flex h-10 items-center justify-center gap-2 rounded-full bg-white border border-slate-200 text-slate-600 px-5 text-sm font-bold hover:border-amber-500 transition-all">
                <span class="material-symbols-outlined text-amber-500 text-[20px]">group</span>
                <span>Youth</span>
            </button>
            <button class="filter-btn flex h-10 items-center justify-center gap-2 rounded-full bg-white border border-slate-200 text-slate-600 px-5 text-sm font-bold hover:border-emerald-500 transition-all">
                <span class="material-symbols-outlined text-emerald-500 text-[20px]">volunteer_activism</span>
                <span>Community</span>
            </button>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-10">
        <!-- Monthly Calendar Grid -->
        <div class="flex-1 bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm p-6">
            <div id='calendar'></div>
        </div>

        <!-- Detail Sidebar -->
        <aside class="w-full lg:w-[400px] flex flex-col gap-6">
            <div id="eventDetailsCard" class="bg-white rounded-3xl border border-slate-100 shadow-2xl overflow-hidden sticky top-24 transition-all opacity-0 translate-y-4 pointer-events-none">
                <div class="relative h-52 w-full bg-slate-100 overflow-hidden">
                    <img id="detailImage" src="" alt="Event cover" class="w-full h-full object-cover">
                    <div class="absolute top-4 left-4 flex gap-2">
                        <span id="detailCategory" class="px-3 py-1 bg-primary text-white text-[10px] font-black rounded-full uppercase tracking-widest">Event</span>
                    </div>
                </div>
                <div class="p-8">
                    <div class="flex items-center justify-between mb-4">
                        <p id="detailDate" class="text-primary text-sm font-black uppercase tracking-widest"></p>
                    </div>
                    <h3 id="detailTitle" class="text-2xl font-black text-slate-900 mb-6 leading-tight"></h3>
                    <div class="space-y-4 mb-8">
                        <div class="flex items-center gap-4 text-slate-500 font-medium">
                            <span class="material-symbols-outlined text-slate-400">schedule</span>
                            <span id="detailTime" class="text-sm"></span>
                        </div>
                        <div class="flex items-center gap-4 text-slate-500 font-medium">
                            <span class="material-symbols-outlined text-slate-400">location_on</span>
                            <div class="flex flex-col">
                                <span id="detailLocation" class="text-sm"></span>
                            </div>
                        </div>
                    </div>
                    <p id="detailDesc" class="text-slate-500 text-sm leading-relaxed mb-8 line-clamp-4"></p>
                    <div class="flex flex-col gap-3">
                        <a id="detailLink" href="" class="w-full h-14 bg-primary text-white font-black rounded-xl hover:bg-primary-dark transition-all shadow-lg shadow-primary/20 flex items-center justify-center">View Details</a>
                    </div>
                </div>
            </div>

            <!-- Placeholder Card -->
            <div id="detailPlaceholder" class="bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 p-12 text-center flex flex-col items-center justify-center min-h-[400px]">
                <span class="material-symbols-outlined text-6xl text-slate-200 mb-4 font-light">touch_app</span>
                <p class="text-slate-400 font-bold">Select an event to view details</p>
            </div>
        </aside>
    </div>
</main>
@endsection

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script>
  let calendar;
  document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      headerToolbar: {
        left: 'prev,next',
        center: 'title',
        right: ''
      },
      events: '{{ route("calendar.events") }}',
      height: 'auto',
      navLinks: true,
      editable: false,
      selectable: true,
      dayMaxEvents: true,
      eventClick: function(info) {
        showEventDetails(info.event);
        info.jsEvent.preventDefault();
      }
    });
    calendar.render();
  });

  function showEventDetails(event) {
    const card = document.getElementById('eventDetailsCard');
    const placeholder = document.getElementById('detailPlaceholder');
    
    // Update content
    document.getElementById('detailTitle').textContent = event.title;
    document.getElementById('detailDate').textContent = event.start.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric' });
    document.getElementById('detailTime').textContent = event.start.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
    document.getElementById('detailLocation').textContent = event.extendedProps.location || 'Main Sanctuary';
    document.getElementById('detailDesc').textContent = event.extendedProps.description || 'Join us for this impactful gathering as we explore deeper truths and connect with the community.';
    document.getElementById('detailImage').src = event.extendedProps.image || 'https://images.unsplash.com/photo-1438232992991-995b7058bbb3?auto=format&fit=crop&q=80&w=800';
    document.getElementById('detailLink').href = event.url;
    
    // Animate
    placeholder.style.display = 'none';
    card.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
  }
</script>
@endpush
