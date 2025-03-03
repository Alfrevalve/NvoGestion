<?php

namespace Modules\Cirugias\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ShareErrorsFromSession
{
    /**
     * La instancia del factory de vistas.
     *
     * @var \Illuminate\Contracts\View\Factory
     */
    protected ViewFactory $view;

    /**
     * Constructor.
     *
     * @param \Illuminate\Contracts\View\Factory $view
     */
    public function __construct(ViewFactory $view)
    {
        $this->view = $view;
    }

    /**
     * Maneja la petición y comparte los errores de la sesión con todas las vistas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Comparte siempre un objeto ViewErrorBag (ya sea el de la sesión o uno nuevo)
        $errors = $request->session()->get('errors') ?: new ViewErrorBag();
        $this->view->share('errors', $errors);

        return $next($request);
    }
}
