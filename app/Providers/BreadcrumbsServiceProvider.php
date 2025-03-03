<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Facades\Breadcrumbs;

class BreadcrumbsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('breadcrumbs', function () {
            return new \App\Facades\Breadcrumbs;
        });
    }

    public function boot()
    {
        // Dashboard
        Breadcrumbs::for('dashboard', function ($trail) {
            $trail->push('Dashboard', route('dashboard'));
        });

        // Admin Dashboard
        Breadcrumbs::for('admin.dashboard', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('Admin', route('admin.dashboard'));
        });

        // Dashboard > Usuarios
        Breadcrumbs::for('admin.users.index', function ($trail) {
            $trail->parent('admin.dashboard');
            $trail->push('Usuarios', route('admin.users.index'));
        });

        // Dashboard > Usuarios > Crear
        Breadcrumbs::for('admin.users.create', function ($trail) {
            $trail->parent('admin.users.index');
            $trail->push('Crear Usuario', route('admin.users.create'));
        });

        // Dashboard > Usuarios > Editar
        Breadcrumbs::for('admin.users.edit', function ($trail, $user) {
            $trail->parent('admin.users.index');
            $trail->push("Editar: {$user->name}", route('admin.users.edit', $user));
        });

        // Dashboard > Roles
        Breadcrumbs::for('admin.roles.index', function ($trail) {
            $trail->parent('admin.dashboard');
            $trail->push('Roles', route('admin.roles.index'));
        });

        // Dashboard > Roles > Crear
        Breadcrumbs::for('admin.roles.create', function ($trail) {
            $trail->parent('admin.roles.index');
            $trail->push('Crear Rol', route('admin.roles.create'));
        });

        // Dashboard > Roles > Editar
        Breadcrumbs::for('admin.roles.edit', function ($trail, $role) {
            $trail->parent('admin.roles.index');
            $trail->push("Editar: {$role->name}", route('admin.roles.edit', $role));
        });

        // Dashboard > Cirugías
        Breadcrumbs::for('cirugias.index', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('Cirugías', route('cirugias.index'));
        });

        // Dashboard > Cirugías > Calendario
        Breadcrumbs::for('cirugias.calendario', function ($trail) {
            $trail->parent('cirugias.index');
            $trail->push('Calendario', route('cirugias.calendario'));
        });

        // Dashboard > Cirugías > Crear
        Breadcrumbs::for('cirugias.create', function ($trail) {
            $trail->parent('cirugias.index');
            $trail->push('Nueva Cirugía', route('cirugias.create'));
        });

        // Dashboard > Cirugías > Ver
        Breadcrumbs::for('cirugias.show', function ($trail, $cirugia) {
            $trail->parent('cirugias.index');
            $trail->push("Ver Cirugía #{$cirugia->id}", route('cirugias.show', $cirugia));
        });

        // Dashboard > Cirugías > Editar
        Breadcrumbs::for('cirugias.edit', function ($trail, $cirugia) {
            $trail->parent('cirugias.index');
            $trail->push("Editar Cirugía #{$cirugia->id}", route('cirugias.edit', $cirugia));
        });

        // Dashboard > Almacén
        Breadcrumbs::for('almacen.index', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('Almacén', route('almacen.index'));
        });

        // Dashboard > Almacén > Crear Item
        Breadcrumbs::for('almacen.create', function ($trail) {
            $trail->parent('almacen.index');
            $trail->push('Nuevo Item', route('almacen.create'));
        });

        // Dashboard > Despacho
        Breadcrumbs::for('despacho.index', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('Despacho', route('despacho.index'));
        });

        // Dashboard > Despacho > Crear
        Breadcrumbs::for('despacho.create', function ($trail) {
            $trail->parent('despacho.index');
            $trail->push('Nuevo Despacho', route('despacho.create'));
        });

        // Dashboard > Mi Perfil
        Breadcrumbs::for('admin.profile', function ($trail) {
            $trail->parent('dashboard');
            $trail->push('Mi Perfil', route('admin.profile'));
        });
    }
}
