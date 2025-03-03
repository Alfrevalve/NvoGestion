@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Reportes de Cirugías</h1>
    <a href="{{ route('cirugias.reportes.create') }}" class="btn btn-primary">Crear Nuevo Reporte</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cirugía</th>
                <th>Instrumentista</th>
                <th>Médico</th>
                <th>Institución</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportes as $reporte)
            <tr>
                <td>{{ $reporte->id }}</td>
                <td>{{ $reporte->cirugia->nombre }}</td>
                <td>{{ $reporte->instrumentista->nombre }}</td>
                <td>{{ $reporte->medico->nombre }}</td>
                <td>{{ $reporte->institucion->nombre }}</td>
                <td>{{ $reporte->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('cirugias.reportes.edit', $reporte->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('cirugias.reportes.destroy', $reporte->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
