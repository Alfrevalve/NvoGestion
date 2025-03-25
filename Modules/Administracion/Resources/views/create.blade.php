@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Usuario</h1>
    <form action="{{ route('modulo.administracion.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="rol">Rol</label>
            <select class="form-control" id="rol" name="rol" required>
                <option value="admin">Administrador</option>
                <option value="user">Usuario</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Usuario</button>
    </form>
</div>
@endsection
