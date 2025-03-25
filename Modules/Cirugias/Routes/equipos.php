<?php

use Illuminate\Support\Facades\Route;
use Modules\Cirugias\Http\Controllers\API\EquipoController;

Route::prefix('equipos')->name('equipos.')->group(function () {
    Route::get('/', [EquipoController::class, 'index'])->name('index')->middleware('check.permissions');
    Route::get('/create', [EquipoController::class, 'create'])->name('create')->middleware('check.permissions');
    Route::post('/', [EquipoController::class, 'store'])->name('store')->middleware('check.permissions');
    Route::get('/{equipo}', [EquipoController::class, 'show'])->name('show')->middleware('check.permissions');
    Route::get('/{equipo}/edit', [EquipoController::class, 'edit'])->name('edit')->middleware('check.permissions');
    Route::put('/{equipo}', [EquipoController::class, 'update'])->name('update')->middleware('check.permissions');
    Route::delete('/{equipo}', [EquipoController::class, 'destroy'])->name('destroy')->middleware('check.permissions');
});
