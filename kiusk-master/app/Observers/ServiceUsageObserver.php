<?php

namespace App\Observers;

use App\Factories\ScoringFactory;
use App\Models\ServiceUsage;

class ServiceUsageObserver
{
    /**
     * Handle the ServiceUsage "created" event.
     *
     * @param  \App\Models\ServiceUsage  $serviceUsage
     * @return void
     */
    public function created(ServiceUsage $serviceUsage)
    {
        //
    }

    /**
     * Handle the ServiceUsage "updated" event.
     *
     * @param  \App\Models\ServiceUsage  $serviceUsage
     * @return void
     */
    public function updated(ServiceUsage $serviceUsage)
    {
        //
    }

    /**
     * Handle the ServiceUsage "deleted" event.
     *
     * @param  \App\Models\ServiceUsage  $serviceUsage
     * @return void
     */
    public function deleted(ServiceUsage $serviceUsage)
    {
        //
    }

    /**
     * Handle the ServiceUsage "restored" event.
     *
     * @param  \App\Models\ServiceUsage  $serviceUsage
     * @return void
     */
    public function restored(ServiceUsage $serviceUsage)
    {
        //
    }

    /**
     * Handle the ServiceUsage "force deleted" event.
     *
     * @param  \App\Models\ServiceUsage  $serviceUsage
     * @return void
     */
    public function forceDeleted(ServiceUsage $serviceUsage)
    {
        //
    }
}
