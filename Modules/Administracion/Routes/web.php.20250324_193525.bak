<?php

use Illuminate\Support\Facades\Route;
use Modules\Administracion\Http\Controllers\AdministracionController;

// Administracion Routes
Route::get('/administracion', [AdministracionController::class, 'index'])->name('modulo.administracion.index');
Route::get('/administracion/create', [AdministracionController::class, 'create'])->name('modulo.administracion.create');
Route::post('/administracion', [AdministracionController::class, 'store'])->name('modulo.administracion.store');
Route::get('/administracion/{id}/edit', [AdministracionController::class, 'edit'])->name('modulo.administracion.edit');
Route::put('/administracion/{id}', [AdministracionController::class, 'update'])->name('modulo.administracion.update');
