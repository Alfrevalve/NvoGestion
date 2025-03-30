@extends('layouts.sb-admin-pro')

@section('title', 'Instrumentistas - GesVitalPro')

@section('header-icon')
    <i class="fas fa-user-md"></i>
@endsection

@section('header-title', 'Instrumentistas')

@section('header-subtitle', 'Gestión de personal instrumentista')

@section('header-actions')
    <a class="btn btn-white text-primary" href="{{ route('modulo.instrumentistas.create') }}">
        <i class="fas fa-plus mr-2"></i>
        Nuevo Instrumentista
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>Listado de Instrumentistas</div>
                <div>
                    <a href="{{ route('modulo.instrumentistas.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i> Nuevo Instrumentista
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
                @foreach($instrumentistas as $instrumentista)
                <tr>
                    <td>{{ $instrumentista->nombre }}</td>
                    <td>
                        <a href="{{ route('modulo.instrumentistas.edit', $instrumentista->id) }}" class="btn btn-sm btn-icon btn-transparent-dark me-1">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('modulo.instrumentistas.destroy', $instrumentista->id) }}" method="POST" style="display:inline;">
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
</div>
@endsection
