@extends('cirugias::layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Médicos</h1>
        <a href="{{ route('cirugias.medicos.create') }}" class="btn btn-primary">
            <i class="fas fa-user-md me-2"></i>Nuevo Médico
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
                            <th>Especialidad</th>
                            <th>Teléfono</th>
                            <th class="text-center">Cirugías</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($medicos as $medico)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user-md text-primary me-2"></i>
                                        {{ $medico->nombre }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $medico->especialidad }}
                                    </span>
                                </td>
                                <td>{{ $medico->telefono ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">
                                        {{ $medico->cirugias->count() }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('cirugias.medicos.edit', $medico) }}"
                                           class="btn btn-sm btn-info text-white"
                                           data-bs-toggle="tooltip"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('cirugias.medicos.destroy', $medico) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de que desea eliminar este médico?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    data-bs-toggle="tooltip"
                                                    title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-user-md fa-2x mb-3"></i>
                                        <p class="mb-0">No hay médicos registrados</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $medicos->links() }}
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

    .bg-info {
        background-color: #0097CD !important;
    }

    .pagination {
        margin-bottom: 0;
    }
</style>
@endsection
