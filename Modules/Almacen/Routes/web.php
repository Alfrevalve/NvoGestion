<?php

use Illuminate\Support\Facades\Route;
use Modules\Almacen\Http\Controllers\InventarioController;
use Modules\Almacen\Http\Controllers\CategoriaController;
use Modules\Almacen\Http\Controllers\ProveedorController;
use Modules\Almacen\Http\Controllers\MovimientoInventarioController;

Route::prefix('modulo-almacen')->middleware(['auth'])->name('modulo.almacen.')->group(function () {
    // Inventario
    Route::get('/', [InventarioController::class, 'index'])->name('index');
    Route::get('/create', [InventarioController::class, 'create'])->name('create');
    Route::post('/', [InventarioController::class, 'store'])->name('store');
    Route::get('/{inventario}', [InventarioController::class, 'show'])->name('show');
    Route::get('/{inventario}/edit', [InventarioController::class, 'edit'])->name('edit');
    Route::put('/{inventario}', [InventarioController::class, 'update'])->name('update');
    Route::delete('/{inventario}', [InventarioController::class, 'destroy'])->name('destroy');

    // Categorías
    Route::prefix('categorias')->name('categorias.')->group(function () {
        Route::get('/', [CategoriaController::class, 'index'])->name('index');
        Route::get('/create', [CategoriaController::class, 'create'])->name('create');
        Route::post('/', [CategoriaController::class, 'store'])->name('store');
        Route::get('/{categoria}', [CategoriaController::class, 'show'])->name('show');
        Route::get('/{categoria}/edit', [CategoriaController::class, 'edit'])->name('edit');
        Route::put('/{categoria}', [CategoriaController::class, 'update'])->name('update');
        Route::delete('/{categoria}', [CategoriaController::class, 'destroy'])->name('destroy');
    });

    // Proveedores
    Route::prefix('proveedores')->name('proveedores.')->group(function () {
        Route::get('/', [ProveedorController::class, 'index'])->name('index');
        Route::get('/create', [ProveedorController::class, 'create'])->name('create');
        Route::post('/', [ProveedorController::class, 'store'])->name('store');
        Route::get('/{proveedor}', [ProveedorController::class, 'show'])->name('show');
        Route::get('/{proveedor}/edit', [ProveedorController::class, 'edit'])->name('edit');
        Route::put('/{proveedor}', [ProveedorController::class, 'update'])->name('update');
        Route::delete('/{proveedor}', [ProveedorController::class, 'destroy'])->name('destroy');
    });

    // Movimientos de Inventario
    Route::prefix('movimientos')->name('movimientos.')->group(function () {
        Route::get('/', [MovimientoInventarioController::class, 'index'])->name('index');
        Route::get('/create', [MovimientoInventarioController::class, 'create'])->name('create');
        Route::post('/', [MovimientoInventarioController::class, 'store'])->name('store');
        Route::get('/{movimiento}', [MovimientoInventarioController::class, 'show'])->name('show');
    });

    // Reportes
    Route::prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/stock', [InventarioController::class, 'reporteStock'])->name('stock');
        Route::get('/movimientos', [MovimientoInventarioController::class, 'reporteMovimientos'])->name('movimientos');
        Route::get('/valoracion', [InventarioController::class, 'reporteValoracion'])->name('valoracion');
    });
});
