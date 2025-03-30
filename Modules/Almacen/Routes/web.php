<?php

use Illuminate\Support\Facades\Route;
use Modules\Almacen\Http\Controllers\AlmacenController;

// Almacen Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/almacen', [AlmacenController::class, 'index'])->name('modulo.almacen.index');
    Route::get('/almacen/create', [AlmacenController::class, 'create'])->name('modulo.almacen.create');
    Route::post('/almacen', [AlmacenController::class, 'store'])->name('modulo.almacen.store');
    Route::get('/almacen/{id}/edit', [AlmacenController::class, 'edit'])->name('modulo.almacen.edit');
    Route::put('/almacen/{id}', [AlmacenController::class, 'update'])->name('modulo.almacen.update');
});
