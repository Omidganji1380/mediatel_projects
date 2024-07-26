<?php

namespace App\Console\Commands;

use App\Jobs\SubscriptionWarningMailJob;
use App\Mail\SubscriptionWarningEmailOneDay;
use App\Mail\SubscriptionWarningEmailThreeDays;
use App\Mail\SubscriptionWarningEmailTwoDays;
use App\Models\Ad\Ad;
use App\Models\Shop\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendSubscriptionWarningEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:subscription-warnings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send subscription expiration warning emails to users whose subscriptions are expiring soon.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get all completed orders with subscription end date and ad info
        $today = Carbon::parse('2023-08-15');
        $ads = Ad::where(function($query){
                $query->where('is_featured', 1)
                    ->orWhere('is_sidebar_featured', 1)
                    ->orWhere('is_suggestion_featured', 1);
            })->whereDate('created_at', '>', $today)
            ->whereNotNull('subscription_end_date')
            ->get();

        foreach ($ads as $ad) {
            $user = $ad->user;
            $expirationDate = Carbon::parse($ad->subscription_end_date);
            $currentDate = Carbon::now();

            $daysUntilExpiration = $currentDate->diffInDays($expirationDate, false);

            if ($daysUntilExpiration === 3 || $daysUntilExpiration === 2 || $daysUntilExpiration === 1) {

                $message = __('emails.messages.subscription_warnings',[
                    'daysUntil' => $expirationDate->format('Y-m-d'),
                    'expirationDate' => $daysUntilExpiration
                ]);

                $mailClass = null;
                if ($daysUntilExpiration === 3) {
                    $mailClass = new SubscriptionWarningEmailThreeDays($user, $message);
                } else if ($daysUntilExpiration === 2) {
                    $mailClass = new SubscriptionWarningEmailTwoDays($user, $message);
                } else if ($daysUntilExpiration === 1) {
                    $mailClass = new SubscriptionWarningEmailOneDay($user, $message);
                }

                if ($mailClass) {
                    SubscriptionWarningMailJob::dispatch($user, $mailClass);
                }
            }
        }
    }
}
