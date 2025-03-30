@extends('layouts.sb-admin-pro')

@section('title', 'Instituciones - GesVitalPro')

@section('header-icon')
    <i class="fas fa-hospital"></i>
@endsection

@section('header-title', 'Instituciones')

@section('header-subtitle', 'Gestión de instituciones médicas')

@section('header-actions')
    <a class="btn btn-white text-primary" href="{{ route('modulo.instituciones.create') }}">
        <i class="fas fa-plus mr-2"></i>
        Nueva Institución
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>Listado de Instituciones</div>
                <div>
                    <a href="{{ route('modulo.instituciones.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i> Nueva Institución
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($instituciones as $institucion)
                            <tr>
                                <td>{{ $institucion->nombre }}</td>
                                <td>
                                    <a href="{{ route('modulo.instituciones.edit', $institucion->id) }}" class="btn btn-sm btn-icon btn-transparent-dark me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('modulo.instituciones.destroy', $institucion->id) }}" method="POST" style="display:inline;">
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
            <div class="card-footer">
                {{ $instituciones->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
