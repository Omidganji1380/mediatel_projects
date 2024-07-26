<?php

namespace App\Mail\Admins;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class PaidUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $price;
    public $type;
    public $model;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $price, $type)
    {
        // App::setLocale('en');
        $theme = config('app.locale') === 'fa' ? "default-rtl" : "default";
        config(['mail.markdown.theme' => $theme]);
        $this->user = $user;
        $this->price = $price;
        $this->type = $type;
        $this->model = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@kiusk.ca', 'Kisuk.ca')
            ->subject('New Purchase')
            ->markdown('emails.admins.paid_user');
    }
}
