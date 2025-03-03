<?php

use Illuminate\Support\Facades\Route;
// Cambiar las importaciones para usar el namespace correcto (API)
use Modules\Cirugias\Http\Controllers\API\CirugiaController;
use Modules\Cirugias\Http\Controllers\API\CalendarioController;
use Modules\Cirugias\Http\Controllers\API\KanbanController;
use Modules\Cirugias\Http\Controllers\API\ReporteCirugiaController;
use Modules\Cirugias\Http\Controllers\API\InstitucionController;
use Modules\Cirugias\Http\Controllers\API\MedicoController;
use Modules\Cirugias\Http\Controllers\API\InstrumentistaController;
use Modules\Cirugias\Http\Controllers\API\EquipoController;
use Modules\Cirugias\Http\Controllers\API\MaterialController;

Route::prefix('modulo-cirugias')->middleware(['auth'])->name('modulo.cirugias.')->group(function () {
    // Cirugías
    Route::get('/', [CirugiaController::class, 'index'])->name('index');
    Route::get('/create', [CirugiaController::class, 'create'])->name('create');
    Route::post('/', [CirugiaController::class, 'store'])->name('store');
    Route::get('/{cirugia}', [CirugiaController::class, 'show'])->name('show');
    Route::get('/{cirugia}/edit', [CirugiaController::class, 'edit'])->name('edit');
    Route::put('/{cirugia}', [CirugiaController::class, 'update'])->name('update');
    Route::delete('/{cirugia}', [CirugiaController::class, 'destroy'])->name('destroy');

    // Calendario
    Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario');
    Route::post('/calendario/eventos', [CalendarioController::class, 'eventos'])->name('calendario.eventos');

    // Kanban
    Route::get('/kanban', [KanbanController::class, 'index'])->name('kanban');
    Route::post('/kanban/update/{cirugia}', [KanbanController::class, 'updateEstado'])->name('kanban.update');

    // Reportes
    Route::prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/', [ReporteCirugiaController::class, 'index'])->name('index');
        Route::get('/ver/{id}', [ReporteCirugiaController::class, 'show'])->name('show');
        Route::post('/generar', [ReporteCirugiaController::class, 'generate'])->name('generate');
    });

    // Instituciones
    Route::prefix('instituciones')->name('instituciones.')->group(function () {
        Route::get('/', [InstitucionController::class, 'index'])->name('index');
        Route::get('/create', [InstitucionController::class, 'create'])->name('create');
        Route::post('/', [InstitucionController::class, 'store'])->name('store');
        Route::get('/{institucion}', [InstitucionController::class, 'show'])->name('show');
        Route::get('/{institucion}/edit', [InstitucionController::class, 'edit'])->name('edit');
        Route::put('/{institucion}', [InstitucionController::class, 'update'])->name('update');
        Route::delete('/{institucion}', [InstitucionController::class, 'destroy'])->name('destroy');
    });

    // Médicos
    Route::prefix('medicos')->name('medicos.')->group(function () {
        Route::get ('/', [MedicoController::class, 'index'])->name('index');
        Route::get('/create', [MedicoController::class, 'create'])->name('create');
        Route::post('/', [MedicoController::class, 'store'])->name('store');
        Route::get('/{medico}', [MedicoController::class, 'show'])->name('show');
        Route::get('/{medico}/edit', [MedicoController::class, 'edit'])->name('edit');
        Route::put('/{medico}', [MedicoController::class, 'update'])->name('update');
        Route::delete('/{medico}', [MedicoController::class, 'destroy'])->name('destroy');
    });

    // Instrumentistas
    Route::prefix('instrumentistas')->name('instrumentistas.')->group(function () {
        Route::get('/', [InstrumentistaController::class, 'index'])->name('index');
        Route::get('/create', [InstrumentistaController::class, 'create'])->name('create');
        Route::post('/', [InstrumentistaController::class, 'store'])->name('store');
        Route::get('/{instrumentista}', [InstrumentistaController::class, 'show'])->name('show');
        Route::get('/{instrumentista}/edit', [InstrumentistaController::class, 'edit'])->name('edit');
        Route::put('/{instrumentista}', [InstrumentistaController::class, 'update'])->name('update');
        Route::delete('/{instrumentista}', [InstrumentistaController::class, 'destroy'])->name('destroy');
    });

    // Equipos
    Route::prefix('equipos')->name('equipos.')->group(function () {
        Route::get('/', [EquipoController::class, 'index'])->name('index');
        Route::get('/create', [EquipoController::class, 'create'])->name('create');
        Route::post('/', [EquipoController::class, 'store'])->name('store');
        Route::get('/{equipo}', [EquipoController::class, 'show'])->name('show');
        Route::get('/{equipo}/edit', [EquipoController::class, 'edit'])->name('edit');
        Route::put('/{equipo}', [EquipoController::class, 'update'])->name('update');
        Route::delete('/{equipo}', [EquipoController::class, 'destroy'])->name('destroy');
    });

    // Materiales
    Route::prefix('materiales')->name('materiales.')->group(function () {
        Route::get('/', [MaterialController::class, 'index'])->name('index');
        Route::get('/create', [MaterialController::class, 'create'])->name('create');
        Route::post('/', [MaterialController::class, 'store'])->name('store');
        Route::get('/{material}', [MaterialController::class, 'show'])->name('show');
        Route::get('/{material}/edit', [MaterialController::class, 'edit'])->name('edit');
        Route::put('/{material}', [MaterialController::class, 'update'])->name('update');
        Route::delete('/{material}', [MaterialController::class, 'destroy'])->name('destroy');
    });
});
