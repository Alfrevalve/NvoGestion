<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseFormat
{
    /**
     * Estandariza el formato de las respuestas API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Solo procesar respuestas JSON en rutas API
        if (!$response instanceof JsonResponse) {
            return $response;
        }

        $statusCode = $response->getStatusCode();
        $originalData = $response->getData(true);

        // Si la respuesta ya tiene el formato esperado, no modificarla
        if (isset($originalData['success']) &&
            (isset($originalData['data']) || isset($originalData['errors']))) {
            return $response;
        }

        // Determinar si es una respuesta exitosa basada en el código de estado
        $success = $statusCode >= 200 && $statusCode < 300;

        $formattedData = [
            'success' => $success,
            'data' => $success ? $originalData : null,
            'message' => $this->getDefaultMessageForStatus($statusCode),
            'errors' => !$success ? ($originalData['errors'] ?? [$originalData['message'] ?? 'Error en la operación']) : [],
            'meta' => [
                'timestamp' => now()->toIso8601String(),
                'api_version' => config('app.api_version', '1.0'),
            ],
        ];

        // Para errores de validación, extraer los mensajes
        if ($statusCode === 422 && isset($originalData['errors'])) {
            $formattedData['errors'] = $originalData['errors'];
        }

        // Conservar mensajes personalizados si existen
        if (isset($originalData['message'])) {
            $formattedData['message'] = $originalData['message'];
        }

        return $response->setData($formattedData);
    }

    /**
     * Obtiene un mensaje predeterminado según el código de estado HTTP.
     *
     * @param  int  $statusCode
     * @return string
     */
    private function getDefaultMessageForStatus(int $statusCode): string
    {
        $messages = [
            200 => 'Operación exitosa',
            201 => 'Recurso creado correctamente',
            204 => 'Recurso eliminado correctamente',
            400 => 'Solicitud incorrecta',
            401 => 'No autorizado',
            403 => 'Acceso prohibido',
            404 => 'Recurso no encontrado',
            422 => 'Error de validación',
            500 => 'Error interno del servidor',
        ];

        return $messages[$statusCode] ?? 'Operación procesada';
    }
}
