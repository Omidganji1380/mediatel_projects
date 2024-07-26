<?php

namespace App\Mail\Admins;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminUpgradeLevelMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $previousRole;
    public $role;
    public $price;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $role, $previousRole, $price = null)
    {
        $theme = config('app.locale') === 'fa' ? "default-rtl" : "default";
        config(['mail.markdown.theme' => $theme]);
        $this->user = $user;
        $this->role = __('messages.roles.' . $role);
        $this->previousRole = $previousRole;
        $this->price = $price;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@kiusk.ca', 'Kiusk')->subject(__('Upgrade Access Level'))->markdown('emails.admins.upgrade_level');
    }
}
