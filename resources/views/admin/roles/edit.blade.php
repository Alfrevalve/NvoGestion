@extends('layouts.main')

@section('title', 'Editar Rol')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Editar Rol: {{ ucfirst($role->name) }}</h1>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre del Rol</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name" value="{{ old('name', $role->name) }}"
                           {{ $role->name === 'super-admin' ? 'readonly' : '' }} required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label d-block">Permisos</label>
                    @if($role->name === 'super-admin')
                        <div class="alert alert-info">
                            El rol Super Admin tiene todos los permisos por defecto.
                        </div>
                    @else
                        <div class="mb-3">
                            <button type="button" class="btn btn-outline-secondary btn-sm me-2"
                                    onclick="toggleAllPermissions(true)">
                                <i class="fas fa-check-square me-1"></i>Seleccionar Todos
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm"
                                    onclick="toggleAllPermissions(false)">
                                <i class="fas fa-square me-1"></i>Deseleccionar Todos
                            </button>
                        </div>

                        <div class="row">
                            @foreach($permissions->chunk(3) as $chunk)
                                <div class="col-md-4">
                                    @foreach($chunk as $permission)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox"
                                                   name="permissions[]" value="{{ $permission->id }}"
                                                   id="permission_{{ $permission->id }}"
                                                   {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        @error('permissions')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    @endif
                </div>

                @if($role->name !== 'super-admin')
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Actualizar Rol
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>

    @if($role->users->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Usuarios con este Rol</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Fecha de Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($role->users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    function toggleAllPermissions(checked) {
        document.querySelectorAll('input[name="permissions[]"]').forEach(checkbox => {
            checkbox.checked = checked;
        });
    }
</script>
@endsection
