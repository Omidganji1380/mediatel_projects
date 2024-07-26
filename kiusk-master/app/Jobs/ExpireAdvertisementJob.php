<?php

namespace App\Jobs;

use App\Models\Advertisement;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExpireAdvertisementJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $advertisement;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Advertisement $advertisement)
    {
        $this->advertisement = $advertisement;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $extra = $this->advertisement->extra ?? [];
        $extra['expired_at'] = Carbon::now()->toDateString();

        $this->advertisement->update([
            'active' => false,
            'extra' => $extra
        ]);
    }
}
