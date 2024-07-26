<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Swift_TransportException;

class SubscriptionWarningMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $mailClass;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $mailClass)
    {
        $this->user = $user;
        $this->mailClass = $mailClass;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            if($this->user->is_active){
                Mail::to($this->user->email)->send($this->mailClass);
            }else{
                Log::info('User is not active for sending email: ' . $this->user->id);
            }
        } catch (Swift_TransportException $exception) {
            Log::error('Error sending email: ' . $exception->getMessage());
        }
    }
}
