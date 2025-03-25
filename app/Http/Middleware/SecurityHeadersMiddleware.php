<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Aplica cabeceras de seguridad HTTP a todas las respuestas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevenir que el navegador "adivine" el tipo MIME
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Prevenir clickjacking - limita que el sitio pueda ser embebido en iframes
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Habilitar la protección XSS en navegadores modernos
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Establecer política de referrer
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Política de seguridad de contenido ampliada para permitir recursos necesarios
        $cspValue = "default-src 'self'; " .
                   "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://cdn.datatables.net; " .
                   "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net; " .
                   "img-src 'self' data: https:; " .
                   "font-src 'self' https://fonts.gstatic.com; " .
                   "connect-src 'self'; " .
                   "frame-src 'self'; " .
                   "object-src 'none'";





        $response->headers->set('Content-Security-Policy', $cspValue);

        // Establecer la política de permisos del navegador (Feature Policy)
        $response->headers->set(
            'Permissions-Policy',
            'camera=(), microphone=(), geolocation=(self), payment=()'
        );

        return $response;
    }
}
