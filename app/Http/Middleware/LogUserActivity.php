<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogUserActivity
{
    /**
     * Registra la actividad de los usuarios en la aplicación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (Auth::check()) {
            $user = Auth::user();
            $path = $request->path();
            $method = $request->method();
            $ip = $request->ip();
            $userAgent = $request->userAgent();

            // Actualizar el "último visto" del usuario
            $user->last_seen_at = now();
            $user->save();

            // Registrar la actividad sin datos sensibles
            $logData = [
                'user_id' => $user->id,
                'path' => $path,
                'method' => $method,
                'ip' => $ip,
                'user_agent' => $userAgent,
                'status_code' => $response->getStatusCode()
            ];

            // Opcional: Almacenar en base de datos para análisis
            // \App\Models\UserActivity::create($logData);

            // Registrar en el log solo si no es una ruta de assets o similar
            if (!$this->shouldIgnore($path)) {
                Log::channel('user_activity')->info("Actividad de usuario", $logData);
            }
        }

        return $response;
    }

    /**
     * Determina si una ruta debe ser ignorada del registro.
     *
     * @param  string  $path
     * @return bool
     */
    private function shouldIgnore(string $path): bool
    {
        $ignorePaths = [
            'css', 'js', 'images', 'fonts', 'favicon.ico',
            'robots.txt', 'sitemap.xml', '_debugbar'
        ];

        foreach ($ignorePaths as $ignorePath) {
            if (strpos($path, $ignorePath) === 0) {
                return true;
            }
        }

        return false;
    }
}
