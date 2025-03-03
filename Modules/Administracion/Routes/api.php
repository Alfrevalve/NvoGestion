<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Administracion\Http\Controllers\API\UserController;
use Modules\Administracion\Http\Controllers\API\RoleController;
use Modules\Administracion\Http\Controllers\API\PermissionController;
use Modules\Administracion\Http\Controllers\API\ConfiguracionController;
use Modules\Administracion\Http\Controllers\API\LogController;
use Modules\Administracion\Http\Controllers\API\BackupController;
use Modules\Administracion\Http\Controllers\API\DashboardController;

Route::middleware('auth:sanctum')->group(function () {
    // Usuario autenticado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Dashboard
    Route::prefix('dashboard')->group(function () {
        Route::get('stats', [DashboardController::class, 'stats']);
        Route::get('chart-data', [DashboardController::class, 'chartData']);
        Route::get('recent-activity', [DashboardController::class, 'recentActivity']);
        Route::get('system-health', [DashboardController::class, 'systemHealth']);
    });

    // Usuarios
    Route::apiResource('users', UserController::class);
    Route::get('users/search', [UserController::class, 'search']);
    Route::post('users/{user}/activate', [UserController::class, 'activate']);
    Route::post('users/{user}/deactivate', [UserController::class, 'deactivate']);
    Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword']);
    Route::get('users/{user}/activity', [UserController::class, 'activity']);
    Route::get('users/{user}/permissions', [UserController::class, 'permissions']);

    // Roles
    Route::apiResource('roles', RoleController::class);
    Route::get('roles/search', [RoleController::class, 'search']);
    Route::post('roles/{role}/sync-permissions', [RoleController::class, 'syncPermissions']);
    Route::get('roles/{role}/users', [RoleController::class, 'users']);

    // Permisos
    Route::apiResource('permissions', PermissionController::class);
    Route::get('permissions/search', [PermissionController::class, 'search']);
    Route::get('permissions/by-module', [PermissionController::class, 'byModule']);

    // Configuración
    Route::prefix('configuraciones')->group(function () {
        Route::get('/', [ConfiguracionController::class, 'index']);
        Route::post('/', [ConfiguracionController::class, 'update']);
        Route::get('sistema', [ConfiguracionController::class, 'sistema']);
        Route::get('email', [ConfiguracionController::class, 'email']);
        Route::post('email/test', [ConfiguracionController::class, 'testEmail']);
        Route::get('notificaciones', [ConfiguracionController::class, 'notificaciones']);
        Route::get('apariencia', [ConfiguracionController::class, 'apariencia']);
    });

    // Logs
    Route::prefix('logs')->group(function () {
        Route::get('/', [LogController::class, 'index']);
        Route::get('activity', [LogController::class, 'activity']);
        Route::get('system', [LogController::class, 'system']);
        Route::get('errors', [LogController::class, 'errors']);
        Route::get('login', [LogController::class, 'login']);
        Route::delete('{date}', [LogController::class, 'destroy']);
    });

    // Respaldos
    Route::prefix('backups')->group(function () {
        Route::get('/', [BackupController::class, 'index']);
        Route::post('/', [BackupController::class, 'create']);
        Route::get('{backup}', [BackupController::class, 'show']);
        Route::post('{backup}/download', [BackupController::class, 'download']);
        Route::post('{backup}/restore', [BackupController::class, 'restore']);
        Route::delete('{backup}', [BackupController::class, 'destroy']);
    });

    // Estadísticas y Reportes
    Route::prefix('stats')->group(function () {
        Route::get('users', [UserController::class, 'stats']);
        Route::get('roles', [RoleController::class, 'stats']);
        Route::get('activity', [LogController::class, 'stats']);
        Route::get('system', [DashboardController::class, 'systemStats']);
    });
});
