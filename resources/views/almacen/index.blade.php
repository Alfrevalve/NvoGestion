@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Inventario</h1>
    <a href="{{ route('almacen.create') }}" class="btn btn-primary">Agregar Nuevo Artículo</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Estado</th>
                <th>Ubicación</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventarios as $inventario)
                <tr>
                    <td>{{ $inventario->nombre }}</td>
                    <td>{{ $inventario->cantidad }}</td>
                    <td>{{ $inventario->estado }}</td>
                    <td>{{ $inventario->ubicacion }}</td>
                    <td>{{ $inventario->tipo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
