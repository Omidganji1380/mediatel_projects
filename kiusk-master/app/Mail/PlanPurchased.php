<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PlanPurchased extends Mailable
{
    use Queueable, SerializesModels;

    protected $admins;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($admins)
    {
        $this->admins = $admins;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $adminEmails = $this->admins->pluck('email')->toArray();
        return $this->subject('New Plan Purchased')
                ->to($adminEmails)
                ->view('emails.plan-purchased-admin');
    }
}
