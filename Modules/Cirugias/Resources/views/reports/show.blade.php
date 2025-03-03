@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles del Reporte de Cirugía</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Reporte #{{ $reporte->id }}</h5>
            <p class="card-text"><strong>Fecha de Cirugía:</strong> {{ $reporte->fecha_cirugia->format('d/m/Y') }}</p>
            <p class="card-text"><strong>Cirugía:</strong> {{ $reporte->cirugia->tipo_cirugia }}</p>
            <p class="card-text"><strong>Instrumentista:</strong> {{ $reporte->instrumentista->nombre }}</p>
            <p class="card-text"><strong>Descripción:</strong> {{ $reporte->descripcion }}</p>
            <p class="card-text"><strong>Observaciones:</strong> {{ $reporte->observaciones }}</p>
        </div>
    </div>
    <div class="mt-3">
        <a href="{{ route('cirugias.reportes.index') }}" class="btn btn-secondary">
            Volver a la Lista
        </a>
    </div>
</div>
@endsection
