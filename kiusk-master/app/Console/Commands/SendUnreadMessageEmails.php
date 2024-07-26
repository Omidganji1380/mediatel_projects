<?php

namespace App\Console\Commands;

use App\Jobs\ProcessUnreadMessages;
use App\Mail\UnreadMessageNotification;
use App\Models\ChMessage;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendUnreadMessageEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-unread-messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notifications for unread messages';

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
        dispatch(new ProcessUnreadMessages());
    }
}
