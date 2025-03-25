@extends('layouts.main')

@section('title', 'Crear Usuario')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Crear Nuevo Usuario</h1>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear Usuario</button>
    </form>
</div>
@endsection
