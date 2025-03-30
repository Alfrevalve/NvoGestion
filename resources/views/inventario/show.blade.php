@extends('layouts.sb-admin-pro')

@section('title', 'Detalle de Producto')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detalle de Producto</h1>
        <div>
            <a href="{{ route('inventario.edit', $inventario->id) }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Editar
            </a>
            <a href="{{ route('inventario.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver al inventario
            </a>
        </div>
    </div>

    <!-- Product Details Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Información del Producto</h6>
            <span class="badge badge-{{ $inventario->estado == 'Disponible' ? 'success' : ($inventario->estado == 'Agotado' ? 'danger' : 'warning') }}">
                {{ $inventario->estado }}
            </span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 30%">Código:</th>
                            <td><strong>{{ $inventario->codigo }}</strong></td>
                        </tr>
                        <tr>
                            <th>Nombre:</th>
                            <td>{{ $inventario->nombre }}</td>
                        </tr>
                        <tr>
                            <th>Categoría:</th>
                            <td>{{ $inventario->categoria }}</td>
                        </tr>
                        <tr>
                            <th>Fecha de Ingreso:</th>
                            <td>{{ date('d/m/Y', strtotime($inventario->fecha_ingreso)) }}</td>
                        </tr>
                        <tr>
                            <th>Stock:</th>
                            <td>
                                <span class="badge badge-{{ $inventario->stock > 0 ? 'success' : 'danger' }}">
                                    {{ $inventario->stock }} unidades
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Precio:</th>
                            <td>${{ number_format($inventario->precio, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Estado:</th>
                            <td>
                                <span class="badge badge-{{ $inventario->estado == 'Disponible' ? 'success' : ($inventario->estado == 'Agotado' ? 'danger' : 'warning') }}">
                                    {{ $inventario->estado }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="font-weight-bold text-primary mb-0">Descripción</h6>
                        </div>
                        <div class="card-body">
                            <p>{{ $inventario->descripcion }}</p>
                        </div>
                    </div>
                    
                    <!-- Stock Movement Chart -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="font-weight-bold text-primary mb-0">Movimiento de Stock</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="stockChart"></canvas>
                            </div>
                            <div class="small text-muted mt-2">Movimiento de stock de los últimos 6 meses</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Usage History -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Historial de Uso</h6>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i> No hay registros de uso para este producto.
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Productos Relacionados</h6>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i> No hay productos relacionados.
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Stock Movement Chart
    var ctx = document.getElementById("stockChart");
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun"],
            datasets: [{
                label: "Stock",
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
                data: [{{ $inventario->stock }}, {{ $inventario->stock }}, {{ $inventario->stock }}, {{ $inventario->stock }}, {{ $inventario->stock }}, {{ $inventario->stock }}],
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