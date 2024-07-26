<?php

namespace App\Notifications\User;

use App\Mail\User\StatusNotificationMail;
use App\Notifications\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusNotification extends Notification
{
    use Queueable;

    public $message;
    public $link;
    public $btnText;
    public $color;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $link = null, $btnText = null, $color = null)
    {
        $this->message = $message;
        $this->link = $link ?: route('front.panel.user.ad.index');
        $this->btnText = $btnText ?: __('My Ads');
        $this->color = $color ?: 'primary';
        $theme = config('app.locale') === 'fa' ? "default-rtl" : "default";
        config(['mail.markdown.theme' => $theme]);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', SmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new StatusNotificationMail($notifiable, $this->message, $this->link, $this->btnText, $this->color));
                    // ->line(__('notifications.dear_user', ['name' => $notifiable->full_name]))
                    // ->line($this->message)
                    // ->action(__('My Ads'), url('/my-account'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
