@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <h1>{{ $title }}</h1>
    @include('partials.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Bienvenido al Panel de Administración</h3>
            </div>
            <div class="card-body">
                <p>Desde aquí podrás gestionar todas las configuraciones del sistema.</p>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Dashboard cargado!'); </script>
@stop
