<?php

namespace App\Http\Livewire\Front\Panel\User\Scores;

use App\Charts\ScoreChart;
use App\Models\Discount;
use App\Models\ScoreCategory;
use App\Traits\Helper;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Charts;

class Index extends Component
{
    use Helper, Usage;

    public $user;
    public $registrationProgress;
    public $types;
    public $discounts;

    public function mount()
    {
        $this->registrationProgress = $this->calculateRegistrationProgress();
        $this->types = ScoreCategory::all();
        $this->discounts = Discount::whereBelongsTo(auth()->user())->latest()->get();
        // dd($this->loadUser());
        // $this->chart = $this->scoreChart($this->user);
    }

    public function loadUser()
    {
        return Auth::user()->loadSum('totalClaimedScores', 'score')
            ->loadSum('registrationScores', 'score')
            ->loadSum('totalNotClaimedScores', 'score')
            ->loadSum('totalSpentScores', 'score')
            ->loadSum('commentScores', 'score')
            ->loadSum('reviewScores', 'score')
            ->loadSum('commentReviewScores', 'score')
            ->loadSum('referralScores', 'score')
            ->loadSum('googleReviewScores', 'score')
            ->loadSum('sendVideoScores', 'score')
            ->loadSum('serviceUsageScores', 'score')
            ->loadSum('rateScores', 'score');
    }

    // public function scoreChart($user)
    // {
    //     return Charts::create('bar', 'highcharts')
    //         ->title('Scores Summary')
    //         ->elementLabel('Scores')
    //         ->labels(['Sum Score', 'Total Spent Scores', 'Total Not Claimed Scores', 'Comment Review Scores', 'Rate Scores', 'Google Review Scores', 'Send Video Scores', 'Service Usage Scores', 'Referral Scores', 'Registration Progress'])
    //         ->values([$user->scores_sum_score, $user->total_spent_scores_sum_score, $user->total_not_claimed_scores_sum_score, $user->comment_review_scores_sum_score, $user->rate_scores_sum_score, $user->google_review_scores_sum_score, $user->send_video_scores_sum_score, $user->service_usage_scores_sum_score, $user->referral_scores_sum_score, $user->registrationProgress])
    //         ->dimensions(800, 400)
    //         ->responsive(true);
    // }

    public function render()
    {
        $user = $this->user = $this->loadUser();
        $this->score = $user?->scores_sum_score ?? 0;
        $commentReviewScore = $user->comment_review_scores_sum_score ?? 0;
        $rateScore = $user->rate_scores_sum_score ?? 0;
        $googleReviewScore = $user->google_review_scores_sum_score ?? 0;
        $sendVideoScore = $user->send_video_scores_sum_score ?? 0;
        $serviceUsageScore = $user->service_usage_scores_sum_score ?? 0;
        $referralScore = $user->referral_scores_sum_score ?? 0;
        $registrationProgress = $this->registrationProgress ? 1 : 0;
        $chart = new ScoreChart;
        $chart->labels(['Comment Review Scores', 'Rate Scores', 'Google Review Scores', 'Send Video Scores', 'Service Usage Scores', 'Referral Scores', 'Registration Progress']);
        $dataset = $chart->dataset(__('Scores Summary'), 'bar', [
            $commentReviewScore,
            $rateScore,
            $googleReviewScore,
            $sendVideoScore,
            $serviceUsageScore,
            $referralScore,
            $registrationProgress,
        ]);
        $colors = ['#4c3cfa','#988efa','#0d0381','#848484','#c5b7cf','#444444'];
        $dataset->backgroundColor(collect($colors));
        $dataset->color(collect($colors));
        return view('livewire.front.panel.user.scores.index', [
            'user' => $user,
            'chart' => $chart
        ]);
    }
}
