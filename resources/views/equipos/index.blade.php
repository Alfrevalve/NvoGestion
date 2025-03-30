@extends('layouts.sb-admin-pro')

@section('title', 'Equipos - GesVitalPro')

@section('header-icon')
    <i class="fas fa-toolbox"></i>
@endsection

@section('header-title', 'Equipos')

@section('header-subtitle', 'Gestión de equipos médicos')

@section('header-actions')
    <a class="btn btn-white text-primary" href="{{ route('equipos.create') }}">
        <i class="fas fa-plus mr-2"></i>
        Nuevo Equipo
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>Listado de Equipos</div>
                <div>
                    <a href="{{ route('equipos.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i> Nuevo Equipo
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
            <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
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
                    <td>
                        @if($equipo->estado == 'Activo')
                            <span class="badge bg-success">{{ $equipo->estado }}</span>
                        @elseif($equipo->estado == 'Inactivo')
                            <span class="badge bg-danger">{{ $equipo->estado }}</span>
                        @elseif($equipo->estado == 'Mantenimiento')
                            <span class="badge bg-warning">{{ $equipo->estado }}</span>
                        @else
                            <span class="badge bg-secondary">{{ $equipo->estado }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('equipos.edit', $equipo->id) }}" class="btn btn-sm btn-icon btn-transparent-dark me-1">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-icon btn-transparent-dark">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
            </div>
                </div>
    </div>
</div>
@endsection
