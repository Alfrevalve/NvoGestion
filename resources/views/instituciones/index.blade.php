@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Listado de Instituciones</h1>
    <a href="{{ route('modulo.instituciones.create') }}" class="btn btn-primary">Crear Nueva Institución</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($instituciones as $institucion)
            <tr>
                <td>{{ $institucion->nombre }}</td>
                <td>
                    <a href="{{ route('modulo.instituciones.edit', $institucion->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('modulo.instituciones.destroy', $institucion->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $instituciones->links() }}
</div>
@endsection
