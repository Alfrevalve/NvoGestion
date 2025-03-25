@extends('layouts.app')

@section('title', 'Gestión de Despachos')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .status-badge {
        @apply px-3 py-1 text-xs font-medium rounded-full;
    }
    .status-pendiente {
        @apply bg-yellow-100 text-yellow-800;
    }
    .status-en_proceso {
        @apply bg-blue-100 text-blue-800;
    }
    .status-despachado {
        @apply bg-indigo-100 text-indigo-800;
    }
    .status-entregado {
        @apply bg-green-100 text-green-800;
    }
    .status-cancelado {
        @apply bg-red-100 text-red-800;
    }
    .skeleton {
        @apply animate-pulse bg-gray-200 rounded;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Gestión de Despachos</h1>
            <p class="text-gray-600 mt-1">
                Administra todos los despachos del sistema
                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded ml-2 text-sm">
                    Total: {{ $despachos->total() ?? 0 }}
                </span>
            </p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('despacho.export') }}" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Exportar
            </a>
            <a href="{{ route('despacho.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nuevo Despacho
            </a>
        </div>
    </div>

    @if(session('success'))
    <div id="alert-success" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow" role="alert">
        <div class="flex items-center">
            <svg class="h-6 w-6 mr-2 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="document.getElementById('alert-success').style.display='none'" class="absolute top-0 right-0 mt-4 mr-4 text-green-500 hover:text-green-700">
            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div id="alert-error" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow" role="alert">
        <div class="flex items-center">
            <svg class="h-6 w-6 mr-2 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        <button type="button" onclick="document.getElementById('alert-error').style.display='none'" class="absolute top-0 right-0 mt-4 mr-4 text-red-500 hover:text-red-700">
            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    <!-- Filtros -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <form action="{{ route('despacho.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="space-y-2">
                <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                <select id="estado" name="estado" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Todos los estados</option>
                    @foreach($estados as $key => $label)
                        <option value="{{ $key }}" {{ request('estado') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-2">
                <label for="fecha_desde" class="block text-sm font-medium text-gray-700">Fecha desde</label>
                <input type="date" id="fecha_desde" name="fecha_desde" value="{{ request('fecha_desde') }}"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm date-picker">
            </div>

            <div class="space-y-2">
                <label for="fecha_hasta" class="block text-sm font-medium text-gray-700">Fecha hasta</label>
                <input type="date" id="fecha_hasta" name="fecha_hasta" value="{{ request('fecha_hasta') }}"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm date-picker">
            </div>

            <div class="space-y-2">
                <label for="buscar" class="block text-sm font-medium text-gray-700">Buscar</label>
                <div class="relative">
                    <input type="text" id="buscar" name="buscar" value="{{ request('buscar') }}" placeholder="ID, destinatario o dirección"
                        class="mt-1 block w-full py-2 px-3 pl-10 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="flex items-end md:col-span-4 gap-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Filtrar
                </button>
                <a href="{{ route('despacho.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" aria-label="Tabla de despachos">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('despacho.index', array_merge(request()->except('sort', 'direction'), ['sort' => 'id', 'direction' => request('sort') === 'id' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center group">
                                ID
                                @if(request('sort') === 'id')
                                    <svg class="ml-1 h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M{{ request('direction') === 'asc' ? '5 15l7-7 7 7' : '19 9l-7 7-7-7' }}" />
                                    </svg>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('despacho.index', array_merge(request()->except('sort', 'direction'), ['sort' => 'fecha_despacho', 'direction' => request('sort') === 'fecha_despacho' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center group">
                                Fecha
                                @if(request('sort') === 'fecha_despacho')
                                    <svg class="ml-1 h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M{{ request('direction') === 'asc' ? '5 15l7-7 7 7' : '19 9l-7 7-7-7' }}" />
                                    </svg>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pedido</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destinatario</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dirección</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('despacho.index', array_merge(request()->except('sort', 'direction'), ['sort' => 'estado', 'direction' => request('sort') === 'estado' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center group">
                                Estado
                                @if(request('sort') === 'estado')
                                    <svg class="ml-1 h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M{{ request('direction') === 'asc' ? '5 15l7-7 7 7' : '19 9l-7 7-7-7' }}" />
                                    </svg>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" x-data="{ loading: false }">
                    @forelse($despachos as $despacho)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $despacho->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <time datetime="{{ $despacho->fecha_despacho->format('Y-m-d') }}">
                                {{ $despacho->fecha_despacho->format('d/m/Y') }}
                            </time>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($despacho->pedido)
                                <a href="{{ route('pedido.show', $despacho->pedido) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                    #{{ $despacho->pedido->id }}
                                </a>
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $despacho->destinatario }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-md truncate">
                            {{ $despacho->direccion }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="status-badge status-{{ $despacho->estado }}">
                                {{ $estados[$despacho->estado] ?? $despacho->estado }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('despacho.show', $despacho) }}" class="text-indigo-600 hover:text-indigo-900" title="Ver detalles">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ route('despacho.edit', $despacho) }}" class="text-blue-600 hover:text-blue-900" title="Editar">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                @if(!in_array($despacho->estado, ['despachado', 'entregado']))
                                <button type="button" onclick="confirmarEliminacion('{{ $despacho->id }}', '{{ $despacho->destinatario }}')" class="text-red-600 hover:text-red-900" title="Eliminar">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                @endif

                                <a href="{{ route('despacho.guia', $despacho) }}" class="text-green-600 hover:text-green-900" title="Generar guía">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="h-12 w-12 text-gray-400 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="text-xl font-medium">No hay despachos registrados</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ request()->has('buscar') || request()->has('estado') || request()->has('fecha_desde') ? 'No se encontraron despachos con los filtros aplicados.' : 'Crea tu primer despacho para comenzar.' }}
                                </p>
                                @if(request()->has('buscar') || request()->has('estado') || request()->has('fecha_desde'))
                                <a href="{{ route('despacho.index') }}" class="mt-4 text-blue-500 hover:text-blue-700 font-medium">
                                    Limpiar filtros
                                </a>
                                @else
                                <a href="{{ route('despacho.create') }}" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded">
                                    Crear nuevo despacho
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-200">
            {{ $despachos->links() }}
        </div>
    </div>
</div>

<!-- Modal de confirmación de eliminación -->
<div id="modal-eliminar" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden" aria-modal="true" role="dialog">
    <div class="bg-white rounded-lg max-w-md w-full mx-4 overflow-hidden shadow-xl">
        <div class="px-6 py-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Confirmar eliminación</h3>
                <button type="button" onclick="ocultarModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <p class="text-gray-600 mb-2">¿Estás seguro de que deseas eliminar este despacho?</p>
            <p id="modal-detalle" class="text-gray-800 font-medium"></p>
        </div>
        <div class="px-6 py-4 bg-gray-50 text-right space-x-2">
            <button type="button" onclick="ocultarModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Cancelar
            </button>
            <form id="form-eliminar" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Eliminar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar el selector de fechas
        flatpickr('.date-picker', {
            locale: 'es',
            altInput: true,
            altFormat: 'd/m/Y',
            dateFormat: 'Y-m-d',
            allowInput: true,
        });

        // Auto-cerrar las alertas después de 5 segundos
        setTimeout(function() {
            const alerts = document.querySelectorAll('#alert-success, #alert-error');
            alerts.forEach(alert => {
                if (alert) {
                    alert.style.display = 'none';
                }
            });
        }, 5000);
    });

    // Funciones para el modal de confirmación
    function confirmarEliminacion(id, destinatario) {
        document.getElementById('form-eliminar').action = `/despacho/${id}`;
        document.getElementById('modal-detalle').textContent = `Despacho #${id} para ${destinatario}`;
        document.getElementById('modal-eliminar').classList.remove('hidden');
    }

    function ocultarModal() {
        document.getElementById('modal-eliminar').classList.add('hidden');
    }

    // Cerrar el modal al hacer clic fuera de él
    document.getElementById('modal-eliminar').addEventListener('click', function(event) {
        if (event.target === this) {
            ocultarModal();
        }
    });

    // Cerrar el modal con la tecla Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && !document.getElementById('modal-eliminar').classList.contains('hidden')) {
            ocultarModal();
        }
    });
</script>
@endsection
