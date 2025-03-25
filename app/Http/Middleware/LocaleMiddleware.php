<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Lista de idiomas soportados por la aplicación.
     *
     * @var array
     */
    protected $availableLocales = ['es', 'en', 'pt'];

    /**
     * Maneja la configuración de idioma para la aplicación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Prioridad 1: Parámetro de URL (?lang=es)
        $locale = $request->query('lang');

        // Prioridad 2: Sesión actual
        if (!$locale && Session::has('locale')) {
            $locale = Session::get('locale');
        }

        // Prioridad 3: Preferencia del usuario autenticado
        if (!$locale && Auth::check() && Auth::user()->language) {
            $locale = Auth::user()->language;
        }

        // Prioridad 4: Cabecera Accept-Language del navegador
        if (!$locale) {
            $locale = $request->getPreferredLanguage($this->availableLocales);
        }

        // Validar que el idioma esté soportado, sino usar el predeterminado
        if (!in_array($locale, $this->availableLocales)) {
            $locale = config('app.locale');
        }

        // Establecer el idioma en la aplicación
        App::setLocale($locale);
        Session::put('locale', $locale);

        return $next($request);
    }
}
