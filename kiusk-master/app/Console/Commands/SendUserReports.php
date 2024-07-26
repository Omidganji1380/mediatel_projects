<?php

namespace App\Console\Commands;

use App\Jobs\SendUserReportEmail;
use App\Models\Ad\Ad;
use App\Models\Ad\Review;
use App\Models\Score;
use App\Models\ServiceUsage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendUserReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send weekly and monthly reports to users.';

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
        // Retrieve the users from the database
        // Must create is_active user
        $today = Carbon::parse('2023-08-15');
        $users = User::whereHas('ads', function ($query) use ($today) {
                return $query->whereDate('created_at', '>', $today);
            })->whereNotNull('email')
            ->where('email', 'not like', '%@telegram.telegram%')
            // ->whereDate('created_at', '>', $today)
            ->whereNotNull('email_verified_at')
            ->isActive()
            ->get();

        // $users = User::whereNotNull('email')->where('email', 'memoney026@gmail.com')->get();
        // Generate the report for each user
        foreach ($users as $user) {
            SendUserReportEmail::dispatch($user);
        }
    }
}
