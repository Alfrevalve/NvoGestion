@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Error 404</div>
                <div class="card-body">
                    <p>La página que está buscando no existe.</p>
                    <a href="{{ url('/') }}" class="btn btn-primary">Volver al Inicio</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection