<?php

namespace Modules\Cirugias\Observers;

use Modules\Cirugias\Models\Quirofano;

class QuirofanoObserver
{
    /**
     * Handle the Quirofano "created" event.
     *
     * @param  \Modules\Cirugias\Models\Quirofano  $quirofano
     * @return void
     */
    public function created(Quirofano $quirofano)
    {
        // Logic for when a Quirofano is created
    }

    /**
     * Handle the Quirofano "updated" event.
     *
     * @param  \Modules\Cirugias\Models\Quirofano  $quirofano
     * @return void
     */
    public function updated(Quirofano $quirofano)
    {
        // Logic for when a Quirofano is updated
    }

    /**
     * Handle the Quirofano "deleted" event.
     *
     * @param  \Modules\Cirugias\Models\Quirofano  $quirofano
     * @return void
     */
    public function deleted(Quirofano $quirofano)
    {
        // Logic for when a Quirofano is deleted
    }
}
