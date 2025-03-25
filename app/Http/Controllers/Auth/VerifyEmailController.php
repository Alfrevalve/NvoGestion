<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Marca la dirección de correo electrónico del usuario autenticado como verificada.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) { // Verifica si el email ya está verificado
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1'); // Redirige si el email ya está verificado
        }

        if ($request->user()->markEmailAsVerified()) { // Marca el email como verificado
            event(new Verified($request->user())); // Dispara el evento de verificación
        }

        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1'); // Redirige después de verificar el email
    }
}
