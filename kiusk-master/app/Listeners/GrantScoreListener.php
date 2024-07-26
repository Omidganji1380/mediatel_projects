<?php

namespace App\Listeners;

use App\Events\ScoreEvent;
use App\Factories\ScoringFactory;
use App\Mail\User\ScoreNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Swift_TransportException;

class GrantScoreListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(ScoreEvent $event)
    {
        $user = $event->user;
        $userRole = $user?->getRoleNames()?->first() ?? $user->rule;
        $scorer = ScoringFactory::createScorerForUserType($userRole, $event->type);
        $score = $scorer->calculateScore($event->type);
        $user->scores()?->create([
            'type' => $event->type,
            'score' => $score,
            'current_role' => $userRole,
            'claimed' => true,
            'spent' => false,
        ]);
         // Send email notification
        if($user->email && !Str::contains($user->email, '@telegram.telegram')){
            try {
                Mail::to($user->email)->send(new ScoreNotification($user, $score, $event->type));
            } catch (Swift_TransportException $exception) {
                Log::error('Error sending email: ' . $exception->getMessage());
            }
        }

    }
}
