@extends('adminlte::page')

@section('title', 'Inventario')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Inventario</h1>
        @can('crear items')
            <a href="{{ route('almacen.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Item
            </a>
        @endcan
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8">
                    <form action="{{ route('almacen.index') }}" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Buscar items..."
                                   value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <div class="float-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Filtrar por Estado
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('almacen.index') }}">Todos</a>
                                <a class="dropdown-item" href="{{ route('almacen.index', ['estado' => 'disponible']) }}">Disponible</a>
                                <a class="dropdown-item" href="{{ route('almacen.index', ['estado' => 'agotado']) }}">Agotado</a>
                                <a class="dropdown-item" href="{{ route('almacen.index', ['estado' => 'stock_bajo']) }}">Stock Bajo</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if($inventarios->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Estado</th>
                                <th>Ubicación</th>
                                <th>Última Actualización</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inventarios as $item)
                                <tr>
                                    <td>{{ $item->codigo }}</td>
                                    <td>{{ $item->nombre }}</td>
                                    <td>
                                        <span class="badge badge-{{ $item->cantidad <= $item->stock_minimo ? 'warning' : 'info' }}">
                                            {{ $item->cantidad }}
                                        </span>
                                    </td>
                                    <td>
                                        @switch($item->estado)
                                            @case('disponible')
                                                <span class="badge badge-success">Disponible</span>
                                                @break
                                            @case('agotado')
                                                <span class="badge badge-danger">Agotado</span>
                                                @break
                                            @case('stock_bajo')
                                                <span class="badge badge-warning">Stock Bajo</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ $item->estado }}</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $item->ubicacion }}</td>
                                    <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('almacen.show', $item) }}" class="btn btn-sm btn-default" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @can('editar items')
                                                <a href="{{ route('almacen.edit', $item) }}" class="btn btn-sm btn-info" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('eliminar items')
                                                <form action="{{ route('almacen.destroy', $item) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('¿Está seguro de que desea eliminar este item?')"
                                                            title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $inventarios->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No hay items en el inventario</p>
                    @can('crear items')
                        <a href="{{ route('almacen.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Agregar Primer Item
                        </a>
                    @endcan
                </div>
            @endif
        </div>
    </div>

    <!-- Resumen de Inventario -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $inventarios->count() }}</h3>
                    <p>Items Totales</p>
                </div>
                <div class="icon">
                    <i class="fas fa-boxes"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $inventarios->where('estado', 'disponible')->count() }}</h3>
                    <p>Items Disponibles</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $inventarios->where('estado', 'stock_bajo')->count() }}</h3>
                    <p>Stock Bajo</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $inventarios->where('estado', 'agotado')->count() }}</h3>
                    <p>Items Agotados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
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
        // Auto-hide alerts
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 3000);
        });
    </script>
@stop
