<?php

namespace Modules\Administracion\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Importamos el controlador base
use Spatie\Permission\Models\Role; // Asumiendo que utilizas spatie/laravel-permission
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Muestra un listado de todos los roles del sistema
     *
     * Este método obtiene todos los roles existentes y los envía
     * a la vista para mostrarlos en una tabla o lista. Los roles
     * son fundamentales para el control de acceso basado en roles (RBAC).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('administracion.roles.index', compact('roles'));
    }

    /**
     * Muestra el formulario para crear un nuevo rol
     *
     * Este método prepara los datos necesarios para mostrar el formulario
     * de creación de roles, incluyendo la lista de permisos disponibles
     * que pueden asignarse al nuevo rol.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('administracion.roles.create', compact('permissions'));
    }

    /**
     * Almacena un nuevo rol en la base de datos
     *
     * Este método procesa el formulario de creación de roles,
     * validando los datos recibidos y creando un nuevo rol con
     * los permisos seleccionados. Los roles son esenciales para
     * definir las capacidades de los usuarios en el sistema.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validación de datos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Creación del rol
        $role = Role::create(['name' => $request->name]);

        // Asignación de permisos
        $role->syncPermissions($request->permissions);

        return redirect()->route('administracion.roles.index')
            ->with('success', 'Rol creado correctamente');
    }

    /**
     * Muestra la información detallada de un rol específico
     *
     * Este método obtiene un rol por su ID y muestra sus detalles,
     * incluyendo los permisos asociados y posiblemente estadísticas
     * sobre cuántos usuarios tienen este rol asignado.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $usersCount = $role->users()->count(); // Número de usuarios con este rol

        return view('administracion.roles.show', compact('role', 'usersCount'));
    }

    /**
     * Muestra el formulario para editar un rol existente
     *
     * Este método prepara los datos necesarios para el formulario
     * de edición, incluyendo el rol a editar y todos los permisos
     * disponibles en el sistema, marcando los que ya están asignados.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('administracion.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Actualiza un rol existente en la base de datos
     *
     * Este método procesa el formulario de edición de roles,
     * validando los datos y actualizando el rol y sus permisos.
     * Incluye protección contra la modificación de roles críticos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        // Proteger roles críticos
        if ($role->name === 'Super Admin' && $request->name !== 'Super Admin') {
            return redirect()->back()
                ->with('error', 'No se puede modificar el nombre del rol Super Admin');
        }

        // Validación de datos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Actualización del rol
        $role->update(['name' => $request->name]);

        // Actualización de permisos
        $role->syncPermissions($request->permissions);

        return redirect()->route('administracion.roles.index')
            ->with('success', 'Rol actualizado correctamente');
    }

    /**
     * Elimina un rol del sistema
     *
     * Este método elimina un rol específico, pero incluye
     * comprobaciones para prevenir la eliminación de roles
     * críticos para el funcionamiento del sistema.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        // Proteger roles críticos
        if (in_array($role->name, ['Super Admin', 'Admin'])) {
            return redirect()->back()
                ->with('error', 'No se pueden eliminar roles críticos del sistema');
        }

        // Verificar si hay usuarios con este rol
        if ($role->users()->count() > 0) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar un rol que tiene usuarios asignados');
        }

        $role->delete();

        return redirect()->route('administracion.roles.index')
            ->with('success', 'Rol eliminado correctamente');
    }
}
