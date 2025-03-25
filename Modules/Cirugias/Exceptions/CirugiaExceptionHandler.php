<?php

namespace Modules\Cirugias\Exceptions;

use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

/**
 * Manejador de excepciones personalizado para el módulo de Cirugías.
 */
class CirugiaExceptionHandler extends ExceptionHandler
{
    /**
     * Excepciones que no deben ser reportadas en los logs.
     */
    protected $dontReport = [
        CirugiaNotFoundException::class,
        CirugiaValidationException::class,
        UnauthorizedCirugiaAccessException::class,
    ];

    /**
     * Mapeo de excepciones a códigos de estado HTTP.
     */
    protected $exceptionStatusCodes = [
        CirugiaNotFoundException::class => 404,
        CirugiaValidationException::class => 422,
        UnauthorizedCirugiaAccessException::class => 403,
        QuirofanoUnavailableException::class => 409,
        MedicoUnavailableException::class => 409,
        MaterialInsuficienteException::class => 409,
        CirugiaAlreadyCompletedException::class => 422,
        CirugiaCancelledException::class => 422,
    ];

    /**
     * Reporta una excepción.
     */
    public function report(Throwable $e)
    {
        parent::report($e);
    }

    /**
     * Renderiza una excepción en una respuesta HTTP.
     */
    public function render($request, Throwable $e)
    {
        return parent::render($request, $e);
    }

    /**
     * Determina si la excepción debe ser reportada.
     */
    public function shouldReport(Throwable $e)
    {
        return parent::shouldReport($e);
    }

    /**
     * Renderiza una excepción en la consola.
     */
    public function renderForConsole($output, Throwable $e)
    {
        parent::renderForConsole($output, $e);
    }

    /**
     * Registra el manejo de excepciones personalizado.
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            if ($this->isCirugiaException($e)) {
                $this->logCirugiaException($e);
                return false; // Evita que Laravel registre la excepción por defecto.
            }
        });

        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($this->isCirugiaRoute($request)) {
                return $this->renderCirugiaException($request, new CirugiaNotFoundException(__('cirugias::exceptions.resource_not_found')));
            }
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($this->isCirugiaRoute($request)) {
                return $this->renderCirugiaException($request, new \Exception(__('cirugias::exceptions.method_not_allowed'), 405));
            }
        });

        $this->renderable(function (AccessDeniedHttpException $e, Request $request) {
            if ($this->isCirugiaRoute($request)) {
                return $this->renderCirugiaException($request, new UnauthorizedCirugiaAccessException(__('cirugias::exceptions.unauthorized_access')));
            }
        });
    }

    /**
     * Determina si una excepción pertenece al módulo de cirugías.
     */
    protected function isCirugiaException(Throwable $e): bool
    {
        return in_array(get_class($e), array_keys($this->exceptionStatusCodes), true);
    }

    /**
     * Verifica si la ruta pertenece al módulo de cirugías.
     */
    protected function isCirugiaRoute(Request $request): bool
    {
        return str_starts_with($request->path(), 'cirugias') ||
               str_starts_with($request->path(), 'api/cirugias') ||
               $request->is('admin/cirugias/*');
    }

    /**
     * Registra excepciones relacionadas con cirugías en los logs.
     */
    protected function logCirugiaException(Throwable $e): void
    {
        Log::error($e->getMessage(), [
            'module' => 'cirugias',
            'exception_class' => get_class($e),
            'user_id' => auth()->id() ?? 'guest',
            'request_path' => request()->path(),
            'request_method' => request()->method(),
        ]);
    }

    /**
     * Genera una respuesta adecuada para las excepciones de cirugías.
     */
    protected function renderCirugiaException(Request $request, Throwable $e)
    {
        $statusCode = $this->exceptionStatusCodes[get_class($e)] ?? 500;

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'error' => [
                    'message' => $e->getMessage(),
                    'type' => class_basename($e),
                    'code' => $statusCode,
                ]
            ], $statusCode);
        }

        return response()->view('cirugias::errors.generic', [
            'exception' => $e,
            'message' => $e->getMessage(),
            'statusCode' => $statusCode,
        ], $statusCode);
    }
}
