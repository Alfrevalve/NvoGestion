@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Usuario</h1>
    <form action="{{ route('modulo.administracion.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $usuario->nombre }}" required>
        </div>
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}" required>
        </div>
        <div class="form-group">
            <label for="rol">Rol</label>
            <select class="form-control" id="rol" name="rol" required>
                <option value="admin" {{ $usuario->rol == 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="user" {{ $usuario->rol == 'user' ? 'selected' : '' }}>Usuario</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
    </form>
</div>
@endsection
