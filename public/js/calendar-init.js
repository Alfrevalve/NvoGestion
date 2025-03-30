document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: eventos, // Eventos pasados desde la vista
        eventClick: function(info) {
            window.location.href = `/modulo-cirugias/${info.event.id}`;
        }
    });
    calendar.render();
});
