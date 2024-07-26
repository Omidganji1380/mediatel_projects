<?php

namespace App\Jobs;

use App\Models\PlanSubscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExpireSubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $planSubscription;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PlanSubscription $planSubscription)
    {
        $this->planSubscription = $planSubscription;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->planSubscription->update(['expired_at' => Carbon::now(), 'is_active' => false]);
        if($this->planSubscription?->plan->vip){
            $this->planSubscription->user->syncRoles('customer');
        }
    }
}
