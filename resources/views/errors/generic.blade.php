@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $title ?? 'Error' }}</div>
                <div class="card-body">
                    <p>{{ $message ?? 'Ha ocurrido un error. Por favor, inténtelo de nuevo más tarde.' }}</p>
                    <a href="{{ url('/') }}" class="btn btn-primary">Volver al Inicio</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection