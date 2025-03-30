@extends('layouts.sb-admin-pro')

@section('title', 'Estadísticas')

@section('content')
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="fas fa-chart-pie"></i></div>
                        Estadísticas
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-primary active">Año Actual</button>
                        <button class="btn btn-sm btn-outline-primary">Último Año</button>
                        <button class="btn btn-sm btn-outline-primary">Todo el Tiempo</button>
                    </div>
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
                                    Cirugías Realizadas</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">126</div>
                                <div class="text-xs text-success mt-1">
                                    <i class="fas fa-arrow-up me-1"></i>12% vs año anterior
                                </div>
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
                                <div class="text-xs text-success mt-1">
                                    <i class="fas fa-arrow-up me-1"></i>8.3% vs año anterior
                                </div>
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
                                    Duración Promedio</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">2h 15m</div>
                                <div class="text-xs text-success mt-1">
                                    <i class="fas fa-arrow-down me-1"></i>5% vs año anterior
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                                    Nuevos Pacientes</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">82</div>
                                <div class="text-xs text-success mt-1">
                                    <i class="fas fa-arrow-up me-1"></i>15% vs año anterior
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-plus fa-2x text-gray-300"></i>
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
                            Tendencia de Ingresos
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
                        <canvas id="revenueChart" width="100%" height="40"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i>
                        Distribución de Ingresos
                    </div>
                    <div class="card-body">
                        <canvas id="revenuePieChart" width="100%" height="50"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Cirugías por Tipo
                    </div>
                    <div class="card-body">
                        <canvas id="surgeryTypeChart" width="100%" height="50"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Cirugías por Médico
                    </div>
                    <div class="card-body">
                        <canvas id="surgeryDoctorChart" width="100%" height="50"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Resumen por Mes
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Mes</th>
                            <th>Cirugías</th>
                            <th>Ingresos</th>
                            <th>Promedio por Cirugía</th>
                            <th>Nuevos Pacientes</th>
                            <th>Tendencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Enero</td>
                            <td>8</td>
                            <td>$18,200</td>
                            <td>$2,275</td>
                            <td>5</td>
                            <td><span class="badge bg-success">+12%</span></td>
                        </tr>
                        <tr>
                            <td>Febrero</td>
                            <td>12</td>
                            <td>$28,500</td>
                            <td>$2,375</td>
                            <td>8</td>
                            <td><span class="badge bg-success">+15%</span></td>
                        </tr>
                        <tr>
                            <td>Marzo</td>
                            <td>28</td>
                            <td>$72,800</td>
                            <td>$2,600</td>
                            <td>18</td>
                            <td><span class="badge bg-success">+42%</span></td>
                        </tr>
                        <tr>
                            <td>Abril</td>
                            <td>22</td>
                            <td>$56,400</td>
                            <td>$2,563</td>
                            <td>12</td>
                            <td><span class="badge bg-danger">-8%</span></td>
                        </tr>
                        <tr>
                            <td>Mayo</td>
                            <td>18</td>
                            <td>$45,900</td>
                            <td>$2,550</td>
                            <td>9</td>
                            <td><span class="badge bg-danger">-5%</span></td>
                        </tr>
                        <tr>
                            <td>Junio</td>
                            <td>20</td>
                            <td>$51,200</td>
                            <td>$2,560</td>
                            <td>14</td>
                            <td><span class="badge bg-success">+5%</span></td>
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
    // Revenue Chart
    var ctx = document.getElementById("revenueChart");
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
            datasets: [{
                label: "Ingresos",
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
                data: [18200, 28500, 72800, 56400, 45900, 51200, 62500, 48000, 42300, 58900, 65200, 0],
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
                            return '$' + value.toLocaleString();
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
                        return datasetLabel + ': $' + tooltipItem.yLabel.toLocaleString();
                    }
                }
            }
        }
    });

    // Revenue Pie Chart
    var ctx = document.getElementById("revenuePieChart");
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Traumatología", "Neurocirugía", "Cirugía General", "Otras"],
            datasets: [{
                data: [125000, 75000, 35000, 15500],
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
                callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var currentValue = dataset.data[tooltipItem.index];
                        var percentage = parseFloat((currentValue/250500*100).toFixed(1));
                        return data.labels[tooltipItem.index] + ': $' + currentValue.toLocaleString() + ' (' + percentage + '%)';
                    }
                }
            },
            legend: {
                display: true,
                position: 'bottom'
            },
            cutoutPercentage: 70,
        },
    });

    // Surgery Type Chart
    var ctx = document.getElementById("surgeryTypeChart");
    var mySurgeryTypeChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Artroscopía", "Reemplazo", "Columna", "Craneotomía", "Otros"],
            datasets: [{
                label: "Cirugías",
                backgroundColor: "#0061f2",
                hoverBackgroundColor: "#0053d9",
                borderColor: "#0061f2",
                data: [38, 32, 26, 18, 12],
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
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 6
                    },
                    maxBarThickness: 25,
                }],
                yAxes: [{
                    ticks: {
                        min: 0,
                        max: 40,
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
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
        }
    });

    // Surgery Doctor Chart
    var ctx = document.getElementById("surgeryDoctorChart");
    var mySurgeryDoctorChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: ["Dr. Carlos Rodríguez", "Dra. Ana Martínez", "Dr. Jorge Méndez", "Dra. Laura Soto", "Dr. Miguel Vargas"],
            datasets: [{
                label: "Cirugías",
                backgroundColor: "#6900c7",
                hoverBackgroundColor: "#5800a8",
                borderColor: "#6900c7",
                data: [45, 32, 25, 18, 6],
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
                    ticks: {
                        min: 0,
                        max: 50,
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
                yAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    maxBarThickness: 25,
                }],
            },
            legend: {
                display: false
            },
            tooltips: {
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
        }
    });
</script>
@endsection