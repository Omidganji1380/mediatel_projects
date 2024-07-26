<?php

namespace App\Observers;

use App\Factories\ScoringFactory;
use App\Models\UserVideo;

class UserVideoObserver
{
    /**
     * Handle the UserVideo "created" event.
     *
     * @param  \App\Models\UserVideo  $userVideo
     * @return void
     */
    public function created(UserVideo $userVideo)
    {
        //
    }

    /**
     * Handle the UserVideo "updated" event.
     *
     * @param  \App\Models\UserVideo  $userVideo
     * @return void
     */
    public function updated(UserVideo $userVideo)
    {
        //
    }

    /**
     * Handle the UserVideo "deleted" event.
     *
     * @param  \App\Models\UserVideo  $userVideo
     * @return void
     */
    public function deleted(UserVideo $userVideo)
    {
        //
    }

    /**
     * Handle the UserVideo "restored" event.
     *
     * @param  \App\Models\UserVideo  $userVideo
     * @return void
     */
    public function restored(UserVideo $userVideo)
    {
        //
    }

    /**
     * Handle the UserVideo "force deleted" event.
     *
     * @param  \App\Models\UserVideo  $userVideo
     * @return void
     */
    public function forceDeleted(UserVideo $userVideo)
    {
        //
    }
}
