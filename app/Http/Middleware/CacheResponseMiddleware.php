<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CacheResponseMiddleware
{
    /**
     * Implementa caché de respuesta para mejorar rendimiento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $ttl  Tiempo de vida en minutos (predeterminado: 60 minutos)
     * @return mixed
     */
    public function handle(Request $request, Closure $next, int $ttl = 60): Response
    {
        // No aplicar caché para métodos no GET o solicitudes autenticadas
        if ($request->method() !== 'GET' || $request->user()) {
            return $next($request);
        }

        // Generar una clave única para la caché basada en la URL
        $cacheKey = 'response_cache:' . md5($request->fullUrl());

        // Verificar si existe la respuesta en caché
        if (Cache::has($cacheKey)) {
            return response(Cache::get($cacheKey)['content'])
                ->withHeaders(Cache::get($cacheKey)['headers']);
        }

        // Procesar la solicitud
        $response = $next($request);

        // Solo cachear respuestas exitosas
        if ($response->getStatusCode() === 200) {
            $headers = $response->headers->all();

            // Excluir headers problemáticos para caché
            unset($headers['set-cookie']);

            // Almacenar la respuesta en caché
            Cache::put($cacheKey, [
                'content' => $response->getContent(),
                'headers' => $headers,
            ], $ttl * 60); // Convertir minutos a segundos
        }

        return $response;
    }
}
