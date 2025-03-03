@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kanban de Cirugías</h1>

    @if (session('alertas'))
        @foreach (session('alertas') as $alerta)
            <div class="alert alert-{{ $alerta['tipo'] }}">
                {{ $alerta['mensaje'] }}
            </div>
        @endforeach
    @endif

    <div class="row">
        @foreach ($cirugias as $estado => $items)
            <div class="col">
                <h2>{{ ucfirst($estado) }}</h2>
                <ul class="list-group">
                    @foreach ($items as $cirugia)
                        <li class="list-group-item">
                            {{ $cirugia->nombre }} - {{ $cirugia->fecha }} - {{ $cirugia->hora }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    <div class="stats">
        <h3>Estadísticas</h3>
        <ul>
            <li>Total: {{ $stats['total'] }}</li>
            <li>Pendientes: {{ $stats['pendientes'] }}</li>
            <li>Programadas: {{ $stats['programadas'] }}</li>
            <li>En Proceso: {{ $stats['en_proceso'] }}</li>
            <li>Finalizadas: {{ $stats['finalizadas'] }}</li>
            <li>Hoy: {{ $stats['hoy'] }}</li>
            <li>Esta Semana: {{ $stats['semana'] }}</li>
        </ul>
    </div>
</div>
@endsection
