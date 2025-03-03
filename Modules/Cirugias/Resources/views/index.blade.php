@extends('adminlte::page')

@section('title', 'Cirugías')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Cirugías</h1>
        @can('crear cirugias')
            <a href="{{ route('modulo.cirugias.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nueva Cirugía
            </a>
        @endcan
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Cirugías</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            @if($cirugias->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Médico</th>
                                <th>Institución</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cirugias as $cirugia)
                                <tr>
                                    <td>{{ $cirugia->id }}</td>
                                    <td>{{ $cirugia->fecha->format('d/m/Y') }}</td>
                                    <td>{{ $cirugia->hora->format('H:i') }}</td>
                                    <td>{{ $cirugia->medico->nombre ?? 'No asignado' }}</td>
                                    <td>{{ $cirugia->institucion->nombre ?? 'No asignada' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $cirugia->estado == 'pendiente' ? 'primary' :
                                                             ($cirugia->estado == 'programada' ? 'info' :
                                                             ($cirugia->estado == 'en proceso' ? 'warning' : 'success')) }}">
                                            {{ ucfirst($cirugia->estado) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('modulo.cirugias.show', $cirugia) }}" class="btn btn-default btn-sm" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @can('editar cirugias')
                                                <a href="{{ route('modulo.cirugias.edit', $cirugia) }}" class="btn btn-info btn-sm" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('eliminar cirugias')
                                                <form action="{{ route('modulo.cirugias.destroy', $cirugia) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar"
                                                            onclick="return confirm('¿Está seguro de que desea eliminar esta cirugía?')">
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
                    {{ $cirugias->links() }}
                </div>
            @else
                <div class="text-center text-muted">
                    <i class="fas fa-procedures fa-3x mb-3"></i>
                    <p>No hay cirugías registradas</p>
                </div>
            @endif
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        // Aquí puedes agregar JavaScript personalizado
    </script>
@stop
