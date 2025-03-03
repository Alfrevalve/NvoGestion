@extends('layouts.app')

@section('content')
<div class="container">
@if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
            </div>
        </div>
        <div class="col">
            <h2>Programadas</h2>
            <div id="programadas" class="kanban-column">
                @foreach($cirugias['programada'] as $cirugia)
                    <div class="kanban-item">
                        <p>{{ $cirugia->fecha }} - {{ $cirugia->hora }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col">
            <h2>En Proceso</h2>
            <div id="en-proceso" class="kanban-column">
                @foreach($cirugias['en proceso'] as $cirugia)
                    <div class="kanban-item">
                        <p>{{ $cirugia->fecha }} - {{ $cirugia->hora }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col">
            <h2>Finalizadas</h2>
            <div id="finalizadas" class="kanban-column">
                @foreach($cirugias['finalizada'] as $cirugia)
                    <div class="kanban-item">
                        <p>{{ $cirugia->fecha }} - {{ $cirugia->hora }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
