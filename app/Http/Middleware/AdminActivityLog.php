<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminActivityLog
{
    /**
     * Registra actividad administrativa detallada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Registrar los datos de la solicitud antes de procesarla
        $startTime = microtime(true);
        $method = $request->method();
        $path = $request->path();
        $ip = $request->ip();
        $user = Auth::user();

        // Capturar solo los parámetros importantes, excluyendo datos sensibles
        $inputData = $request->except(['password', 'password_confirmation', 'token']);

        $response = $next($request);

        // Registrar datos completos de la operación después de procesarla
        $duration = microtime(true) - $startTime;
        $statusCode = $response->getStatusCode();

        $logData = [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'roles' => $user->getRoleNames(),
            'method' => $method,
            'path' => $path,
            'input' => $inputData,
            'ip' => $ip,
            'duration' => round($duration * 1000, 2) . 'ms', // En milisegundos
            'status_code' => $statusCode,
            'user_agent' => $request->userAgent(),
        ];

        // Guardar en tabla de auditoría para operaciones importantes (POST, PUT, DELETE)
        if (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            // \App\Models\AdminAuditLog::create([
            //     'user_id' => $user->id,
            //     'action' => $method . ' ' . $path,
            //     'description' => 'Operación administrativa en ' . $path,
            //     'old_values' => json_encode($request->session()->get('_old_input', [])),
            //     'new_values' => json_encode($inputData),
            //     'ip_address' => $ip,
            //     'user_agent' => $request->userAgent(),
            //     'status_code' => $statusCode
            // ]);

            // Log detallado para operaciones administrativas
            Log::channel('admin_activity')->info(
                "Operación administrativa: " . $method . " " . $path,
                $logData
            );
        }

        return $response;
    }
}
