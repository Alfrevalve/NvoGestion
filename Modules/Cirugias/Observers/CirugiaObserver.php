<?php

namespace Modules\Cirugias\Observers;

use Modules\Cirugias\Models\Cirugia;

class CirugiaObserver
{
    /**
     * Handle the Cirugia "created" event.
     *
     * @param  \Modules\Cirugias\Models\Cirugia  $cirugia
     * @return void
     */
    public function created(Cirugia $cirugia)
    {
        // Logic for when a Cirugia is created
    }

    /**
     * Handle the Cirugia "updated" event.
     *
     * @param  \Modules\Cirugias\Models\Cirugia  $cirugia
     * @return void
     */
    public function updated(Cirugia $cirugia)
    {
        // Logic for when a Cirugia is updated
    }

    /**
     * Handle the Cirugia "deleted" event.
     *
     * @param  \Modules\Cirugias\Models\Cirugia  $cirugia
     * @return void
     */
    public function deleted(Cirugia $cirugia)
    {
        // Logic for when a Cirugia is deleted
    }
}
