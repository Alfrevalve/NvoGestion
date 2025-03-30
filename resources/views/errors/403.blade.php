@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Error 403</div>
                <div class="card-body">
                    <p>No tiene permisos para acceder a esta página.</p>
                    <a href="{{ url('/') }}" class="btn btn-primary">Volver al Inicio</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection