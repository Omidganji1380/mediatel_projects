<?php

namespace App\Mail\User;

use App\Models\Ad\Ad;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PromoteAdMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $ad;
    public $link;
    public $btnText;
    public $color;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Ad $ad)
    {
        $this->user = $user;
        $this->ad = $ad;
        $this->link = route('front.panel.user.ad.index');
        $this->btnText = __('My Ads');
        $this->color = 'primary';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@kiusk.ca', 'Kiusk')->markdown('emails.promote-ad');
    }
}
