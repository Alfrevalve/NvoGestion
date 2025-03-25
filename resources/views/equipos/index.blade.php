@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Listado de Equipos</h1>
    <a href="{{ route('modulo.equipos.create') }}" class="btn btn-primary">Crear Nuevo Equipo</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipos as $equipo)
            <tr>
                <td>{{ $equipo->nombre }}</td>
                <td>{{ $equipo->estado }}</td>
                <td>
                    <a href="{{ route('modulo.equipos.edit', $equipo->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('modulo.equipos.destroy', $equipo->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $equipos->links() }}
</div>
@endsection
