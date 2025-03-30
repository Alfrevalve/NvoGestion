@extends('layouts.sb-admin-pro')

@section('title', 'Detalle de Usuario')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detalle de Usuario</h1>
        <div>
            <a href="{{ route('admin.usuarios.edit', $user->id) }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Editar
            </a>
            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver al listado
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <!-- User Profile Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Perfil de Usuario</h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile.svg') }}" width="100">
                    </div>
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    <div class="mb-3">
                        @foreach($user->roles as $role)
                            <span class="badge badge-primary badge-pill px-3 py-2 mb-1">{{ $role->name }}</span>
                        @endforeach
                    </div>
                    
                    <div class="mb-3">
                        <span class="badge badge-{{ $user->status == 'active' ? 'success' : 'danger' }} badge-pill px-3 py-2">
                            {{ $user->status == 'active' ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Miembro desde</small>
                            <div>{{ $user->created_at->format('d/m/Y') }}</div>
                        </div>
                        <div>
                            <small class="text-muted">Último acceso</small>
                            <div>
                                @if(isset($user->last_login_at))
                                    {{ \Carbon\Carbon::parse($user->last_login_at)->format('d/m/Y H:i') }}
                                @else
                                    Nunca
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- User Roles Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Roles y Permisos</h6>
                </div>
                <div class="card-body">
                    <h6 class="font-weight-bold">Roles</h6>
                    <ul class="list-group mb-4">
                        @foreach($user->roles as $role)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $role->name }}
                                <span class="badge badge-primary badge-pill">{{ $role->permissions->count() }} permisos</span>
                            </li>
                        @endforeach
                    </ul>
                    
                    <h6 class="font-weight-bold">Permisos</h6>
                    <div class="alert alert-info">
                        El usuario tiene acceso a las siguientes funcionalidades a través de sus roles.
                    </div>
                    <div class="mb-3">
                        @foreach($user->getAllPermissions() as $permission)
                            <span class="badge badge-secondary badge-pill px-2 py-1 mb-1">{{ $permission->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <!-- Activity History Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Historial de Actividad</h6>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-xs">
                        <!-- Login Activity -->
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">Hoy</div>
                                <div class="timeline-item-marker-indicator bg-success"></div>
                            </div>
                            <div class="timeline-item-content">
                                Inicio de sesión exitoso
                                <span class="text-muted">12:45 PM</span>
                            </div>
                        </div>
                        
                        <!-- Edit Activity -->
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">Ayer</div>
                                <div class="timeline-item-marker-indicator bg-primary"></div>
                            </div>
                            <div class="timeline-item-content">
                                Editó una cirugía
                                <span class="text-muted">10:30 AM</span>
                            </div>
                        </div>
                        
                        <!-- Create Activity -->
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">25 Mar</div>
                                <div class="timeline-item-marker-indicator bg-primary"></div>
                            </div>
                            <div class="timeline-item-content">
                                Creó una nueva cirugía
                                <span class="text-muted">3:15 PM</span>
                            </div>
                        </div>
                        
                        <!-- Login Activity -->
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">24 Mar</div>
                                <div class="timeline-item-marker-indicator bg-success"></div>
                            </div>
                            <div class="timeline-item-content">
                                Inicio de sesión exitoso
                                <span class="text-muted">9:00 AM</span>
                            </div>
                        </div>
                        
                        <!-- Registration Activity -->
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">{{ $user->created_at->format('d M') }}</div>
                                <div class="timeline-item-marker-indicator bg-info"></div>
                            </div>
                            <div class="timeline-item-content">
                                Cuenta creada
                                <span class="text-muted">{{ $user->created_at->format('h:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- User Statistics Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Estadísticas del Usuario</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Cirugías</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pacientes</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">3</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-injured fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Reportes</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">2</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Accesos</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">8</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-sign-in-alt fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Activity Chart -->
                    <div class="chart-area">
                        <canvas id="userActivityChart"></canvas>
                    </div>
                    <div class="small text-muted mt-2">Actividad del usuario en los últimos 7 días</div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // User Activity Chart
    var ctx = document.getElementById("userActivityChart");
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"],
            datasets: [{
                label: "Actividad",
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
                data: [2, 1, 3, 0, 2, 0, 1],
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
                        // Include a dollar sign in the ticks
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
                        return datasetLabel + ': ' + tooltipItem.yLabel + ' acciones';
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection