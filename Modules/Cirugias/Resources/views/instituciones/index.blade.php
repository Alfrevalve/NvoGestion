@extends('cirugias::layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Instituciones</h1>
        <a href="{{ route('cirugias.instituciones.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nueva Institución
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th class="text-center">Cirugías</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($instituciones as $institucion)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-hospital text-primary me-2"></i>
                                        {{ $institucion->nombre }}
                                    </div>
                                </td>
                                <td>
                                    @if($institucion->direccion)
                                        <i class="fas fa-map-marker-alt text-success me-1"></i>
                                        {{ $institucion->direccion }}
                                    @else
                                        <span class="text-muted">No especificada</span>
                                    @endif
                                </td>
                                <td>
                                    @if($institucion->telefono)
                                        <i class="fas fa-phone text-success me-1"></i>
                                        {{ $institucion->telefono }}
                                    @else
                                        <span class="text-muted">No especificado</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info">
                                        {{ $institucion->cirugias_count }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('cirugias.instituciones.edit', $institucion->id) }}"
                                           class="btn btn-sm btn-info text-white"
                                           data-bs-toggle="tooltip"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($institucion->cirugias_count == 0)
                                            <form action="{{ route('cirugias.instituciones.destroy', $institucion->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Está seguro de que desea eliminar esta institución?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        data-bs-toggle="tooltip"
                                                        title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-hospital-alt fa-2x mb-3"></i>
                                        <p class="mb-0">No hay instituciones registradas</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $instituciones->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .btn-group .btn {
        margin: 0 2px;
    }

    .table td {
        vertical-align: middle;
    }

    .badge {
        font-weight: 500;
        padding: 0.5em 0.8em;
    }

    .text-primary {
        color: #0F3061 !important;
    }

    .text-success {
        color: #28a745 !important;
    }

    .bg-info {
        background-color: #0097CD !important;
    }

    .pagination {
        margin-bottom: 0;
    }

    .btn-info {
        background-color: #0097CD;
        border-color: #0097CD;
    }

    .btn-info:hover {
        background-color: #007ba6;
        border-color: #007ba6;
    }
</style>
@endsection
