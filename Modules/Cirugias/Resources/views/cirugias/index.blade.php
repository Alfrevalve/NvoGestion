@extends('cirugias::layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Listado de Cirugías</h1>
        <a href="{{ route('cirugias.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Nueva Cirugía
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hora</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($cirugias as $cirugia)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $cirugia->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $cirugia->fecha }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $cirugia->hora }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        @if($cirugia->estado == 'Programada') bg-yellow-100 text-yellow-800 
                        @elseif($cirugia->estado == 'En Proceso') bg-blue-100 text-blue-800 
                        @elseif($cirugia->estado == 'Completada') bg-green-100 text-green-800 
                        @elseif($cirugia->estado == 'Cancelada') bg-red-100 text-red-800 
                        @endif">
                            {{ $cirugia->estado }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('cirugias.show', $cirugia->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Ver</a>
                        <a href="{{ route('cirugias.edit', $cirugia->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Editar</a>
                        <form action="{{ route('cirugias.destroy', $cirugia->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de eliminar esta cirugía?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay cirugías registradas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $cirugias->links() }}
    </div>
</div>
@endsection