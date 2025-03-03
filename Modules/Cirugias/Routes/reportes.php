<?php

use Illuminate\Support\Facades\Route;
use Modules\Cirugias\Http\Controllers\ReporteCirugiaController;

Route::prefix('cirugias/reportes')->group(function () {
    Route::get('/', [ReporteCirugiaController::class, 'index'])->name('cirugias.reportes.index');
    Route::get('/create', [ReporteCirugiaController::class, 'create'])->name('cirugias.reportes.create');
    Route::post('/', [ReporteCirugiaController::class, 'store'])->name('cirugias.reportes.store');
    Route::get('/{id}/edit', [ReporteCirugiaController::class, 'edit'])->name('cirugias.reportes.edit');
    Route::delete('/{id}', [ReporteCirugiaController::class, 'destroy'])->name('cirugias.reportes.destroy');
});
