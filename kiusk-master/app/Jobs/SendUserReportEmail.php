<?php

namespace App\Jobs;


use App\Mail\User\ReportMail;
use App\Models\Ad\Ad;
use App\Models\Ad\Review;
use App\Models\Score;
use App\Models\ServiceUsage;
use App\Models\User;
use App\Models\ChMessage as Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Swift_TransportException;
use Telegram\Bot\Api;
use Telegram\Bot\FileUpload\InputFile;

class SendUserReportEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;
        // Initialize the counters
        $linkClicksWeeklyCount = 0;
        $linkClicksMonthlyCount = 0;
        $reviewsVisibleWeeklyCount = 0;
        $reviewsVisibleMonthlyCount = 0;
        $serviceUsagesConfirmedWeeklyCount = 0;
        $serviceUsagesConfirmedMonthlyCount = 0;
        $messagesWeeklyCount = 0;
        $messagesMonthlyCount = 0;
        $claimedScoresWeeklySum = 0;
        $claimedScoresMonthlySum = 0;
        $unclaimedScoresWeeklySum = 0;
        $unclaimedScoresMonthlySum = 0;
        $spentScoresWeeklySum = 0;
        $spentScoresMonthlySum = 0;

        // Retrieve the user's ads
        $ads = Ad::where('user_id', $user->id)->get();

        // Calculate the counts for each metric
        foreach ($ads as $ad) {
            // Link Clicks
            $linkClicksWeeklyCount += $ad->click_count;
            $linkClicksMonthlyCount += $ad->click_count;

            // Reviews (Visible)
            $reviewsVisible = Review::where('ad_id', $ad->id)->where('is_visible', true)->count();
            $reviewsVisibleWeeklyCount += $reviewsVisible;
            $reviewsVisibleMonthlyCount += $reviewsVisible;

            // Service Usages (Confirmed)
            $serviceUsagesConfirmed = ServiceUsage::where('ad_id', $ad->id)->where('is_confirmed', true)->count();
            $serviceUsagesConfirmedWeeklyCount += $serviceUsagesConfirmed;
            $serviceUsagesConfirmedMonthlyCount += $serviceUsagesConfirmed;
        }

        // Messages
        $messagesWeeklyCount = Message::where('to_id', $user->id)->where('seen', false)->whereBetween('created_at', [now()->subWeek(), now()])->count();
        $messagesMonthlyCount = Message::where('to_id', $user->id)->where('seen', false)->whereBetween('created_at', [now()->subMonth(), now()])->count();

        // Scores
        $claimedScoresWeeklySum = Score::where('user_id', $user->id)->where('claimed', true)->whereBetween('created_at', [now()->subWeek(), now()])->sum('score');
        $claimedScoresMonthlySum = Score::where('user_id', $user->id)->where('claimed', true)->whereBetween('created_at', [now()->subMonth(), now()])->sum('score');
        $unclaimedScoresWeeklySum = Score::where('user_id', $user->id)->where('claimed', false)->whereBetween('created_at', [now()->subWeek(), now()])->sum('score');
        $unclaimedScoresMonthlySum = Score::where('user_id', $user->id)->where('claimed', false)->whereBetween('created_at', [now()->subMonth(), now()])->sum('score');
        $spentScoresWeeklySum = Score::where('user_id', $user->id)->where('spent', true)->whereBetween('created_at', [now()->subWeek(), now()])->sum('score');
        $spentScoresMonthlySum = Score::where('user_id', $user->id)->where('spent', true)->whereBetween('created_at', [now()->subMonth(), now()])->sum('score');


        // Compose the email content
        // $emailContent = "Subject: Weekly and Monthly Report for Your Activity\n\n";
        // $emailContent .= "Dear " . $user->full_name . ",\n\n";
        // $emailContent .= "We would like to provide you with a comprehensive report of your activity for the past week and month. Below you will find the details of each metric we have tracked:\n\n";
        // $emailContent .= "1. Ads Link Clicks:\n";
        // $emailContent .= "- Weekly count: " . $linkClicksWeeklyCount . "\n";
        // $emailContent .= "- Monthly count: " . $linkClicksMonthlyCount . "\n\n";
        // $emailContent .= "2. Ads Reviews:\n";
        // $emailContent .= "- Weekly count: " . $reviewsVisibleWeeklyCount . "\n";
        // $emailContent .= "- Monthly count: " . $reviewsVisibleMonthlyCount . "\n\n";
        // $emailContent .= "3. Ads Service Usages:\n";
        // $emailContent .= "- Weekly count: " . $serviceUsagesConfirmedWeeklyCount . "\n";
        // $emailContent .= "- Monthly count: " . $serviceUsagesConfirmedMonthlyCount . "\n\n";
        // $emailContent .= "4. Messages:\n";
        // $emailContent .= "- Weekly count: " . $messagesWeeklyCount . "\n";
        // $emailContent .= "- Monthly count: " . $messagesMonthlyCount . "\n\n";
        // $emailContent .= "5. Scores (Claimed):\n";
        // $emailContent .= "- Weekly: " . $claimedScoresWeeklySum . "\n";
        // $emailContent .= "- Monthly: " . $claimedScoresMonthlySum . "\n\n";
        // $emailContent .= "6. Scores (Unclaimed):\n";
        // $emailContent .= "- Weekly: " . $unclaimedScoresWeeklySum . "\n";
        // $emailContent .= "- Monthly: " . $unclaimedScoresMonthlySum . "\n\n";
        // $emailContent .= "7. Scores (Spent):\n";
        // $emailContent .= "- Weekly: " . $spentScoresWeeklySum . "\n";
        // $emailContent .= "- Monthly: " . $spentScoresMonthlySum . "\n\n";
        // $emailContent .= "Thank you for your continued support.\n\n";
        // $emailContent .= "Best regards,\n";
        // $emailContent .= "Kiusk Team";

        $emailContent = __("emails.messages.report_body",[
            'linkClicksWeeklyCount' => $linkClicksWeeklyCount,
            'linkClicksMonthlyCount' => $linkClicksMonthlyCount,
            'reviewsVisibleWeeklyCount' => $reviewsVisibleWeeklyCount,
            'reviewsVisibleMonthlyCount' => $reviewsVisibleMonthlyCount,
            'serviceUsagesConfirmedWeeklyCount' => $serviceUsagesConfirmedWeeklyCount,
            'serviceUsagesConfirmedMonthlyCount' => $serviceUsagesConfirmedMonthlyCount,
            'messagesWeeklyCount' => $messagesWeeklyCount,
            'messagesMonthlyCount' => $messagesMonthlyCount,
            'claimedScoresWeeklySum' => $claimedScoresWeeklySum,
            'claimedScoresMonthlySum' => $claimedScoresMonthlySum,
            'unclaimedScoresWeeklySum' => $unclaimedScoresWeeklySum,
            'unclaimedScoresMonthlySum' => $unclaimedScoresMonthlySum,
            'spentScoresWeeklySum' => $spentScoresWeeklySum,
            'spentScoresMonthlySum' => $spentScoresMonthlySum,
        ]);

        // Send the email
        // Assuming you have a mail sending service set up in Laravel, use the appropriate method to send the email
        // For example, if you're using Laravel's Mail facade:
        // Mail::raw($emailContent, function ($message) use ($user) {
        //     $message->to($user->email)->subject('Weekly and Monthly Report for Your Activity');
        // });

        try {
            Mail::to($user->email)->send(new ReportMail($user, $emailContent));
        } catch (Swift_TransportException $exception) {
            Log::error('Error sending email: ' . $exception->getMessage());
        }



        if($user->telegram_id){
            $t = new Api(st()->botApiToken);
            $t->sendMessage([
                'chat_id' => $user->telegram_id,
                'text' => $emailContent,
                'parse_mode' => 'HTML'
            ]);
        }
    }
}
