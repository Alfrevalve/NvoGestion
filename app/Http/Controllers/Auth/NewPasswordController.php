<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Muestra la vista para restablecer la contraseña.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Maneja una solicitud de nueva contraseña entrante.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([ // Valida los datos de la nueva contraseña
            'token' => ['required'], // Valida que el token sea requerido
            'email' => ['required', 'email'], // Valida que el email sea requerido y válido
            'password' => ['required', 'confirmed', Rules\Password::defaults()], // Valida que la contraseña sea requerida y confirmada
        ]);

        // Intentamos restablecer la contraseña del usuario. Si tiene éxito, actualizamos la contraseña en el modelo de usuario y la persistimos en la base de datos.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // Si la contraseña fue restablecida con éxito, redirigimos al usuario a la vista de inicio de sesión. Si hay un error, los redirigimos de vuelta con su mensaje de error.
        return $status == Password::PASSWORD_RESET // Verifica si la contraseña fue restablecida
                    ? redirect()->route('login')->with('status', __($status)) // Redirige a la página de inicio de sesión
                    : back()->withInput($request->only('email')) // Mantiene el email en caso de error
                            ->withErrors(['email' => __($status)]); // Devuelve errores si el restablecimiento falla
    }
}
