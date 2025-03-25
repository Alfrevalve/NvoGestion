<?php

namespace Modules\Cirugias\Subscribers;

use Illuminate\Events\Dispatcher;

class CirugiaSubscriber
{
    /**
     * Maneja el evento de Cirugía programada.
     */
    public function onCirugiaScheduled($event)
    {
        // Lógica para cirugías programadas
    }

    /**
     * Maneja el evento de Cirugía completada.
     */
    public function onCirugiaCompleted($event)
    {
        // Lógica para cirugías completadas
    }

    /**
     * Maneja el evento de Cirugía cancelada.
     */
    public function onCirugiaCancelled($event)
    {
        // Lógica para cirugías canceladas
    }

    /**
     * Registra los listeners para los eventos.
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            \Modules\Cirugias\Events\CirugiaScheduled::class,
            [CirugiaSubscriber::class, 'onCirugiaScheduled']
        );

        $events->listen(
            \Modules\Cirugias\Events\CirugiaCompleted::class,
            [CirugiaSubscriber::class, 'onCirugiaCompleted']
        );

        $events->listen(
            \Modules\Cirugias\Events\CirugiaCancelled::class,
            [CirugiaSubscriber::class, 'onCirugiaCancelled']
        );
    }
}
