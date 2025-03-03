@extends('adminlte::page')

@section('title', 'Calendario de Cirugías')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Calendario de Cirugías</h1>
        @can('crear cirugias')
            <a href="{{ route('cirugias.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nueva Cirugía
            </a>
        @endcan
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Filtros</h3>
                </div>
                <div class="card-body">
                    <!-- Estados -->
                    <div class="mb-3">
                        <label>Estados</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="estado-pendiente" checked>
                            <label class="custom-control-label" for="estado-pendiente">
                                <span class="badge badge-primary">Pendiente</span>
                            </label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="estado-programada" checked>
                            <label class="custom-control-label" for="estado-programada">
                                <span class="badge badge-info">Programada</span>
                            </label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="estado-en-proceso" checked>
                            <label class="custom-control-label" for="estado-en-proceso">
                                <span class="badge badge-warning">En Proceso</span>
                            </label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="estado-finalizada" checked>
                            <label class="custom-control-label" for="estado-finalizada">
                                <span class="badge badge-success">Finalizada</span>
                            </label>
                        </div>
                    </div>

                    <!-- Prioridades -->
                    <div class="mb-3">
                        <label>Prioridades</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="prioridad-baja" checked>
                            <label class="custom-control-label" for="prioridad-baja">
                                <span class="badge badge-success">Baja</span>
                            </label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="prioridad-media" checked>
                            <label class="custom-control-label" for="prioridad-media">
                                <span class="badge badge-info">Media</span>
                            </label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="prioridad-alta" checked>
                            <label class="custom-control-label" for="prioridad-alta">
                                <span class="badge badge-warning">Alta</span>
                            </label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="prioridad-urgente" checked>
                            <label class="custom-control-label" for="prioridad-urgente">
                                <span class="badge badge-danger">Urgente</span>
                            </label>
                        </div>
                    </div>

                    <!-- Próximas Cirugías -->
                    <div class="mb-3">
                        <label>Próximas Cirugías</label>
                        <div class="list-group">
                            @foreach($proximasCirugias as $cirugia)
                                <a href="{{ route('cirugias.show', $cirugia) }}" class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $cirugia->tipo_cirugia }}</h6>
                                        <small>{{ $cirugia->fecha->format('d/m') }}</small>
                                    </div>
                                    <small>{{ $cirugia->hora->format('H:i') }} - Dr. {{ $cirugia->medico->nombre }}</small>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div id="calendario"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Detalles -->
    <div class="modal fade" id="modal-detalles" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalles de la Cirugía</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="detalles-cirugia"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <a href="#" id="btn-ver-detalles" class="btn btn-primary">Ver Completo</a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <style>
        .fc-event {
            cursor: pointer;
        }
        .estado-pendiente { background-color: var(--primary) !important; }
        .estado-programada { background-color: var(--info) !important; }
        .estado-en-proceso { background-color: var(--warning) !important; }
        .estado-finalizada { background-color: var(--success) !important; }

        .prioridad-baja { border-left: 5px solid var(--success) !important; }
        .prioridad-media { border-left: 5px solid var(--info) !important; }
        .prioridad-alta { border-left: 5px solid var(--warning) !important; }
        .prioridad-urgente { border-left: 5px solid var(--danger) !important; }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendario');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                initialView: 'timeGridWeek',
                events: @json($eventos),
                eventClick: function(info) {
                    var evento = info.event;
                    $('#detalles-cirugia').html(`
                        <dl>
                            <dt>Tipo de Cirugía</dt>
                            <dd>${evento.title}</dd>
                            <dt>Fecha y Hora</dt>
                            <dd>${moment(evento.start).format('DD/MM/YYYY HH:mm')}</dd>
                            <dt>Médico</dt>
                            <dd>${evento.extendedProps.medico}</dd>
                            <dt>Institución</dt>
                            <dd>${evento.extendedProps.institucion}</dd>
                            <dt>Estado</dt>
                            <dd><span class="badge badge-${evento.extendedProps.estadoClass}">${evento.extendedProps.estado}</span></dd>
                            <dt>Prioridad</dt>
                            <dd><span class="badge badge-${evento.extendedProps.prioridadClass}">${evento.extendedProps.prioridad}</span></dd>
                        </dl>
                    `);
                    $('#btn-ver-detalles').attr('href', `/cirugias/${evento.extendedProps.id}`);
                    $('#modal-detalles').modal('show');
                },
                slotMinTime: '07:00:00',
                slotMaxTime: '20:00:00',
                allDaySlot: false,
                slotDuration: '00:15:00',
                nowIndicator: true,
                businessHours: {
                    daysOfWeek: [ 1, 2, 3, 4, 5 ],
                    startTime: '07:00',
                    endTime: '20:00',
                }
            });
            calendar.render();

            // Filtros
            function actualizarFiltros() {
                var estados = [];
                var prioridades = [];

                if ($('#estado-pendiente').is(':checked')) estados.push('pendiente');
                if ($('#estado-programada').is(':checked')) estados.push('programada');
                if ($('#estado-en-proceso').is(':checked')) estados.push('en proceso');
                if ($('#estado-finalizada').is(':checked')) estados.push('finalizada');

                if ($('#prioridad-baja').is(':checked')) prioridades.push('baja');
                if ($('#prioridad-media').is(':checked')) prioridades.push('media');
                if ($('#prioridad-alta').is(':checked')) prioridades.push('alta');
                if ($('#prioridad-urgente').is(':checked')) prioridades.push('urgente');

                calendar.getEvents().forEach(function(evento) {
                    if (estados.includes(evento.extendedProps.estado.toLowerCase()) &&
                        prioridades.includes(evento.extendedProps.prioridad.toLowerCase())) {
                        evento.setProp('display', 'auto');
                    } else {
                        evento.setProp('display', 'none');
                    }
                });
            }

            // Event listeners para los checkboxes
            $('.custom-control-input').change(actualizarFiltros);
        });
    </script>
@stop
