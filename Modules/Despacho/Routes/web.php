<?php

use Illuminate\Support\Facades\Route;
use Modules\Despacho\Http\Controllers\DespachoController;

// Despacho Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/despacho', [DespachoController::class, 'index'])->name('modulo.despacho.index');
    Route::get('/despacho/create', [DespachoController::class, 'create'])->name('modulo.despacho.create');
    Route::post('/despacho', [DespachoController::class, 'store'])->name('modulo.despacho.store');
    Route::get('/despacho/{id}/edit', [DespachoController::class, 'edit'])->name('modulo.despacho.edit');
    Route::put('/despacho/{id}', [DespachoController::class, 'update'])->name('modulo.despacho.update');
});
