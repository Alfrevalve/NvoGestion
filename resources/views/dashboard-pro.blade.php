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
    <!-- Main Dashboard Content -->
    <div class="row">
        <!-- Total Cirugías Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-primary border-start-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Cirugías</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">215</div>
                        </div>
                        <div class="text-primary"><i class="fas fa-procedures fa-2x"></i></div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-primary stretched-link" href="#">Ver Detalles</a>
                    <div class="text-primary"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <!-- Cirugías Pendientes Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-warning border-start-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">Cirugías Pendientes</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">18</div>
                        </div>
                        <div class="text-warning"><i class="fas fa-calendar-alt fa-2x"></i></div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-warning stretched-link" href="#">Ver Pendientes</a>
                    <div class="text-warning"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <!-- Cirugías Completadas Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-success border-start-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">Cirugías Completadas</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">189</div>
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

        <!-- Médicos Activos Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-info border-start-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">Médicos Activos</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">24</div>
                        </div>
                        <div class="text-info"><i class="fas fa-user-md fa-2x"></i></div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between small">
                    <a class="text-info stretched-link" href="#">Ver Médicos</a>
                    <div class="text-info"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-8 mb-4">
            <div class="card card-header-actions h-100">
                <div class="card-header">
                    Cirugías por Mes
                    <div class="dropdown no-caret">
                        <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="areaChartDropdownExample" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                        <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="areaChartDropdownExample">
                            <a class="dropdown-item" href="#!">Este Año</a>
                            <a class="dropdown-item" href="#!">Últimos 6 Meses</a>
                            <a class="dropdown-item" href="#!">Últimos 3 Meses</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#!">Exportar Reporte</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area"><canvas id="myAreaChart" width="100%" height="30"></canvas></div>
                </div>
            </div>
        </div>
        
        <!-- Pie Chart -->
        <div class="col-xl-4 mb-4">
            <div class="card card-header-actions h-100">
                <div class="card-header">
                    Cirugías por Especialidad
                    <div class="dropdown no-caret">
                        <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="pieChartDropdownExample" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                        <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="pieChartDropdownExample">
                            <a class="dropdown-item" href="#!">Este Año</a>
                            <a class="dropdown-item" href="#!">Últimos 6 Meses</a>
                            <a class="dropdown-item" href="#!">Últimos 3 Meses</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#!">Exportar Reporte</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-pie mb-4"><canvas id="myPieChart" width="100%" height="50"></canvas></div>
                    <div class="list-group list-group-flush small">
                        <div class="list-group-item d-flex align-items-center justify-content-between">
                            <div class="me-3">
                                <i class="fas fa-circle fa-sm text-blue"></i>
                                Traumatología
                            </div>
                            <div class="fw-500 text-dark">35%</div>
                        </div>
                        <div class="list-group-item d-flex align-items-center justify-content-between">
                            <div class="me-3">
                                <i class="fas fa-circle fa-sm text-purple"></i>
                                Neurocirugía
                            </div>
                            <div class="fw-500 text-dark">25%</div>
                        </div>
                        <div class="list-group-item d-flex align-items-center justify-content-between">
                            <div class="me-3">
                                <i class="fas fa-circle fa-sm text-green"></i>
                                Cirugía General
                            </div>
                            <div class="fw-500 text-dark">20%</div>
                        </div>
                        <div class="list-group-item d-flex align-items-center justify-content-between">
                            <div class="me-3">
                                <i class="fas fa-circle fa-sm text-yellow"></i>
                                Otras
                            </div>
                            <div class="fw-500 text-dark">20%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cirugías Recientes y Actividad -->
    <div class="row">
        <!-- Cirugías Recientes Table -->
        <div class="col-lg-7 mb-4">
            <div class="card mb-4">
                <div class="card-header">Cirugías Recientes</div>
                <div class="card-body p-0">
                    <!-- Responsive Data Table -->
                    <div class="table-responsive table-scroll" style="max-height: 400px">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Paciente</th>
                                    <th>Médico</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Ricardo Martínez</td>
                                    <td>Dr. González</td>
                                    <td>24/03/2025</td>
                                    <td><span class="badge bg-success">Completada</span></td>
                                    <td><a href="#" class="btn btn-sm btn-icon btn-transparent-dark"><i class="fas fa-eye"></i></a></td>
                                </tr>
                                <tr>
                                    <td>Ana Rodríguez</td>
                                    <td>Dra. Sánchez</td>
                                    <td>23/03/2025</td>
                                    <td><span class="badge bg-success">Completada</span></td>
                                    <td><a href="#" class="btn btn-sm btn-icon btn-transparent-dark"><i class="fas fa-eye"></i></a></td>
                                </tr>
                                <tr>
                                    <td>Carlos Pérez</td>
                                    <td>Dr. Torres</td>
                                    <td>25/03/2025</td>
                                    <td><span class="badge bg-warning">Pendiente</span></td>
                                    <td><a href="#" class="btn btn-sm btn-icon btn-transparent-dark"><i class="fas fa-eye"></i></a></td>
                                </tr>
                                <tr>
                                    <td>Lucía Fernández</td>
                                    <td>Dr. González</td>
                                    <td>26/03/2025</td>
                                    <td><span class="badge bg-warning">Pendiente</span></td>
                                    <td><a href="#" class="btn btn-sm btn-icon btn-transparent-dark"><i class="fas fa-eye"></i></a></td>
                                </tr>
                                <tr>
                                    <td>Javier López</td>
                                    <td>Dra. Ramírez</td>
                                    <td>22/03/2025</td>
                                    <td><span class="badge bg-success">Completada</span></td>
                                    <td><a href="#" class="btn btn-sm btn-icon btn-transparent-dark"><i class="fas fa-eye"></i></a></td>
                                </tr>
                                <tr>
                                    <td>Miguel Ángel</td>
                                    <td>Dr. Torres</td>
                                    <td>27/03/2025</td>
                                    <td><span class="badge bg-primary">Programada</span></td>
                                    <td><a href="#" class="btn btn-sm btn-icon btn-transparent-dark"><i class="fas fa-eye"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a class="text-primary small stretched-link" href="#">Ver todas las cirugías</a>
                </div>
            </div>
        </div>
        
        <!-- Actividad Reciente Timeline -->
        <div class="col-lg-5 mb-4">
            <div class="card card-header-actions h-100">
                <div class="card-header">
                    Actividad Reciente
                    <div class="dropdown no-caret">
                        <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                        <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="dropdownMenuButton">
                            <h6 class="dropdown-header">Filtrar Actividades:</h6>
                            <a class="dropdown-item" href="#!"><span class="badge bg-primary-soft text-primary me-2">Todas</span></a>
                            <a class="dropdown-item" href="#!"><span class="badge bg-blue-soft text-blue me-2">Cirugías</span></a>
                            <a class="dropdown-item" href="#!"><span class="badge bg-green-soft text-green me-2">Almacén</span></a>
                            <a class="dropdown-item" href="#!"><span class="badge bg-yellow-soft text-yellow me-2">Sistema</span></a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="timeline timeline-xs px-3 py-3">
                        <!-- Timeline Item 1-->
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">27min</div>
                                <div class="timeline-item-marker-indicator bg-green"></div>
                            </div>
                            <div class="timeline-item-content">
                                Nueva cirugía registrada por <a class="fw-bold text-dark" href="#!">Dr. Torres</a>
                                <br/>
                                <span class="small text-muted">Paciente: Carlos Pérez</span>
                            </div>
                        </div>
                        <!-- Timeline Item 2-->
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">58min</div>
                                <div class="timeline-item-marker-indicator bg-blue"></div>
                            </div>
                            <div class="timeline-item-content">
                                Cirugía completada con éxito
                                <br/>
                                <span class="small text-muted">Paciente: Ricardo Martínez</span>
                            </div>
                        </div>
                        <!-- Timeline Item 3-->
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">2h</div>
                                <div class="timeline-item-marker-indicator bg-purple"></div>
                            </div>
                            <div class="timeline-item-content">
                                <a class="fw-bold text-dark" href="#!">Ana Méndez</a> actualizó el inventario
                                <br/>
                                <span class="small text-muted">5 nuevos items agregados</span>
                            </div>
                        </div>
                        <!-- Timeline Item 4-->
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">1d</div>
                                <div class="timeline-item-marker-indicator bg-yellow"></div>
                            </div>
                            <div class="timeline-item-content">
                                Despacho completado para Hospital San José
                                <br/>
                                <span class="small text-muted">Responsable: Luis Ramírez</span>
                            </div>
                        </div>
                        <!-- Timeline Item 5-->
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">1d</div>
                                <div class="timeline-item-marker-indicator bg-red"></div>
                            </div>
                            <div class="timeline-item-content">
                                Alerta de stock bajo en almacén
                                <br/>
                                <span class="small text-muted">3 productos requieren reposición</span>
                            </div>
                        </div>
                        <!-- Timeline Item 6-->
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">1w</div>
                                <div class="timeline-item-marker-indicator bg-primary"></div>
                            </div>
                            <div class="timeline-item-content">
                                Nuevo usuario registrado
                                <br/>
                                <span class="small text-muted">Dra. Carmen López</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a class="text-primary small stretched-link" href="#">Ver todas las actividades</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Area Chart Example
        var ctx = document.getElementById("myAreaChart").getContext("2d");
        var myLineChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                datasets: [{
                    label: "Cirugías",
                    lineTension: 0.3,
                    backgroundColor: "rgba(0, 97, 242, 0.05)",
                    borderColor: "rgba(0, 97, 242, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(0, 97, 242, 1)",
                    pointBorderColor: "rgba(0, 97, 242, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(0, 97, 242, 1)",
                    pointHoverBorderColor: "rgba(0, 97, 242, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: [15, 18, 22, 25, 27, 30, 35, 32, 38, 36, 40, 42]
                }]
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
                    x: {
                        time: {
                            unit: "month"
                        },
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 12
                        }
                    },
                    y: {
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10
                        },
                        grid: {
                            color: "rgba(0, 0, 0, 0.05)",
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: "rgba(0, 0, 0, 0.7)",
                        bodyFont: {
                            size: 12
                        },
                        titleFont: {
                            size: 14
                        }
                    }
                }
            }
        });

        // Pie Chart Example
        var ctx2 = document.getElementById("myPieChart").getContext("2d");
        var myPieChart = new Chart(ctx2, {
            type: "doughnut",
            data: {
                labels: ["Traumatología", "Neurocirugía", "Cirugía General", "Otras"],
                datasets: [{
                    data: [35, 25, 20, 20],
                    backgroundColor: ["#0061f2", "#6900c7", "#00ac69", "#f4a100"],
                    hoverBackgroundColor: ["#0052cc", "#5800a8", "#009157", "#d98b00"],
                    hoverBorderColor: "rgba(234, 236, 244, 1)"
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: "rgba(0, 0, 0, 0.7)",
                        bodyFont: {
                            size: 12
                        },
                        titleFont: {
                            size: 14
                        }
                    }
                },
                cutout: "70%"
            }
        });
    </script>
@endsection