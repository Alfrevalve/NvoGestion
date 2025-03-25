<?php

namespace Modules\Cirugias\Observers;

use Modules\Cirugias\Models\Material;

class MaterialObserver
{
    /**
     * Handle the Material "created" event.
     *
     * @param  \Modules\Cirugias\Models\Material  $material
     * @return void
     */
    public function created(Material $material)
    {
        // Logic for when a Material is created
    }

    /**
     * Handle the Material "updated" event.
     *
     * @param  \Modules\Cirugias\Models\Material  $material
     * @return void
     */
    public function updated(Material $material)
    {
        // Logic for when a Material is updated
    }

    /**
     * Handle the Material "deleted" event.
     *
     * @param  \Modules\Cirugias\Models\Material  $material
     * @return void
     */
    public function deleted(Material $material)
    {
        // Logic for when a Material is deleted
    }
}
