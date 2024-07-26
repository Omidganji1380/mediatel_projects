<?php

namespace App\Console\Commands;

use App\Jobs\DailyReportJob;
use App\Models\Score;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class GenerateDailyReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate daily report of views and comments for ads.';

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
        // $users = User::all();
        $today = Carbon::parse('2023-08-15');
        $users = User::whereHas('ads', function ($query) use ($today) {
                return $query->whereDate('created_at', '>', $today);
            })->whereNotNull('email')
            ->where('email', 'not like', '%@telegram.telegram%')
            ->whereNotNull('email_verified_at')
            ->isActive()
            ->get();
        // $users = User::whereNotNull('email')->where('email', 'memoney026@gmail.com')->get();
        $date = Carbon::now()->subDay();

        foreach ($users as $user) {
            $ads = $user->ads;
            $adViews = 0;
            $adComments = 0;

            foreach ($ads as $ad) {
                $adViews += $ad->views;
                $adComments += $ad->reviews()->whereDate('created_at', $date)->count();
            }

            // Scores
            $claimedScoresSum = Score::where('user_id', $user->id)->where('claimed', true)->sum('score');
            $unclaimedScoresSum = Score::where('user_id', $user->id)->where('claimed', false)->sum('score');
            $spentScoresSum = Score::where('user_id', $user->id)->where('spent', true)->sum('score');

            $content = __('emails.messages.daily_content',[
                'adViews' => $adViews,
                'adComments' => $adComments,
                'claimedScoresSum' => $claimedScoresSum,
                'unclaimedScoresSum' => $unclaimedScoresSum,
                'spentScoresSum' => $spentScoresSum,
            ]);

            DailyReportJob::dispatch($user, $content);
        }
    }
}
