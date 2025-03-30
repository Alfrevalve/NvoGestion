@extends('layouts.sb-admin-pro')

@section('title', 'Inventario - GesVitalPro')

@section('header-icon')
    <i class="fas fa-boxes"></i>
@endsection

@section('header-title', 'Inventario')

@section('header-subtitle', 'Gestión de inventario y almacén')

@section('header-actions')
    <a class="btn btn-white text-primary" href="{{ route('almacen.create') }}">
        <i class="fas fa-plus mr-2"></i>
        Nuevo Artículo
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>Inventario</div>
                <div>
                    <a href="{{ route('almacen.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i> Nuevo Artículo
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                    <th>Ubicación</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventarios as $inventario)
                    <tr>
                        <td>{{ $inventario->nombre }}</td>
                        <td>
                            @if($inventario->cantidad <= 5)
                                <span class="badge bg-danger">{{ $inventario->cantidad }}</span>
                            @elseif($inventario->cantidad <= 10)
                                <span class="badge bg-warning">{{ $inventario->cantidad }}</span>
                            @else
                                <span class="badge bg-success">{{ $inventario->cantidad }}</span>
                            @endif
                        </td>
                        <td>{{ $inventario->estado }}</td>
                        <td>{{ $inventario->ubicacion }}</td>
                        <td>{{ $inventario->tipo }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-icon btn-transparent-dark me-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-icon btn-transparent-dark">
                                <i class="fas fa-trash"></i>
                            </a>
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
