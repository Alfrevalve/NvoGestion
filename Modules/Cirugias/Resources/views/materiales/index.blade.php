@extends('cirugias::layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title m-0">
                    <i class="fas fa-boxes mr-2"></i> Control de Inventario
                </h3>
                <a href="{{ route('cirugias.materiales.create') }}" class="btn btn-light">
                    <i class="fas fa-plus"></i> Nuevo Material
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4">Código</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Mínimo</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center px-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($materiales as $material)
                            <tr class="{{ $material->cantidad <= $material->cantidad_minima ? 'bg-warning-subtle' : '' }}">
                                <td class="px-4"><strong>{{ $material->codigo ?: 'N/A' }}</strong></td>
                                <td>{{ $material->nombre }}</td>
                                <td>{{ $material->descripcion ?: 'Sin descripción' }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $material->cantidad <= $material->cantidad_minima ? 'bg-danger' : 'bg-success' }} rounded-pill">
                                        {{ $material->cantidad }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary rounded-pill">
                                        {{ $material->cantidad_minima ?: '0' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($material->cantidad <= $material->cantidad_minima)
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-exclamation-triangle"></i> Stock Bajo
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle"></i> OK
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center px-4">
                                    <div class="btn-group">
                                        <a href="{{ route('cirugias.materiales.edit', $material) }}"
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('cirugias.materiales.destroy', $material) }}"
                                              method="POST"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('¿Está seguro que desea eliminar este material?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3 d-block"></i>
                                    <p class="text-muted mb-0">No hay materiales registrados</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($materiales->hasPages())
            <div class="card-footer">
                <div class="d-flex justify-content-center">
                    {{ $materiales->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.badge {
    padding: 0.5em 0.8em;
    font-weight: 500;
}
.bg-warning-subtle {
    background-color: rgba(255, 193, 7, 0.1);
}
.table td {
    vertical-align: middle;
}
.btn-group .btn {
    margin-right: 0.25rem;
}
.btn-group .btn:last-child {
    margin-right: 0;
}
</style>
@endsection
