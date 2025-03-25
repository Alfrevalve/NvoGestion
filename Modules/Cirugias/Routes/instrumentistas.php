<?php

use Illuminate\Support\Facades\Route;
use Modules\Cirugias\Http\Controllers\API\InstrumentistaController;

Route::prefix('instrumentistas')->name('instrumentistas.')->group(function () {
    Route::get('/', [InstrumentistaController::class, 'index'])->name('index')->middleware('check.permissions');
    Route::get('/create', [InstrumentistaController::class, 'create'])->name('create')->middleware('check.permissions');
    Route::post('/', [InstrumentistaController::class, 'store'])->name('store')->middleware('check.permissions');
    Route::get('/{instrumentista}', [InstrumentistaController::class, 'show'])->name('show')->middleware('check.permissions');
    Route::get('/{instrumentista}/edit', [InstrumentistaController::class, 'edit'])->name('edit')->middleware('check.permissions');
    Route::put('/{instrumentista}', [InstrumentistaController::class, 'update'])->name('update')->middleware('check.permissions');
    Route::delete('/{instrumentista}', [InstrumentistaController::class, 'destroy'])->name('destroy')->middleware('check.permissions');
});
