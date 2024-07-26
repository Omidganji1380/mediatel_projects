<?php

namespace App\Listeners;

use App\Events\RegisterEvent;
use App\Mail\Admins\RegisteredUserMail;
use App\Mail\WelcomeEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Swift_TransportException;

class WelcomeEmailListener
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
     * @param  \App\Events\RegisterEvent  $event
     * @return void
     */
    public function handle(RegisterEvent $event)
    {
        list($username, $domain) = explode('@', $event->user->email);
        if($event->user?->email && !Str::contains($domain, 'telegram.telegram')){
            try {
                // Your email sending code here
                Mail::to($event->user->email)->send(new WelcomeEmail($event->user));
            } catch (Swift_TransportException $exception) {
                // Handle the exception without displaying the error message
                // You can log the error, display a generic error message, or simply ignore it
                // For example:
                Log::error('Error sending email: ' . $exception->getMessage());
            }
        }
        try {
            Mail::to('memoney026@gmail.com')->send(new RegisteredUserMail($event->user, $event->via));
            Mail::to('Kiusk.ca@yahoo.com')->send(new RegisteredUserMail($event->user, $event->via));
        } catch (Swift_TransportException $exception) {
            Log::error('Error sending email: ' . $exception->getMessage());
        }

    }
}
