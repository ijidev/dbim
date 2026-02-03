@extends('layouts.app')

@push('styles')
<style>
    /* FullCalendar Overrides */
    :root {
        --fc-border-color: #e2e8f0;
        --fc-button-text-color: #fff;
        --fc-button-bg-color: var(--primary-color);
        --fc-button-border-color: var(--primary-color);
        --fc-button-hover-bg-color: #1a4ebd;
        --fc-button-hover-border-color: #1a4ebd;
        --fc-button-active-bg-color: #1a4ebd;
        --fc-button-active-border-color: #1a4ebd;
        --fc-event-bg-color: #3b82f6;
        --fc-event-border-color: #3b82f6;
        --fc-today-bg-color: #f1f5f9;
        --fc-now-indicator-color: red;
    }

    .fc-toolbar-title {
        font-size: 1.25rem !important;
        font-weight: 700;
        letter-spacing: -0.025em;
    }

    .fc-col-header-cell-cushion {
        padding: 1rem 0 !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #64748b;
    }

    .fc-daygrid-day-number {
        font-weight: 500;
        color: #475569;
        text-decoration: none !important;
    }

    .fc-event {
        border-radius: 4px;
        padding: 2px 4px;
        font-size: 0.85em;
        font-weight: 500;
        border: none;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    }
</style>
@endpush

@section('content')
<div style="background-color: #fff; border-bottom: 1px solid #e2e8f0; padding: 3rem 1rem; text-align: center;">
    <h1 style="font-size: 2.25rem; font-weight: 800; color: #1e293b; letter-spacing: -0.05em; margin-bottom: 0.5rem;">Events Calendar</h1>
    <p style="color: #64748b; max-width: 600px; margin: 0 auto;">Stay updated with our upcoming services, programs, and community activities.</p>
</div>

<div style="padding: 2rem 1rem; max-width: 1200px; margin: 0 auto;">
    <div style="background: white; padding: 1.5rem; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); border: 1px solid #e2e8f0;">
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
      navLinks: true, // can click day/week names to navigate views
      editable: false,
      selectable: true,
      dayMaxEvents: true, // allow "more" link when too many events
      buttonText: {
        today: 'Today',
        month: 'Month',
        week: 'Week',
        day: 'Day',
        list: 'List'
      }
    });
    calendar.render();
  });
</script>
@endpush
