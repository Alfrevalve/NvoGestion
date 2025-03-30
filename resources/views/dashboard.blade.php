@extends('layouts.sb-admin-pro')

@section('title', 'Dashboard - GesVitalPro')

@section('header-icon')
    <i class="fas fa-tachometer-alt"></i>
@endsection

@section('header-title', 'Dashboard')

@section('header-subtitle', 'Resumen general del sistema')

@section('header-actions')
    <a class="btn btn-white text-primary" href="{{ route('cirugias.create') }}">
        <i class="fas fa-plus mr-2"></i>
        Nueva Cirugía
    </a>
@endsection

@section('content')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<div class="container-fluid">
    <div class="row">
    <div class="row">
        <!-- Estadísticas -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-primary border-start-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">Cirugías Pendientes</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $cirugiasPendientes }}</div>
                        </div>
                        <div class="text-primary"><i class="fas fa-procedures fa-2x"></i></div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-primary stretched-link" href="#">Ver Pendientes</a>
                    <div class="text-primary"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-success border-start-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">Cirugías Completadas</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $cirugiasCompletadas }}</div>
                        </div>
                        <div class="text-success"><i class="fas fa-check-circle fa-2x"></i></div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-success stretched-link" href="#">Ver Completadas</a>
                    <div class="text-success"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-warning border-start-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">Stock Bajo</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $stockBajo }}</div>
                        </div>
                        <div class="text-warning"><i class="fas fa-exclamation-triangle fa-2x"></i></div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-warning stretched-link" href="#">Ver Inventario</a>
                    <div class="text-warning"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-danger border-start-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-xs fw-bold text-danger text-uppercase mb-1">Despachos Pendientes</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $despachosPendientes }}</div>
                        </div>
                        <div class="text-danger"><i class="fas fa-truck fa-2x"></i></div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-danger stretched-link" href="#">Ver Despachos</a>
                    <div class="text-danger"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
<div class="row">
        <!-- Calendario -->
        <div class="col-lg-8 mb-4">
            <div class="card card-header-actions h-100">
                <div class="card-header">
                    Calendario de Cirugías
                    <div>
                        <a href="{{ route('modulo.cirugias.calendario') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-external-link-alt me-1"></i> Ver Completo
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="calendar" class="p-3"></div>
                </div>
            </div>
        </div>
        
        <!-- Actividades Recientes -->
        <!-- Actividades Recientes -->
        <div class="col-lg-4 mb-4">
            <div class="card card-header-actions h-100">
                <div class="card-header">
                    Actividades Recientes
                    <div class="dropdown no-caret">
                        <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                        <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="dropdownMenuButton">
                            <h6 class="dropdown-header">Filtrar Actividades:</h6>
                            <a class="dropdown-item" href="#!"><span class="badge bg-primary-soft text-primary me-2">Todas</span></a>
                            <a class="dropdown-item" href="#!"><span class="badge bg-blue-soft text-blue me-2">Cirugías</span></a>
                            <a class="dropdown-item" href="#!"><span class="badge bg-green-soft text-green me-2">Almacén</span></a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if(isset($actividades) && count($actividades) > 0)
                        <div class="timeline timeline-xs px-3 py-3">
                            @foreach($actividades as $actividad)
                                <div class="timeline-item">
                                    <div class="timeline-item-marker">
                                        <div class="timeline-item-marker-text">{{ $actividad['created_at']->diffForHumans(null, true) }}</div>
                                        <div class="timeline-item-marker-indicator bg-primary"></div>
                                    </div>
                                    <div class="timeline-item-content">
                                        {{ $actividad['titulo'] }}
                                        <br/>
                                        <span class="small text-muted">{{ $actividad['descripcion'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay actividades recientes</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    <a class="text-primary small stretched-link" href="#">Ver todas las actividades</a>
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
    
    <!-- Chart.js CDN if not already included -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsectionn