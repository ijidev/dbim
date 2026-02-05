@extends('layouts.app')

@section('title', 'Events Calendar')

@push('styles')
<style>
    /* FullCalendar Customization */
    :root {
        --fc-border-color: #e2e8f0;
        --fc-button-text-color: #fff;
        --fc-button-bg-color: var(--primary);
        --fc-button-border-color: var(--primary);
        --fc-button-hover-bg-color: var(--primary-dark);
        --fc-button-hover-border-color: var(--primary-dark);
        --fc-button-active-bg-color: var(--primary-dark);
        --fc-button-active-border-color: var(--primary-dark);
        --fc-event-bg-color: rgba(23, 84, 207, 0.1);
        --fc-event-border-color: transparent;
        --fc-event-text-color: var(--primary);
        --fc-today-bg-color: #f8fafc;
        --fc-now-indicator-color: var(--danger);
    }

    .calendar-hero {
        background-color: white; 
        border-bottom: 1px solid #e2e8f0; 
        padding: 4rem 1rem; 
        text-align: center; 
        position: relative; 
        overflow: hidden;
    }

    .calendar-hero-bg {
        position: absolute; 
        bottom: -50%; 
        left: -10%; 
        width: 50%; 
        height: 200%; 
        background: radial-gradient(circle, rgba(16, 185, 129, 0.05) 0%, transparent 70%); 
        z-index: 0;
    }

    .calendar-hero-content {
        position: relative; 
        z-index: 1;
    }

    .calendar-hero-title {
        font-size: clamp(2.5rem, 5vw, 3.5rem); 
        font-weight: 800; 
        color: #1e293b; 
        letter-spacing: -0.05em; 
        margin-bottom: 1rem;
    }

    .calendar-hero-text {
        color: #64748b; 
        max-width: 600px; 
        margin: 0 auto; 
        font-size: 1.25rem;
    }

    .calendar-container-wrapper {
        padding: 4rem 1.5rem;
    }

    .calendar-card {
        background: white; 
        padding: 2rem; 
        border-radius: 1.5rem; 
        box-shadow: var(--shadow-lg); 
        border: 1px solid #e2e8f0;
    }

    .fc-toolbar-title {
        font-size: 1.5rem !important;
        font-weight: 800;
        letter-spacing: -0.025em;
        color: var(--text-main);
    }

    .fc-col-header-cell-cushion {
        padding: 1rem 0 !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: var(--text-muted);
    }

    .fc-daygrid-day-number {
        font-weight: 600;
        color: var(--text-muted);
        text-decoration: none !important;
        padding: 0.5rem 0.5rem 0 0 !important;
    }

    .fc-event {
        border-radius: 4px;
        padding: 4px 8px;
        font-size: 0.85em;
        font-weight: 600;
        border: none;
        margin-bottom: 2px;
        transition: all 0.2s;
        border-left: 3px solid var(--primary);
    }

    .fc-event:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
        background: var(--primary) !important;
        color: white !important;
    }

    .fc-button {
        font-weight: 600 !important;
        text-transform: capitalize !important;
        border-radius: 0.5rem !important;
        padding: 0.5rem 1rem !important;
        box-shadow: var(--shadow-sm);
    }

    .fc-day-today {
        background: #f8fafc !important;
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .calendar-hero {
            padding: 3rem 1rem;
        }
        .calendar-container-wrapper {
            padding: 2rem 1rem;
        }
        .calendar-card {
            padding: 1rem;
            border-radius: 1rem;
        }
        .fc-header-toolbar {
            flex-direction: column;
            gap: 1rem;
        }
        .fc-toolbar-title {
            font-size: 1.25rem !important;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero -->
<div class="calendar-hero">
    <div class="calendar-hero-bg"></div>
    
    <div class="container calendar-hero-content">
        <h1 class="calendar-hero-title">Events Calendar</h1>
        <p class="calendar-hero-text">Stay updated with our upcoming services, conferences, and community activities.</p>
    </div>
</div>

<div class="container calendar-container-wrapper">
    <div class="calendar-card">
        <div id='calendar'></div>
    </div>
</div>
@endsection

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,listMonth'
      },
      events: '{{ route("calendar.events") }}',
      height: 'auto',
      navLinks: true,
      editable: false,
      selectable: true,
      dayMaxEvents: true,
      buttonText: {
        today: 'Today',
        month: 'Month',
        week: 'Week',
        day: 'Day',
        list: 'List'
      },
      eventClick: function(info) {
        if (info.event.url) {
            window.location.href = info.event.url;
            info.jsEvent.preventDefault();
        }
      },
      windowResize: function(view) {
        if (window.innerWidth < 768) {
            calendar.changeView('listMonth');
        } else {
            calendar.changeView('dayGridMonth');
        }
      }
    });
    calendar.render();
  });
</script>
@endpush
