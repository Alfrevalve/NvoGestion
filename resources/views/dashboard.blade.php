@extends('layouts.app')

@section('content')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<div class="container-fluid">
    <div class="row">
        <!-- Estadísticas -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Cirugías Pendientes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $cirugiasPendientes }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-procedures fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Cirugías Completadas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $cirugiasCompletadas }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Stock Bajo</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stockBajo }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Despachos Pendientes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $despachosPendientes }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-truck fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Calendario -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Calendario de Cirugías</h5>
                    <a href="{{ route('modulo.cirugias.calendario') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-calendar-alt me-1"></i> Ver Calendario Completo
                    </a>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        
        <!-- Actividades Recientes -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Actividades Recientes</h5>
                </div>
                <div class="card-body">
                    @if(isset($actividades) && count($actividades) > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($actividades as $actividad)
                                <li class="list-group-item px-0">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-{{ $actividad['icono'] }} text-primary"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="mb-1">{{ $actividad['titulo'] }}</h6>
                                            <p class="mb-1 small">{{ $actividad['descripcion'] }}</p>
                                            <small class="text-muted">{{ $actividad['created_at']->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center my-3">No hay actividades recientes</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        var eventos = @json($eventos); // Pasar eventos desde la vista
    </script>
    <script src="/js/calendar-init.js"></script>
@endsection