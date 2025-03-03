<?php

use Illuminate\Support\Facades\Route;
use Modules\Administracion\Http\Controllers\DashboardController;
use Modules\Administracion\Http\Controllers\UserController;
use Modules\Administracion\Http\Controllers\RoleController;
use Modules\Administracion\Http\Controllers\PermissionController;
use Modules\Administracion\Http\Controllers\ConfiguracionController;
use Modules\Administracion\Http\Controllers\LogController;
use Modules\Administracion\Http\Controllers\BackupController;

Route::prefix('modulo-admin')->middleware(['auth'])->name('modulo.admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Usuarios
    Route::middleware(['permission:ver usuarios'])->prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/activate', [UserController::class, 'activate'])->name('activate');
        Route::post('/{user}/deactivate', [UserController::class, 'deactivate'])->name('deactivate');
        Route::post('/{user}/reset-password', [UserController::class, 'resetPassword'])->name('reset-password');
    });

    // Perfil de Usuario
    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::put('profile', [UserController::class, 'updateProfile'])->name('profile.update');

    // Roles y Permisos
    Route::middleware(['role:super-admin'])->group(function () {
        // Roles
        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/create', [RoleController::class, 'create'])->name('create');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::get('/{role}', [RoleController::class, 'show'])->name('show');
            Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
            Route::put('/{role}', [RoleController::class, 'update'])->name('update');
            Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
            Route::post('/{role}/sync-permissions', [RoleController::class, 'syncPermissions'])->name('sync-permissions');
        });

        // Permisos
        Route::prefix('permissions')->name('permissions.')->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('index');
            Route::get('/create', [PermissionController::class, 'create'])->name('create');
            Route::post('/', [PermissionController::class, 'store'])->name('store');
            Route::get('/{permission}', [PermissionController::class, 'show'])->name('show');
            Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->name('edit');
            Route::put('/{permission}', [PermissionController::class, 'update'])->name('update');
            Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('destroy');
        });
    });

    // Configuración
    Route::middleware(['permission:ver configuracion'])->prefix('configuraciones')->name('configuraciones.')->group(function () {
        Route::get('/', [ConfiguracionController::class, 'index'])->name('index');
        Route::post('/', [ConfiguracionController::class, 'update'])->name('update');
        Route::get('/sistema', [ConfiguracionController::class, 'sistema'])->name('sistema');
        Route::get('/email', [ConfiguracionController::class, 'email'])->name('email');
        Route::get('/notificaciones', [ConfiguracionController::class, 'notificaciones'])->name('notificaciones');
        Route::get('/apariencia', [ConfiguracionController::class, 'apariencia'])->name('apariencia');
        Route::post('/email/test', [ConfiguracionController::class, 'testEmail'])->name('email.test');
    });

    // Logs del Sistema
    Route::middleware(['permission:ver logs'])->prefix('logs')->name('logs.')->group(function () {
        Route::get('/', [LogController::class, 'index'])->name('index');
        Route::get('/activity', [LogController::class, 'activity'])->name('activity');
        Route::get('/system', [LogController::class, 'system'])->name('system');
        Route::get('/errors', [LogController::class, 'errors'])->name('errors');
        Route::get('/login', [LogController::class, 'login'])->name('login');
        Route::get('/{date}', [LogController::class, 'show'])->name('show');
        Route::get('/{date}/download', [LogController::class, 'download'])->name('download');
        Route::delete('/{date}', [LogController::class, 'destroy'])->name('destroy');
    });

    // Respaldos
    Route::middleware(['permission:gestionar respaldos'])->prefix('backups')->name('backups.')->group(function () {
        Route::get('/', [BackupController::class, 'index'])->name('index');
        Route::post('/', [BackupController::class, 'create'])->name('create');
        Route::get('/{backup}', [BackupController::class, 'show'])->name('show');
        Route::post('/{backup}/download', [BackupController::class, 'download'])->name('download');
        Route::post('/{backup}/restore', [BackupController::class, 'restore'])->name('restore');
        Route::delete('/{backup}', [BackupController::class, 'destroy'])->name('destroy');
    });
});
