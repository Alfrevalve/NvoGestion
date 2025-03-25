<?php

namespace Modules\Administracion\Http\Controllers;

use App\Http\Controllers\Controller; // Añade esta línea

use Illuminate\Http\Request;
use App\Models\User; // Importamos el modelo User
use Illuminate\Support\Facades\Hash; // Para el manejo de contraseñas
use Illuminate\Support\Facades\Validator; // Para validación de datos
use Illuminate\Support\Facades\Auth; // Para obtener el usuario autenticado

class UserController extends Controller
{
    /**
     * Muestra una lista de todos los usuarios del sistema
     *
     * Este método obtiene todos los usuarios de la base de datos,
     * los organiza y los envía a la vista para su visualización.
     * Se usa en el panel de administración para gestionar usuarios.
     */
    public function index()
    {
        $users = User::orderBy('name', 'asc')->paginate(10);
        return view('administracion.users.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario
     *
     * Este método prepara los datos necesarios (como roles disponibles)
     * para mostrar el formulario de creación de usuarios.
     */
    public function create()
    {
        $roles = Role::all(); // Suponiendo que existe un modelo Role
        return view('administracion.users.create', compact('roles'));
    }

    /**
     * Almacena un nuevo usuario en la base de datos
     *
     * Este método recibe los datos del formulario, los valida,
     * y crea un nuevo registro de usuario en la base de datos.
     * Incluye validación de datos y encriptación de contraseña.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Creación del usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'active' => true,
        ]);

        // Asignación de rol
        $user->assignRole($request->role_id);

        return redirect()->route('administracion.users.index')
            ->with('success', 'Usuario creado correctamente');
    }

    /**
     * Muestra los detalles de un usuario específico
     *
     * Este método obtiene y muestra información detallada de un usuario,
     * incluyendo sus datos personales, roles asignados y estadísticas de uso.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('administracion.users.show', compact('user'));
    }

    /**
     * Muestra el formulario para editar un usuario existente
     *
     * Este método carga los datos actuales del usuario y los roles disponibles
     * para permitir su edición en un formulario.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('administracion.users.edit', compact('user', 'roles'));
    }

    /**
     * Actualiza la información de un usuario existente
     *
     * Este método recibe los datos modificados, los valida,
     * y actualiza el registro del usuario en la base de datos.
     * No modifica la contraseña si no se proporciona una nueva.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validación de datos
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role_id' => 'required|exists:roles,id',
        ];

        // Solo validamos password si se ha enviado
        if (!empty($request->password)) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Actualización de datos básicos
        $user->name = $request->name;
        $user->email = $request->email;

        // Actualización de contraseña solo si se proporciona
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Actualización de rol
        $user->syncRoles([$request->role_id]);

        return redirect()->route('administracion.users.index')
            ->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Elimina un usuario del sistema
     *
     * Este método marca lógicamente al usuario como eliminado (soft delete)
     * o lo elimina físicamente de la base de datos, según la configuración.
     * Protege contra la eliminación de usuarios clave del sistema.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Evitar eliminación de usuario administrador principal
        if ($user->hasRole('super-admin')) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar al administrador principal');
        }

        // Soft delete (si está configurado en el modelo User)
        $user->delete();

        return redirect()->route('administracion.users.index')
            ->with('success', 'Usuario eliminado correctamente');
    }

    /**
     * Activa un usuario que está desactivado
     *
     * Este método cambia el estado de un usuario a activo,
     * permitiéndole iniciar sesión y usar el sistema nuevamente.
     */
    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->active = true;
        $user->save();

        return redirect()->back()
            ->with('success', 'Usuario activado correctamente');
    }

    /**
     * Desactiva un usuario activo
     *
     * Este método cambia el estado de un usuario a inactivo,
     * impidiéndole iniciar sesión mientras mantiene sus datos en el sistema.
     * Protege contra la desactivación de usuarios clave.
     */
    public function deactivate($id)
    {
        $user = User::findOrFail($id);

        // Evitar desactivación de usuario administrador principal
        if ($user->hasRole('super-admin')) {
            return redirect()->back()
                ->with('error', 'No se puede desactivar al administrador principal');
        }

        // Evitar auto-desactivación
        if (Auth::id() == $id) {
            return redirect()->back()
                ->with('error', 'No puedes desactivar tu propio usuario');
        }

        $user->active = false;
        $user->save();

        return redirect()->back()
            ->with('success', 'Usuario desactivado correctamente');
    }

    /**
     * Restablece la contraseña de un usuario
     *
     * Este método genera una nueva contraseña temporal para el usuario,
     * la encripta y actualiza en la base de datos. Opcionalmente, puede
     * enviar la nueva contraseña por correo electrónico al usuario.
     */
    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        // Generar contraseña temporal aleatoria
        $tempPassword = substr(md5(rand()), 0, 8);

        // Actualizar contraseña
        $user->password = Hash::make($tempPassword);
        $user->password_changed_at = null; // Para forzar cambio en próximo login
        $user->save();

        // Opcional: Enviar email con nueva contraseña
        // Mail::to($user->email)->send(new PasswordReset($user, $tempPassword));

        return redirect()->back()
            ->with('success', 'Contraseña restablecida correctamente. Contraseña temporal: ' . $tempPassword);
    }

    /**
     * Muestra la página de perfil del usuario autenticado
     *
     * Este método obtiene los datos del usuario actual y muestra
     * su perfil para permitirle ver y gestionar su información personal.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('administracion.users.profile', compact('user'));
    }

    /**
     * Actualiza el perfil del usuario autenticado
     *
     * Este método permite al usuario actualizar su propia información,
     * como nombre, email y contraseña, con validaciones específicas.
     * No permite cambiar roles u otros datos administrativos.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validación de datos
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ];

        // Solo validamos password si se ha enviado
        if (!empty($request->password)) {
            $rules['current_password'] = 'required|password';
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Actualización de datos básicos
        $user->name = $request->name;
        $user->email = $request->email;

        // Actualización de contraseña solo si se proporciona
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
            $user->password_changed_at = now(); // Registrar cambio de contraseña
        }

        $user->save();

        return redirect()->route('administracion.users.profile')
            ->with('success', 'Perfil actualizado correctamente');
    }
}
