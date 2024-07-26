<?php

namespace App\Jobs;

use App\Events\PinAdEvent;
use App\Models\Ad\Ad;
use App\Models\Plan;
use App\Traits\Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PromoteAd implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Helper;

    public $ad;
    public $plan;
    public $end;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Ad $ad, Plan $plan, $end = null)
    {
        $this->ad = $ad;
        $this->plan = $plan;
        $this->end = $end;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->updateAdSubscription($this->plan,$this->ad, $this->end);
        if($this->plan->pin_ad){
            PinAdEvent::dispatch($this->ad);
        }
    }
}
