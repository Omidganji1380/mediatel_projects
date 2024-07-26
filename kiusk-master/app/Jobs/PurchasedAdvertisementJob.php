<?php

namespace App\Jobs;

use App\Mail\Admins\PaidUserMail;
use App\Mail\Admins\UserPurchasedPlanMail;
use App\Mail\UserPurchasedAdMail;
use App\Models\AdvertisementOrder;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Swift_TransportException;

class PurchasedAdvertisementJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $transaction;
    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction, $user)
    {
        $this->transaction = $transaction;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $this->user->notify(new PaymentNotification($this->order));
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();
        try {
            Mail::send(new UserPurchasedAdMail($admins, $this->transaction, $this->user));
            Mail::to('Kiusk.ca@yahoo.com')->queue(new PaidUserMail($this->user, $this->transaction->total_price, __("Advertisements")));
        } catch (Swift_TransportException $exception) {
            Log::error('Error sending email: ' . $exception->getMessage());
        }

    }
}
