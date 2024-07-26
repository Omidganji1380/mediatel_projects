<?php

namespace App\Mail\Admins;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class RegisteredUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $via;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, string $via)
    {
        $theme = config('app.locale') === 'fa' ? "default-rtl" : "default";
        config(['mail.markdown.theme' => $theme]);
        $this->user = $user;
        $this->via = $via;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@kiusk.ca', 'Kisuk.ca')
            ->subject(__('New Registered User'))
            ->markdown('emails.admins.registered_users');
    }
}
