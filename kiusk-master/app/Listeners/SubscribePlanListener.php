<?php

namespace App\Listeners;

use App\Models\Plan;
use App\Services\Plans\PlanService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SubscribePlanListener
{
    public $service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(PlanService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $plan = Plan::where('type', 'free')->firstOrFail();
        $this->service->subscribe($event->user, $plan);
    }
}
