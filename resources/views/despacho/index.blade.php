@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Despachos</h1>
    <a href="{{ route('despacho.create') }}" class="btn btn-primary">Agregar Nuevo Despacho</a>
    <table class="table">
        <thead>
            <tr>
                <th>Pedido ID</th>
                <th>Estado</th>
                <th>Fecha de Despacho</th>
                <th>Destinatario</th>
                <th>Dirección</th>
            </tr>
        </thead>
        <tbody>
            @foreach($despachos as $despacho)
                <tr>
                    <td>{{ $despacho->pedido_id }}</td>
                    <td>{{ $despacho->estado }}</td>
                    <td>{{ $despacho->fecha_despacho }}</td>
                    <td>{{ $despacho->destinatario }}</td>
                    <td>{{ $despacho->direccion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
