<!-- resources/views/despacho/rutas/show.blade.php -->

@extends('layouts.master')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-3">Detalles de la Ruta</h1>

        @if(isset($ruta))
            <div class="card">
                <div class="card-header">
                    <h3>{{ $ruta->nombre }}</h3>
                </div>
                <div class="card-body">
                    <p><strong>Descripción:</strong> {{ $ruta->descripcion }}</p>
                    <p><strong>Origen:</strong> {{ $ruta->origen }}</p>
                    <p><strong>Destino:</strong> {{ $ruta->destino }}</p>
                    <p><strong>Distancia:</strong> {{ $ruta->distancia }} km</p>
                    <p><strong>Tiempo Estimado:</strong> {{ $ruta->tiempo_estimado }} horas</p>
                    <p><strong>Estado:</strong> {!! $ruta->activo ? '<span class="badge bg-success">Activa</span>' : '<span class="badge bg-danger">Inactiva</span>' !!}</p>
                    <p><strong>Creado el:</strong> {{ optional($ruta->created_at)->format('d/m/Y H:i') }}</p>
                    <p><strong>Última actualización:</strong> {{ optional($ruta->updated_at)->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            @if(isset($ruta->vehiculos) && $ruta->vehiculos->count() > 0)
                <h2 class="mt-4">Vehículos Asignados</h2>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Modelo</th>
                            <th>Matrícula</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ruta->vehiculos as $vehiculo)
                            <tr>
                                <td>{{ $vehiculo->id }}</td>
                                <td>{{ $vehiculo->modelo }}</td>
                                <td>{{ $vehiculo->matricula }}</td>
                                <td>{!! $vehiculo->activo ? '<span class="badge bg-success">Operativo</span>' : '<span class="badge bg-danger">Inactivo</span>' !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="mt-3 text-muted">No hay vehículos asignados a esta ruta.</p>
            @endif
        @else
            <p class="text-danger">No se encontró la información de la ruta.</p>
        @endif

        <a href="{{ route('rutas.index') }}" class="btn btn-primary mt-3">Volver a la Lista de Rutas</a>
    </div>
@endsection
