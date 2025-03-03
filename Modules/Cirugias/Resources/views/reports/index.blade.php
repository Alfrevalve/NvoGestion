@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Reportes de Cirugías</h1>
    <div class="mb-3">
        <a href="{{ route('cirugias.reportes.generate') }}" class="btn btn-primary">
            Generar Nuevo Reporte
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha de Cirugía</th>
                    <th>Cirugía</th>
                    <th>Instrumentista</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reportes as $reporte)
                    <tr>
                        <td>{{ $reporte->id }}</td>
                        <td>{{ $reporte->fecha_cirugia->format('d/m/Y') }}</td>
                        <td>{{ $reporte->cirugia->tipo_cirugia }}</td>
                        <td>{{ $reporte->instrumentista->nombre }}</td>
                        <td>
                            <a href="{{ route('cirugias.reportes.show', $reporte->id) }}" class="btn btn-sm btn-info">
                                Ver Detalles
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay reportes disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
