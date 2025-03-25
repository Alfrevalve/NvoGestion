<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuditLogMiddleware
{
    /**
     * Implementa registro de auditoría detallado para operaciones críticas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Capturar el estado actual si es una operación de modificación
        $method = $request->method();
        $isModifying = in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE']);
        $path = $request->path();
        $user = Auth::user();

        // Para operaciones de modificación, intentar capturar el estado anterior
        $oldState = null;
        $resourceId = null;

        if ($isModifying && $request->route()) {
            $params = $request->route()->parameters();

            // Intentar determinar el ID del recurso que está siendo modificado
            foreach ($params as $key => $value) {
                if (is_object($value) && method_exists($value, 'getKey')) {
                    // Si es un modelo Eloquent
                    $resourceId = $value->getKey();
                    $oldState = $value->toArray();
                    break;
                } elseif (is_numeric($value) && strpos($key, 'id') !== false) {
                    // Si parece ser un ID
                    $resourceId = $value;
                    break;
                }
            }
        }

        // Procesar la solicitud
        $response = $next($request);

        // Registrar la operación
        if ($isModifying && $user) {
            $statusCode = $response->getStatusCode();
            $success = $statusCode >= 200 && $statusCode < 300;

            // Datos para el registro de auditoría
            $auditData = [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'action' => $method . ' ' . $path,
                'resource_id' => $resourceId,
                'status' => $success ? 'success' : 'failed',
                'status_code' => $statusCode,
                'ip_address' => $request->ip(),
                'old_state' => $oldState,
                'new_state' => $request->except(['password', 'password_confirmation', 'token']),
                'timestamp' => now()->toIso8601String(),
            ];

            // Registrar la operación según el resultado
            if ($success) {
                Log::channel('audit')->info("Operación exitosa: " . $method . " " . $path, $auditData);
            } else {
                Log::channel('audit')->warning("Operación fallida: " . $method . " " . $path, $auditData);
            }

            // También podría guardarse en base de datos
            // \App\Models\AuditLog::create($auditData);
        }

        return $response;
    }
}
