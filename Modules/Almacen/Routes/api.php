<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Almacen\Http\Controllers\API\InventarioController;
use Modules\Almacen\Http\Controllers\API\CategoriaController;
use Modules\Almacen\Http\Controllers\API\ProveedorController;
use Modules\Almacen\Http\Controllers\API\MovimientoInventarioController;

Route::middleware('auth:sanctum')->group(function () {
    // Usuario autenticado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Inventario
    Route::apiResource('inventario', InventarioController::class);
    Route::get('inventario/search', [InventarioController::class, 'search']);
    Route::get('inventario/stock-bajo', [InventarioController::class, 'stockBajo']);
    Route::get('inventario/valoracion', [InventarioController::class, 'valoracion']);

    // Categorías
    Route::apiResource('categorias', CategoriaController::class);
    Route::get('categorias/search', [CategoriaController::class, 'search']);

    // Proveedores
    Route::apiResource('proveedores', ProveedorController::class);
    Route::get('proveedores/search', [ProveedorController::class, 'search']);

    // Movimientos
    Route::apiResource('movimientos', MovimientoInventarioController::class);
    Route::get('movimientos/por-fecha', [MovimientoInventarioController::class, 'porFecha']);
    Route::get('movimientos/reporte', [MovimientoInventarioController::class, 'reporte']);

    // Estadísticas
    Route::prefix('stats')->group(function () {
        Route::get('inventario', [InventarioController::class, 'stats']);
        Route::get('movimientos', [MovimientoInventarioController::class, 'stats']);
        Route::get('proveedores', [ProveedorController::class, 'stats']);
    });
});
