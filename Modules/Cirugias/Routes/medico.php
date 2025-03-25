<?php

use Illuminate\Support\Facades\Route;
use Modules\Cirugias\Http\Controllers\API\MedicoController;

Route::prefix('medicos')->name('medicos.')->group(function () {
    Route::get('/', [MedicoController::class, 'index'])->name('index')->middleware('check.permissions');
    Route::get('/create', [MedicoController::class, 'create'])->name('create')->middleware('check.permissions');
    Route::post('/', [MedicoController::class, 'store'])->name('store')->middleware('check.permissions');
    Route::get('/{medico}', [MedicoController::class, 'show'])->name('show')->middleware('check.permissions');
    Route::get('/{medico}/edit', [MedicoController::class, 'edit'])->name('edit')->middleware('check.permissions');
    Route::put('/{medico}', [MedicoController::class, 'update'])->name('update')->middleware('check.permissions');
    Route::delete('/{medico}', [MedicoController::class, 'destroy'])->name('destroy')->middleware('check.permissions');
});
