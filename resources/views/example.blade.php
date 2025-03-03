@extends('layouts.app')

@section('content')
    <x-card>
        <x-form action="#" method="POST">
            <x-input label="Nombre" name="name" />
            <x-input label="Email" name="email" type="email" />
            <div class="mt-6">
                <x-button>Enviar</x-button>
            </div>
        </x-form>
    </x-card>
@endsection
