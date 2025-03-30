@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between mb-4">
        <div class="col-md-6">
            <h1>Gestión de Cirugías</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('cirugias.calendario') }}" class="btn btn-info">Ver Calendario</a>
            <a href="#" class="btn btn-primary">Nueva Cirugía</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Listado de Cirugías</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Paciente</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cirugias as $cirugia)
                    <tr>
                        <td>{{ $cirugia->id }}</td>
                        <td>{{ $cirugia->nombre }}</td>
                        <td>{{ $cirugia->fecha_inicio ? $cirugia->fecha_inicio->format('d/m/Y H:i') : 'No definida' }}</td>
                        <td>{{ $cirugia->paciente ? $cirugia->paciente->nombre : 'No asignado' }}</td>
                        <td>
                            <span class="badge badge-{{ $cirugia->estado == 'Completada' ? 'success' : ($cirugia->estado == 'Pendiente' ? 'warning' : 'info') }}">
                                {{ $cirugia->estado ?? 'Pendiente' }}
                            </span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info">Ver</a>
                            <a href="#" class="btn btn-sm btn-primary">Editar</a>
                            <a href="#" class="btn btn-sm btn-danger">Eliminar</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay cirugías registradas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
