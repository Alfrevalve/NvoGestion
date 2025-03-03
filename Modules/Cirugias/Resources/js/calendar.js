$(document).ready(function() {
    $('#calendar').fullCalendar({
        events: '/cirugias/calendar', // Ruta para cargar los eventos
        editable: true,
        eventLimit: true // allow "more" link when too many events
    });
});
