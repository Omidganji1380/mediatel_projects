<?php

namespace App\Jobs;

use App\Models\TelegramAd;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExpireTelegramAdSubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $telegramAd;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TelegramAd $telegramAd)
    {
        $this->telegramAd = $telegramAd;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->telegramAd->update(['is_paid' => false]);
    }
}
