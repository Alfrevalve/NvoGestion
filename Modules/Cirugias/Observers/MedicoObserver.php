<?php

namespace Modules\Cirugias\Observers;

use Modules\Cirugias\Models\Medico;

class MedicoObserver
{
    /**
     * Handle the Medico "created" event.
     *
     * @param  \Modules\Cirugias\Models\Medico  $medico
     * @return void
     */
    public function created(Medico $medico)
    {
        // Logic for when a Medico is created
    }

    /**
     * Handle the Medico "updated" event.
     *
     * @param  \Modules\Cirugias\Models\Medico  $medico
     * @return void
     */
    public function updated(Medico $medico)
    {
        // Logic for when a Medico is updated
    }

    /**
     * Handle the Medico "deleted" event.
     *
     * @param  \Modules\Cirugias\Models\Medico  $medico
     * @return void
     */
    public function deleted(Medico $medico)
    {
        // Logic for when a Medico is deleted
    }
}
