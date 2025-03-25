@extends('layouts.main')

@section('title', 'Editar Usuario')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Editar Usuario</h1>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password">
            <small class="form-text text-muted">Deja en blanco si no deseas cambiar la contraseña.</small>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
    </form>
</div>
@endsection
