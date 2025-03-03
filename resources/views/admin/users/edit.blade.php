@extends('layouts.main')

@section('title', 'Editar Usuario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Editar Usuario: {{ $user->name }}</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Información del Usuario</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password">
                            <small class="form-text text-muted">
                                Dejar en blanco para mantener la contraseña actual
                            </small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control"
                                   id="password_confirmation" name="password_confirmation">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Roles</label>
                            @if($user->hasRole('super-admin') && !auth()->user()->hasRole('super-admin'))
                                <div class="alert alert-info">
                                    No puedes modificar los roles del Super Admin
                                </div>
                                @foreach($user->roles as $role)
                                    <div class="badge bg-primary me-1">{{ ucfirst($role->name) }}</div>
                                @endforeach
                            @else
                                <div class="row">
                                    @foreach($roles as $role)
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                       name="roles[]" value="{{ $role->id }}"
                                                       id="role_{{ $role->id }}"
                                                       {{ $user->hasRole($role->name) ? 'checked' : '' }}
                                                       {{ $role->name === 'super-admin' && !auth()->user()->hasRole('super-admin') ? 'disabled' : '' }}>
                                                <label class="form-check-label" for="role_{{ $role->id }}">
                                                    {{ ucfirst($role->name) }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('roles')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Actualizar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Información Adicional</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Estado</span>
                            @if($user->email_verified_at)
                                <span class="badge bg-success">Verificado</span>
                            @else
                                <span class="badge bg-warning">Pendiente</span>
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Fecha de Registro</span>
                            <span>{{ $user->created_at->format('d/m/Y H:i') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Último Acceso</span>
                            <span>{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'N/A' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            @if($user->roles->isNotEmpty())
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Permisos por Rol</h5>
                    </div>
                    <div class="card-body">
                        @foreach($user->roles as $role)
                            <h6 class="mt-3">{{ ucfirst($role->name) }}</h6>
                            <div class="small">
                                @foreach($role->permissions as $permission)
                                    <span class="badge bg-info me-1 mb-1">{{ $permission->name }}</span>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
