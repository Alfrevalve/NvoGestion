@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Generated Surgery Reports</h1>

    @if($reports->isEmpty())
        <p>No reports found for the selected criteria.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Cirugía</th>
                    <th>Estado</th>
                    <th>Prioridad</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td>{{ $report->id }}</td>
                        <td>{{ $report->tipo_cirugia }}</td>
                        <td>{{ $report->estado }}</td>
                        <td>{{ $report->prioridad }}</td>
                        <td>{{ $report->fecha }}</td>
                        <td>{{ $report->hora }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
