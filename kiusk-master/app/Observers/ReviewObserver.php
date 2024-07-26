<?php

namespace App\Observers;

use App\Factories\ScoringFactory;
use App\Models\Ad\Review;

class ReviewObserver
{
    /**
     * Handle the Review "created" event.
     *
     * @param  \App\Models\Review  $review
     * @return void
     */
    public function created(Review $review)
    {
        // $user = $review->user;
        // $userRole = $user?->getRoleNames()?->first() ?? $user->rule;
        // $type = 'review';
        // $scorer = ScoringFactory::createScorerForUserType($userRole, $type);
        // $score = $scorer->calculateScore($type);
        // $review->user?->scores()?->create([
        //     'type' => $type,
        //     'score' => $score,
        //     'current_role' => $userRole,
        //     'claimed' => false,
        //     'spent' => false,
        // ]);
    }

    /**
     * Handle the Review "updated" event.
     *
     * @param  \App\Models\Review  $review
     * @return void
     */
    public function updated(Review $review)
    {
        //
    }

    /**
     * Handle the Review "deleted" event.
     *
     * @param  \App\Models\Review  $review
     * @return void
     */
    public function deleted(Review $review)
    {
        //
    }

    /**
     * Handle the Review "restored" event.
     *
     * @param  \App\Models\Review  $review
     * @return void
     */
    public function restored(Review $review)
    {
        //
    }

    /**
     * Handle the Review "force deleted" event.
     *
     * @param  \App\Models\Review  $review
     * @return void
     */
    public function forceDeleted(Review $review)
    {
        //
    }
}
