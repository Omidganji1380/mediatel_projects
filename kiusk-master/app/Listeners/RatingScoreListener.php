<?php

namespace App\Listeners;

use App\Events\RatingEvent;
use App\Factories\ScoringFactory;
use App\Mail\User\ScoreNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Swift_TransportException;

class RatingScoreListener
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
     * @param  \App\Events\RatingEvent  $event
     * @return void
     */
    public function handle(RatingEvent $event)
    {
        $user = $event->user;
        $userRole = $user?->getRoleNames()?->first() ?? $user->rule;
        $type = 'rate';
        $scorer = ScoringFactory::createScorerForUserType($userRole, $type);
        $score = $scorer->calculateScore($type);
        $user?->scores()?->create([
            'type' => $type,
            'score' => $score,
            'current_role' => $userRole,
            'claimed' => true,
            'spent' => false,
        ]);
        // Send email notification
        if ($user->email && !Str::contains($user->email, '@telegram.telegram')){
            try {
                Mail::to($user->email)->send(new ScoreNotification($user, $score, $type));
            } catch (Swift_TransportException $exception) {
                Log::error('Error sending email: ' . $exception->getMessage());
            }
        }
    }
}
