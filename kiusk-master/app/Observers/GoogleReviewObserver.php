<?php

namespace App\Observers;

use App\Factories\ScoringFactory;
use App\Models\GoogleReview;

class GoogleReviewObserver
{
    /**
     * Handle the GoogleReview "created" event.
     *
     * @param  \App\Models\GoogleReview  $googleReview
     * @return void
     */
    public function created(GoogleReview $googleReview)
    {
        $user = $googleReview->user;
        $userRole = $user?->getRoleNames()?->first() ?? $user->rule;
        $type = 'google_review';
        $scorer = ScoringFactory::createScorerForUserType($userRole, $type);
        $score = $scorer->calculateScore($type);
        $googleReview->user?->scores()?->create([
            'type' => $type,
            'score' => $score,
            'current_role' => $userRole,
            'claimed' => false,
            'spent' => false,
        ]);
    }

    /**
     * Handle the GoogleReview "updated" event.
     *
     * @param  \App\Models\GoogleReview  $googleReview
     * @return void
     */
    public function updated(GoogleReview $googleReview)
    {
        //
    }

    /**
     * Handle the GoogleReview "deleted" event.
     *
     * @param  \App\Models\GoogleReview  $googleReview
     * @return void
     */
    public function deleted(GoogleReview $googleReview)
    {
        //
    }

    /**
     * Handle the GoogleReview "restored" event.
     *
     * @param  \App\Models\GoogleReview  $googleReview
     * @return void
     */
    public function restored(GoogleReview $googleReview)
    {
        //
    }

    /**
     * Handle the GoogleReview "force deleted" event.
     *
     * @param  \App\Models\GoogleReview  $googleReview
     * @return void
     */
    public function forceDeleted(GoogleReview $googleReview)
    {
        //
    }
}
