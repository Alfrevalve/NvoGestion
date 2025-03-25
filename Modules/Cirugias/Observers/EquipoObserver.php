<?php

namespace Modules\Cirugias\Observers;

use Modules\Cirugias\Models\Equipo;

class EquipoObserver
{
    /**
     * Handle the Equipo "created" event.
     *
     * @param  \Modules\Cirugias\Models\Equipo  $equipo
     * @return void
     */
    public function created(Equipo $equipo)
    {
        // Logic for when an Equipo is created
    }

    /**
     * Handle the Equipo "updated" event.
     *
     * @param  \Modules\Cirugias\Models\Equipo  $equipo
     * @return void
     */
    public function updated(Equipo $equipo)
    {
        // Logic for when an Equipo is updated
    }

    /**
     * Handle the Equipo "deleted" event.
     *
     * @param  \Modules\Cirugias\Models\Equipo  $equipo
     * @return void
     */
    public function deleted(Equipo $equipo)
    {
        // Logic for when an Equipo is deleted
    }
}
