<?php

namespace App\Listeners;

use App\Events\ReferralScoreEvent;
use App\Factories\ScoringFactory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReferralScoreListener
{
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
     * @param  \App\Events\ReferralScoreEvent  $event
     * @return void
     */
    public function handle(ReferralScoreEvent $event)
    {
        $user = $event->user;
        $userRole = $user->getRoleNames()->first();
        $type = 'referral';
        $scorer = ScoringFactory::createScorerForUserType($userRole, $type);
        $score = $scorer->calculateScore($type);
        $user->scores()->create([
            'type' => $type,
            'score' => $score,
            'current_role' => $userRole,
            'claimed' => false,
            'spent' => false,
            'referral_user_id' => auth()->id()
        ]);
    }
}
