<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastSeen
{
    /**
     * Actualiza el último momento en que se vio al usuario y registra usuarios en línea.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Continuar con la solicitud
        $response = $next($request);

        // Solo procesar para usuarios autenticados
        if (Auth::check()) {
            $user = Auth::user();
            $userId = $user->id;

            // Actualizar última actividad solo si pasaron al menos 5 minutos desde la última actualización
            // para no sobrecargar la base de datos con actualizaciones constantes
            $lastUpdate = Cache::get('user_last_update_' . $userId);
            $now = now();

            if (!$lastUpdate || $now->diffInMinutes($lastUpdate) >= 5) {
                // Actualizar el campo last_seen_at en el usuario
                $user->last_seen_at = $now;
                $user->save();

                // Actualizar el tiempo en caché para limitar actualizaciones
                Cache::put('user_last_update_' . $userId, $now, 60 * 5); // 5 minutos

                // Registrar usuario en la lista de usuarios en línea
                Cache::put('user_online_' . $userId, true, 60 * 10); // 10 minutos de expiración
            }
        }

        return $response;
    }
}
