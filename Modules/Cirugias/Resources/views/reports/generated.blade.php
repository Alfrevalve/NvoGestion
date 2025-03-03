@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Reportes Generados</h1>
    <div class="mb-3">
        <a href="{{ route('cirugias.reportes.index') }}" class="btn btn-secondary">
            Volver a la Lista
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
                @forelse ($reports as $report)
                    <tr>
                        <td>{{ $report->id }}</td>
                        <td>{{ $report->fecha_cirugia->format('d/m/Y') }}</td>
                        <td>{{ $report->cirugia->tipo_cirugia }}</td>
                        <td>{{ $report->instrumentista->nombre }}</td>
                        <td>
                            <a href="{{ route('cirugias.reportes.show', $report->id) }}" class="btn btn-sm btn-info">
                                Ver Detalles
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay reportes generados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
