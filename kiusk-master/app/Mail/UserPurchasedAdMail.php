<?php

namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserPurchasedAdMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $transaction;
    public $user;
    public $admins;
    public $price;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($admins, Transaction $transaction, $user)
    {
        $theme = config('app.locale') === 'fa' ? "default-rtl" : "default";
        config(['mail.markdown.theme' => $theme]);
        $this->admins = $admins;
        $this->transaction = $transaction;
        $this->order = $transaction->order;
        $this->user = $user;
        $this->price = $transaction->total_price;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $adminEmails = $this->admins->pluck('email')->toArray();
        return $this->from('info@kiusk.ca', 'Kisuk.ca')
            ->to($adminEmails)
            ->subject(__('A New Order Has Been Made'))
            ->markdown('emails.admins.user_purchased_plan');
    }
}
