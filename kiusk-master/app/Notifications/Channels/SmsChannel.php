<?php

namespace App\Notifications\Channels;

use App\Services\Sms\SmsService;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        return app(SmsService::class)->send($notifiable->phone, $notification->message);
    }
}
