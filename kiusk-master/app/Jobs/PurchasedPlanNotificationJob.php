<?php

namespace App\Jobs;

use App\Mail\Admins\PaidUserMail;
use App\Mail\Admins\UserPurchasedPlanMail;
use App\Models\Plan;
use App\Models\Shop\Order;
use App\Models\User;
use App\Notifications\User\PaymentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Swift_TransportException;

class PurchasedPlanNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;
    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order, User $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->notify(new PaymentNotification($this->order));
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->whereNotNull('email_verified_at')->get();
        try {
            Mail::send(new UserPurchasedPlanMail($admins, $this->order, $this->user));
            Mail::to('Kiusk.ca@yahoo.com')->queue(new PaidUserMail($this->user, $this->order->total_price, __("Plan"), $this->order));
        } catch (Swift_TransportException $exception) {
            Log::error('Error sending email: ' . $exception->getMessage());
        }

    }
}
