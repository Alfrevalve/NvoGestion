<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Cirugias\Http\Controllers\API\CirugiaController;
use Modules\Cirugias\Http\Controllers\API\CalendarioController;
use Modules\Cirugias\Http\Controllers\API\KanbanController;
use Modules\Cirugias\Http\Controllers\API\InstitucionController;
use Modules\Cirugias\Http\Controllers\API\MedicoController;
use Modules\Cirugias\Http\Controllers\API\InstrumentistaController;

Route::middleware('auth:sanctum')->group(function () {
    // Usuario autenticado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // API endpoints para Cirugías
    Route::apiResource('cirugias', CirugiaController::class);
    Route::put('cirugias/{id}', [CirugiaController::class, 'update'])->name('cirugias.update');
    Route::get('cirugias/filtered', [CirugiaController::class, 'filtered']);

    // Temporary test route
    Route::get('cirugias/test', function() {
        return response()->json(['status' => 'La ruta funciona']);
    });

    Route::get('calendario/eventos', [CalendarioController::class, 'eventos']);
    Route::get('kanban/estados', [KanbanController::class, 'estados']);
    Route::get('instituciones', [InstitucionController::class, 'index']);
    Route::get('medicos', [MedicoController::class, 'index']);
    Route::get('instrumentistas', [InstrumentistaController::class, 'index']);
});
