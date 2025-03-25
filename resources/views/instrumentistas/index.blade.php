@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Listado de Instrumentistas</h1>
    <a href="{{ route('modulo.instrumentistas.create') }}" class="btn btn-primary">Crear Nuevo Instrumentista</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($instrumentistas as $instrumentista)
            <tr>
                <td>{{ $instrumentista->nombre }}</td>
                <td>
                    <a href="{{ route('modulo.instrumentistas.edit', $instrumentista->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('modulo.instrumentistas.destroy', $instrumentista->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $instrumentistas->links() }}
</div>
@endsection
