<?php

namespace Modules\Cirugias\Subscribers;

use Illuminate\Events\Dispatcher;
use Modules\Cirugias\Events\MaterialUtilizado;
use Modules\Cirugias\Events\StockActualizado;
use Modules\Cirugias\Events\MaterialInsuficiente;
use Illuminate\Support\Facades\Log;

class InventarioSubscriber
{
    /**
     * Maneja el evento cuando se usa material en una cirugía.
     */
    public function onMaterialUtilizado(MaterialUtilizado $event)
    {
        Log::info("Material utilizado: {$event->material->nombre} - Cantidad: {$event->cantidad}");

        // Lógica para actualizar el inventario
        $event->material->decrement('stock', $event->cantidad);
    }

    /**
     * Maneja el evento cuando el stock se actualiza.
     */
    public function onStockActualizado(StockActualizado $event)
    {
        Log::info("Stock actualizado: {$event->material->nombre} - Nuevo stock: {$event->material->stock}");
    }

    /**
     * Maneja el evento cuando hay material insuficiente.
     */
    public function onMaterialInsuficiente(MaterialInsuficiente $event)
    {
        Log::warning("Material insuficiente: {$event->material->nombre} - Stock actual: {$event->material->stock}");
    }

    /**
     * Registra los listeners para los eventos de inventario.
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            MaterialUtilizado::class,
            [InventarioSubscriber::class, 'onMaterialUtilizado']
        );

        $events->listen(
            StockActualizado::class,
            [InventarioSubscriber::class, 'onStockActualizado']
        );

        $events->listen(
            MaterialInsuficiente::class,
            [InventarioSubscriber::class, 'onMaterialInsuficiente']
        );
    }
}
