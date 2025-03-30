@extends('layouts.sb-admin-pro')

@section('title', 'Reportes de Cirugías')

@section('content')
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="fas fa-chart-bar"></i></div>
                        Reportes de Cirugías
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <button class="btn btn-sm btn-light me-2">
                        <i class="fas fa-download mr-1"></i>
                        Exportar PDF
                    </button>
                    <button class="btn btn-sm btn-light">
                        <i class="fas fa-file-excel mr-1"></i>
                        Exportar Excel
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Cirugías</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">126</div>
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
                                    Ingresos Totales</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">$250,500</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                                    Cirugías Este Mes</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">28</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                                    Cirugías Pendientes</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">12</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-chart-area me-1"></i>
                            Cirugías por Mes
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                2025
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="#">2025</a></li>
                                <li><a class="dropdown-item" href="#">2024</a></li>
                                <li><a class="dropdown-item" href="#">2023</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="myAreaChart" width="100%" height="40"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i>
                        Cirugías por Especialidad
                    </div>
                    <div class="card-body">
                        <canvas id="myPieChart" width="100%" height="50"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-table me-1"></i>
                    Reporte Detallado de Cirugías
                </div>
                <div class="d-flex">
                    <div class="input-group input-group-sm me-2" style="width: 200px;">
                        <span class="input-group-text" id="basic-addon1">Desde</span>
                        <input type="date" class="form-control" value="2025-01-01">
                    </div>
                    <div class="input-group input-group-sm me-2" style="width: 200px;">
                        <span class="input-group-text" id="basic-addon2">Hasta</span>
                        <input type="date" class="form-control" value="2025-03-25">
                    </div>
                    <button class="btn btn-sm btn-primary">Filtrar</button>
                </div>
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Paciente</th>
                            <th>Médico</th>
                            <th>Tipo de Cirugía</th>
                            <th>Duración</th>
                            <th>Estado</th>
                            <th>Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>2025-03-20</td>
                            <td>Juan Pérez</td>
                            <td>Dr. Carlos Rodríguez</td>
                            <td>Artroscopía de Rodilla</td>
                            <td>1h 30m</td>
                            <td><span class="badge bg-success">Completada</span></td>
                            <td>$3,500.00</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>2025-03-18</td>
                            <td>María González</td>
                            <td>Dra. Ana Martínez</td>
                            <td>Craneotomía</td>
                            <td>4h 15m</td>
                            <td><span class="badge bg-success">Completada</span></td>
                            <td>$12,800.00</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>2025-03-15</td>
                            <td>Roberto Sánchez</td>
                            <td>Dr. Carlos Rodríguez</td>
                            <td>Reemplazo de Cadera</td>
                            <td>2h 45m</td>
                            <td><span class="badge bg-success">Completada</span></td>
                            <td>$8,200.00</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>2025-03-12</td>
                            <td>Laura Torres</td>
                            <td>Dr. Carlos Rodríguez</td>
                            <td>Artroscopía de Hombro</td>
                            <td>1h 15m</td>
                            <td><span class="badge bg-success">Completada</span></td>
                            <td>$3,200.00</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>2025-03-10</td>
                            <td>Pedro Ramírez</td>
                            <td>Dra. Ana Martínez</td>
                            <td>Cirugía de Columna</td>
                            <td>3h 30m</td>
                            <td><span class="badge bg-success">Completada</span></td>
                            <td>$9,500.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<script>
    // Area Chart Example
    var ctx = document.getElementById("myAreaChart");
    var myLineChart = new Chart(ctx, {
        type: 'line',
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
                data: [8, 12, 28, 22, 18, 20, 24, 19, 16, 22, 25, 0],
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
            }
        }
    });

    // Pie Chart Example
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Traumatología", "Neurocirugía", "Cirugía General", "Otras"],
            datasets: [{
                data: [45, 25, 20, 10],
                backgroundColor: ['#0061f2', '#6900c7', '#00ac69', '#f4a100'],
                hoverBackgroundColor: ['#0053d9', '#5800a8', '#00925a', '#dd9000'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: true,
                position: 'bottom'
            },
            cutoutPercentage: 70,
        },
    });
</script>
@endsection