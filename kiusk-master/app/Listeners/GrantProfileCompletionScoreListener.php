<?php

namespace App\Listeners;

use App\Events\ProfileEvent;
use App\Mail\User\ScoreNotification;
use App\Models\Score;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Swift_TransportException;

class GrantProfileCompletionScoreListener
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
     * @param  \App\Events\ProfileEvent  $event
     * @return void
     */
    public function handle(ProfileEvent $event)
    {
        $score = Score::where('user_id', $event->user?->referral?->user_id)
            ->where('referral_user_id', $event->user->id)
            ->first();
        if ($score) {
            Log::info('Exists');
            $score->update([
                'claimed' => true
            ]);
            // Send email notification
            if($score->user?->email && !Str::contains($score->user->email, '@telegram.telegram')){
                try {
                    Mail::to($score->user->email)->send(new ScoreNotification($score->user, $score->score ?? 0, $score->type));
                } catch (Swift_TransportException $exception) {
                    Log::error('Error sending email: ' . $exception->getMessage());
                }
            }
        }else{
            Log::info('Not Exists');
            Log::info($event->user->referral?->user_id);
        }
    }
}
