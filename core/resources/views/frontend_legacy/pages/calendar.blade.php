@extends('frontend.layouts.homelayout')

@section('content')
<div class="row hero-banner">
    <div class="card banner">
        <div class="card-body d-flex justify-content-center align-items-center" style="background-color: #333; min-height: 200px; color: #fff;">
            <h2>Events Calendar</h2>
        </div>
    </div>
</div>

<div class="container mt-5 mb-5">
    <div class="card">
        <div class="card-body">
            <div id='calendar'></div>
        </div>
    </div>
</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      events: '{{ route("calendar.events") }}',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      }
    });
    calendar.render();
  });
</script>
@endsection
