@extends('layouts.sb-admin-pro')

@section('title', 'Detalle de Instrumentista')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detalle de Instrumentista</h1>
        <div>
            <a href="{{ route('instrumentistas.edit', $instrumentista->id) }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Editar
            </a>
            <a href="{{ route('instrumentistas.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver al listado
            </a>
        </div>
    </div>

    <!-- Instrumentalist Details Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Información del Instrumentista</h6>
            <span class="badge badge-{{ $instrumentista->estado == 'Activo' ? 'success' : 'danger' }}">
                {{ $instrumentista->estado }}
            </span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">Nombre:</th>
                            <td><strong>{{ $instrumentista->nombre }}</strong></td>
                        </tr>
                        <tr>
                            <th>Documento:</th>
                            <td>{{ $instrumentista->documento }}</td>
                        </tr>
                        <tr>
                            <th>Especialidad:</th>
                            <td>{{ $instrumentista->especialidad }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">Teléfono:</th>
                            <td>{{ $instrumentista->telefono }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $instrumentista->email }}</td>
                        </tr>
                        <tr>
                            <th>Estado:</th>
                            <td>
                                <span class="badge badge-{{ $instrumentista->estado == 'Activo' ? 'success' : 'danger' }}">
                                    {{ $instrumentista->estado }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            @if(isset($instrumentista->observaciones) && !empty($instrumentista->observaciones))
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="font-weight-bold text-primary mb-0">Observaciones</h6>
                    </div>
                    <div class="card-body">
                        <p>{{ $instrumentista->observaciones }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Surgery History -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Historial de Cirugías</h6>
            <a href="{{ route('cirugias.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus fa-sm"></i> Nueva Cirugía
            </a>
        </div>
        <div class="card-body">
            @if(isset($instrumentista->cirugias) && $instrumentista->cirugias->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Fecha</th>
                                <th>Médico</th>
                                <th>Paciente</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($instrumentista->cirugias as $cirugia)
                            <tr>
                                <td>{{ $cirugia->codigo }}</td>
                                <td>{{ $cirugia->nombre }}</td>
                                <td>{{ date('d/m/Y', strtotime($cirugia->fecha)) }}</td>
                                <td>{{ $cirugia->medico->nombre ?? 'No asignado' }}</td>
                                <td>{{ $cirugia->paciente->nombre ?? 'No asignado' }}</td>
                                <td>
                                    <span class="badge badge-{{ $cirugia->estado == 'Programada' ? 'primary' : ($cirugia->estado == 'Completada' ? 'success' : 'warning') }}">
                                        {{ $cirugia->estado }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('cirugias.show', $cirugia->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i> Este instrumentista no ha participado en cirugías.
                </div>
            @endif
        </div>
    </div>

    <!-- Performance Statistics -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Estadísticas de Participación</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Cirugías Totales</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ isset($instrumentista->cirugias) ? $instrumentista->cirugias->count() : 0 }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ isset($instrumentista->cirugias) ? $instrumentista->cirugias->where('estado', 'Completada')->count() : 0 }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Cirugías Pendientes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ isset($instrumentista->cirugias) ? $instrumentista->cirugias->where('estado', 'Programada')->count() : 0 }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
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
                                        Médicos Diferentes</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ isset($instrumentista->cirugias) ? $instrumentista->cirugias->pluck('medico_id')->unique()->count() : 0 }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-md fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Participation Chart -->
            <div class="chart-area">
                <canvas id="participationChart"></canvas>
            </div>
            <div class="small text-muted mt-2">Participación en cirugías en los últimos 6 meses</div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Participation Chart
    var ctx = document.getElementById("participationChart");
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun"],
            datasets: [{
                label: "Cirugías",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: [
                    {{ isset($instrumentista->cirugias) ? $instrumentista->cirugias->count() : 0 }}, 
                    {{ isset($instrumentista->cirugias) ? $instrumentista->cirugias->count() : 0 }}, 
                    {{ isset($instrumentista->cirugias) ? $instrumentista->cirugias->count() : 0 }}, 
                    {{ isset($instrumentista->cirugias) ? $instrumentista->cirugias->count() : 0 }}, 
                    {{ isset($instrumentista->cirugias) ? $instrumentista->cirugias->count() : 0 }}, 
                    {{ isset($instrumentista->cirugias) ? $instrumentista->cirugias->count() : 0 }}
                ],
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        callback: function(value, index, values) {
                            return value;
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': ' + tooltipItem.yLabel;
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection