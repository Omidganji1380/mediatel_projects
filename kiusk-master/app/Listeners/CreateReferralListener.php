<?php

namespace App\Listeners;

use App\Events\RegisterEvent;
use App\Traits\Helper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateReferralListener
{
    use Helper;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\RegisterEvent  $event
     * @return void
     */
    public function handle(RegisterEvent $event)
    {
        if (!$event->user->referralCode()->exists()) {
            $event->user->referralCode()->create([
                'referral_code' => $this->generateReferralCode($event->user->id),
            ]);
        }
    }
}
