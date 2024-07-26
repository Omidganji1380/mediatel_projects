<?php

namespace App\Listeners;

use App\Events\PinAdEvent;
use App\Mail\Admins\PinAdEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Swift_TransportException;

class PinAdEmailAdminListener
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
    public function handle(PinAdEvent $event)
    {
        // Get the admin users
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();

        // Get the specific ad related to the purchase
        $ad = $event->ad; // Replace $adId with the appropriate way to retrieve the ad
        Log::info('PinAdEmailAdminListener');
        // Send the email to the admin users
        try {
            Mail::send(new PinAdEmail($admins, $ad));
        } catch (Swift_TransportException $exception) {
            Log::error('Error sending email: ' . $exception->getMessage());
        }
    }
}
