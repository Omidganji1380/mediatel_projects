<?php

namespace App\Jobs;

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

class DailyReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $content;
    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, string $content)
    {
        $this->user = $user;
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Mail::to($this->user->email)->send(new \App\Mail\DailyReport($this->user , $this->content));
        } catch (Swift_TransportException $exception) {
            Log::error('Error sending email: ' . $exception->getMessage());
        }

    }
}
