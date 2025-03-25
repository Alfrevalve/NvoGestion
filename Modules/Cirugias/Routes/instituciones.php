<?php

use Illuminate\Support\Facades\Route;
use Modules\Cirugias\Http\Controllers\API\InstitucionController;

Route::prefix('instituciones')->name('instituciones.')->group(function () {
    Route::get('/', [InstitucionController::class, 'index'])->name('index')->middleware('check.permissions');
    Route::get('/create', [InstitucionController::class, 'create'])->name('create')->middleware('check.permissions');
    Route::post('/', [InstitucionController::class, 'store'])->name('store')->middleware('check.permissions');
    Route::get('/{institucion}', [InstitucionController::class, 'show'])->name('show')->middleware('check.permissions');
    Route::get('/{institucion}/edit', [InstitucionController::class, 'edit'])->name('edit')->middleware('check.permissions');
    Route::put('/{institucion}', [InstitucionController::class, 'update'])->name('update')->middleware('check.permissions');
    Route::delete('/{institucion}', [InstitucionController::class, 'destroy'])->name('destroy')->middleware('check.permissions');
});
