<?php

namespace App\Services\Plans;

use App\Models\Plan;
use App\Models\User;
use Carbon\Carbon;

class PlanService
{
    /**
     * Subscribe User to Plan
     *
     * @param User $user
     * @param Plan $plan
     * @return void
     */
    public function subscribe(User $user, Plan $plan)
    {
        $now = Carbon::now();
        $end = Carbon::now()->addDays($plan->convertDays()); // must change it based on intervals
        if($user->subscription()->exists()){
            $user->subscription()->update([
                'plan_id' => $plan->id,
                'starts_at' => $now,
                'ends_at' => $end,
            ]);
        }else{
            $user->subscription()->create([
                'plan_id' => $plan->id,
                'starts_at' => $now,
                'ends_at' => $end,
            ]);
        }
    }
}
