@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="login-container">
    <h2><img src="{{ asset('images/logo.png') }}" alt="GesVitalPro Logo" style="width: 100px;"></h2>
    <h2>Iniciar Sesión</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Iniciar Sesión</button>
    </form>
</div>
@endsection
