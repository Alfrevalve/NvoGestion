<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Despacho\Http\Controllers\API\DespachoController;
use Modules\Despacho\Http\Controllers\API\EntregaController;
use Modules\Despacho\Http\Controllers\API\RutaController;
use Modules\Despacho\Http\Controllers\API\VehiculoController;
use Modules\Despacho\Http\Controllers\API\ConductorController;
use Modules\Despacho\Http\Controllers\API\ZonaController;

Route::middleware('auth:sanctum')->group(function () {
    // Usuario autenticado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Despachos
    Route::apiResource('despachos', DespachoController::class);
    Route::get('despachos/search', [DespachoController::class, 'search']);
    Route::get('despachos/pendientes', [DespachoController::class, 'pendientes']);
    Route::post('despachos/{despacho}/asignar', [DespachoController::class, 'asignar']);

    // Entregas
    Route::apiResource('entregas', EntregaController::class);
    Route::get('entregas/search', [EntregaController::class, 'search']);
    Route::post('entregas/{entrega}/confirmar', [EntregaController::class, 'confirmar']);
    Route::post('entregas/{entrega}/rechazar', [EntregaController::class, 'rechazar']);

    // Rutas
    Route::apiResource('rutas', RutaController::class);
    Route::get('rutas/search', [RutaController::class, 'search']);
    Route::get('rutas/optimizar', [RutaController::class, 'optimizar']);
    Route::get('rutas/{ruta}/tracking', [RutaController::class, 'tracking']);

    // Vehículos
    Route::apiResource('vehiculos', VehiculoController::class);
    Route::get('vehiculos/disponibles', [VehiculoController::class, 'disponibles']);
    Route::get('vehiculos/{vehiculo}/ubicacion', [VehiculoController::class, 'ubicacion']);
    Route::post('vehiculos/{vehiculo}/mantenimiento', [VehiculoController::class, 'mantenimiento']);

    // Conductores
    Route::apiResource('conductores', ConductorController::class);
    Route::get('conductores/disponibles', [ConductorController::class, 'disponibles']);
    Route::get('conductores/{conductor}/historial', [ConductorController::class, 'historial']);
    Route::post('conductores/{conductor}/asignar', [ConductorController::class, 'asignar']);

    // Zonas
    Route::apiResource('zonas', ZonaController::class);
    Route::get('zonas/search', [ZonaController::class, 'search']);
    Route::get('zonas/{zona}/cobertura', [ZonaController::class, 'cobertura']);

    // Estadísticas
    Route::prefix('stats')->group(function () {
        Route::get('despachos', [DespachoController::class, 'stats']);
        Route::get('entregas', [EntregaController::class, 'stats']);
        Route::get('rutas', [RutaController::class, 'stats']);
        Route::get('vehiculos', [VehiculoController::class, 'stats']);
        Route::get('conductores', [ConductorController::class, 'stats']);
    });

    // Reportes
    Route::prefix('reportes')->group(function () {
        Route::get('despachos', [DespachoController::class, 'reporte']);
        Route::get('entregas', [EntregaController::class, 'reporte']);
        Route::get('rutas', [RutaController::class, 'reporte']);
        Route::get('eficiencia', [DespachoController::class, 'reporteEficiencia']);
    });
});
