<?php

use Illuminate\Support\Facades\Route;
use Modules\Cirugias\Http\Controllers\KanbanController;

// Ruta para la vista Kanban
Route::get('/cirugias/kanban', [KanbanController::class, 'index'])->name('cirugias.kanban');
