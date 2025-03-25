@extends('layouts.app')

@section('content')
    <div id='calendar'></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: @json($eventos) // Pasar los eventos desde el controlador
            });
            calendar.render();
        });
    </script>
@endsection
