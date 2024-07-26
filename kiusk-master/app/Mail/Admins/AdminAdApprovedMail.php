<?php

namespace App\Mail\Admins;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminAdApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ad;
    public $admin;
    public $reason;
    public $link;
    public $btnText;
    public $color;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ad, $admin, $reason = null, $link = null, $btnText = null, $color = null)
    {
        $theme = config('app.locale') === 'fa' ? "default-rtl" : "default";
        config(['mail.markdown.theme' => $theme]);
        $this->ad = $ad;
        $this->admin = $admin;
        $this->reason = $reason;
        $this->link = $link ?: "#";
        $this->btnText = $btnText ?: __('Ad');
        $this->color = $color ?: 'primary';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@kiusk.ca', 'Kiusk')->subject(__('Approved Ad'))->markdown('emails.admins.approved-ad');
    }
}
