<?php

namespace App\Observers;

use App\Factories\ScoringFactory;
use App\Models\Blog\Comment;

class CommentObserver
{
    /**
     * Handle the Comment "created" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function created(Comment $comment)
    {
        // $user = $comment->user;
        // $userRole = $user?->getRoleNames()?->first() ?? $user->rule;
        // $type = 'comment';
        // $scorer = ScoringFactory::createScorerForUserType($userRole, $type);
        // $score = $scorer->calculateScore($type);
        // $comment->user?->scores()?->create([
        //     'type' => $type,
        //     'score' => $score,
        //     'current_role' => $userRole,
        //     'claimed' => false,
        //     'spent' => false,
        // ]);
    }

    /**
     * Handle the Comment "updated" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function updated(Comment $comment)
    {
        //
    }

    /**
     * Handle the Comment "deleted" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function deleted(Comment $comment)
    {
        //
    }

    /**
     * Handle the Comment "restored" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function restored(Comment $comment)
    {
        //
    }

    /**
     * Handle the Comment "force deleted" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function forceDeleted(Comment $comment)
    {
        //
    }
}
