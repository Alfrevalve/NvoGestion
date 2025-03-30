@extends('layouts.sidebar-pro')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Listado de Cirugías</h1>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Cirugías
        </div>
        <div class="card-body">
            <!-- Aquí puedes agregar la lógica para mostrar la lista de cirugías -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Ejemplo de fila -->
                    <tr>
                        <td>1</td>
                        <td>Cirugía de Ejemplo</td>
                        <td>
                            <a href="{{ route('cirugias.edit', 1) }}" class="btn btn-primary">Editar</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
