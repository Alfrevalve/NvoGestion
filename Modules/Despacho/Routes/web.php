<?php

use Illuminate\Support\Facades\Route;
use Modules\Despacho\Http\Controllers\DespachoController;
use Modules\Despacho\Http\Controllers\EntregaController;
use Modules\Despacho\Http\Controllers\RutaController;
use Modules\Despacho\Http\Controllers\VehiculoController;
use Modules\Despacho\Http\Controllers\ConductorController;
use Modules\Despacho\Http\Controllers\ZonaController;

Route::prefix('modulo-despacho')->middleware(['auth'])->name('modulo.despacho.')->group(function () {
    // Despachos
    Route::get('/', [DespachoController::class, 'index'])->name('index');
    Route::get('/create', [DespachoController::class, 'create'])->name('create');
    Route::post('/', [DespachoController::class, 'store'])->name('store');
    Route::get('/{despacho}', [DespachoController::class, 'show'])->name('show');
    Route::get('/{despacho}/edit', [DespachoController::class, 'edit'])->name('edit');
    Route::put('/{despacho}', [DespachoController::class, 'update'])->name('update');
    Route::delete('/{despacho}', [DespachoController::class, 'destroy'])->name('destroy');

    // Entregas
    Route::prefix('entregas')->name('entregas.')->group(function () {
        Route::get('/', [EntregaController::class, 'index'])->name('index');
        Route::get('/create', [EntregaController::class, 'create'])->name('create');
        Route::post('/', [EntregaController::class, 'store'])->name('store');
        Route::get('/{entrega}', [EntregaController::class, 'show'])->name('show');
        Route::get('/{entrega}/edit', [EntregaController::class, 'edit'])->name('edit');
        Route::put('/{entrega}', [EntregaController::class, 'update'])->name('update');
        Route::delete('/{entrega}', [EntregaController::class, 'destroy'])->name('destroy');
        Route::post('/{entrega}/confirmar', [EntregaController::class, 'confirmar'])->name('confirmar');
    });

    // Rutas
    Route::prefix('rutas')->name('rutas.')->group(function () {
        Route::get('/', [RutaController::class, 'index'])->name('index');
        Route::get('/create', [RutaController::class, 'create'])->name('create');
        Route::post('/', [RutaController::class, 'store'])->name('store');
        Route::get('/{ruta}', [RutaController::class, 'show'])->name('show');
        Route::get('/{ruta}/edit', [RutaController::class, 'edit'])->name('edit');
        Route::put('/{ruta}', [RutaController::class, 'update'])->name('update');
        Route::delete('/{ruta}', [RutaController::class, 'destroy'])->name('destroy');
        Route::get('/{ruta}/tracking', [RutaController::class, 'tracking'])->name('tracking');
    });

    // Vehículos
    Route::prefix('vehiculos')->name('vehiculos.')->group(function () {
        Route::get('/', [VehiculoController::class, 'index'])->name('index');
        Route::get('/create', [VehiculoController::class, 'create'])->name('create');
        Route::post('/', [VehiculoController::class, 'store'])->name('store');
        Route::get('/{vehiculo}', [VehiculoController::class, 'show'])->name('show');
        Route::get('/{vehiculo}/edit', [VehiculoController::class, 'edit'])->name('edit');
        Route::put('/{vehiculo}', [VehiculoController::class, 'update'])->name('update');
        Route::delete('/{vehiculo}', [VehiculoController::class, 'destroy'])->name('destroy');
        Route::post('/{vehiculo}/mantenimiento', [VehiculoController::class, 'mantenimiento'])->name('mantenimiento');
    });

    // Conductores
    Route::prefix('conductores')->name('conductores.')->group(function () {
        Route::get('/', [ConductorController::class, 'index'])->name('index');
        Route::get('/create', [ConductorController::class, 'create'])->name('create');
        Route::post('/', [ConductorController::class, 'store'])->name('store');
        Route::get('/{conductor}', [ConductorController::class, 'show'])->name('show');
        Route::get('/{conductor}/edit', [ConductorController::class, 'edit'])->name('edit');
        Route::put('/{conductor}', [ConductorController::class, 'update'])->name('update');
        Route::delete('/{conductor}', [ConductorController::class, 'destroy'])->name('destroy');
    });

    // Zonas
    Route::prefix('zonas')->name('zonas.')->group(function () {
        Route::get('/', [ZonaController::class, 'index'])->name('index');
        Route::get('/create', [ZonaController::class, 'create'])->name('create');
        Route::post('/', [ZonaController::class, 'store'])->name('store');
        Route::get('/{zona}', [ZonaController::class, 'show'])->name('show');
        Route::get('/{zona}/edit', [ZonaController::class, 'edit'])->name('edit');
        Route::put('/{zona}', [ZonaController::class, 'update'])->name('update');
        Route::delete('/{zona}', [ZonaController::class, 'destroy'])->name('destroy');
    });

    // Reportes
    Route::prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/despachos', [DespachoController::class, 'reporteDespachos'])->name('despachos');
        Route::get('/entregas', [EntregaController::class, 'reporteEntregas'])->name('entregas');
        Route::get('/rutas', [RutaController::class, 'reporteRutas'])->name('rutas');
        Route::get('/vehiculos', [VehiculoController::class, 'reporteVehiculos'])->name('vehiculos');
    });
});
