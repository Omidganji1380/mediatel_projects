<?php

namespace App\Jobs;

use App\Mail\Admins\DailyReportMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Swift_TransportException;

class AdminDailyReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $mailClass;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mailClass)
    {
        $this->mailClass = $mailClass;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $adminEmail = 'Kiusk.ca@yahoo.com';

        try {
            Mail::to($adminEmail)->send($this->mailClass);
        } catch (Swift_TransportException $exception) {
            Log::error('Error sending email: ' . $exception->getMessage());
        }

    }
}
