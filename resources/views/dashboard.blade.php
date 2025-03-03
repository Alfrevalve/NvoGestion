@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <!-- Estadísticas Generales -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $cirugiasPendientes }}</h3>
                    <p>Cirugías Pendientes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-procedures"></i>
                </div>
                <a href="{{ route('modulo.cirugias.index') }}" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $cirugiasCompletadas }}</h3>
                    <p>Cirugías Completadas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="{{ route('modulo.cirugias.index', ['estado' => 'completada']) }}" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stockBajo }}</h3>
                    <p>Items con Stock Bajo</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <a href="{{ route('modulo.almacen.index', ['filter' => 'stock_bajo']) }}" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $despachosPendientes }}</h3>
                    <p>Despachos Pendientes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-truck"></i>
                </div>
                <a href="{{ route('modulo.despacho.index', ['estado' => 'pendiente']) }}" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Calendario de Cirugías -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        Calendario de Cirugías
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('modulo.cirugias.calendario') }}" class="btn btn-tool">
                            <i class="fas fa-expand"></i> Ver Calendario Completo
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <!-- Actividad Reciente -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-1"></i>
                        Actividad Reciente
                    </h3>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-inverse">
                        @foreach($actividades as $actividad)
                            <div class="time-label">
                                <span class="bg-primary">{{ $actividad->created_at->format('d M') }}</span>
                            </div>
                            <div>
                                <i class="fas fa-{{ $actividad->icono }} bg-primary"></i>
                                <div class="timeline-item">
                                    <span class="time">
                                        <i class="far fa-clock"></i>
                                        {{ $actividad->created_at->format('H:i') }}
                                    </span>
                                    <h3 class="timeline-header">{{ $actividad->titulo }}</h3>
                                    <div class="timeline-body">
                                        {{ $actividad->descripcion }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(function () {
            // Inicialización del calendario
            var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($eventos),
                eventClick: function(info) {
                    window.location.href = `/modulo-cirugias/${info.event.id}`;
                }
            });
            calendar.render();
        });
    </script>
@stop
