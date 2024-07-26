<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatusNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $message;
    public $link;
    public $btnText;
    public $color;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $message, $link = null, $btnText = null, $color = null)
    {
        $this->user = $user;
        $this->message = $message;
        $this->link = $link ?: route('front.panel.user.ad.index');
        $this->btnText = $btnText ?: __('My Ads');
        $this->color = $color ?: 'primary';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@kiusk.ca', 'Kiusk')->markdown('emails.status-notification');
    }
}
