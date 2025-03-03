@extends('cirugias::layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Detalles de la Cirugía</h1>
        <div>
            <a href="{{ route('cirugias.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">
                Volver
            </a>
            <a href="{{ route('cirugias.edit', $cirugia->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                Editar
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-xl font-semibold mb-4">Información General</h2>
                <div class="mb-4">
                    <p class="text-sm text-gray-600">ID</p>
                    <p class="font-medium">{{ $cirugia->id }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-sm text-gray-600">Fecha</p>
                    <p class="font-medium">{{ $cirugia->fecha }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-sm text-gray-600">Hora</p>
                    <p class="font-medium">{{ $cirugia->hora }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-sm text-gray-600">Estado</p>
                    <p>
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                        @if($cirugia->estado == 'Programada') bg-yellow-100 text-yellow-800 
                        @elseif($cirugia->estado == 'En Proceso') bg-blue-100 text-blue-800 
                        @elseif($cirugia->estado == 'Completada') bg-green-100 text-green-800 
                        @elseif($cirugia->estado == 'Cancelada') bg-red-100 text-red-800 
                        @endif">
                            {{ $cirugia->estado }}
                        </span>
                    </p>
                </div>
            </div>
            
            <div>
                <h2 class="text-xl font-semibold mb-4">Observaciones</h2>
                <p class="text-gray-700">{{ $cirugia->observaciones ?? 'Sin observaciones' }}</p>
            </div>
        </div>
        
        <div class="mt-8 pt-6 border-t">
            <h2 class="text-xl font-semibold mb-4">Acciones</h2>
            <div class="flex space-x-4">
                <a href="{{ route('cirugias.edit', $cirugia->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                    Editar Cirugía
                </a>
                <form action="{{ route('cirugias.destroy', $cirugia->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded" onclick="return confirm('¿Estás seguro de eliminar esta cirugía?')">
                        Eliminar Cirugía
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection