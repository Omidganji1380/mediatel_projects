<?php

namespace App\Http\Livewire\Front\Panel\User\Dashboard;

use App\Charts\MonthlyChart;
use App\Charts\UserSummery;
use App\Charts\WeeklyChart;
use App\Models\Ad\Ad;
use App\Models\LinkClick;
use App\Models\Promotion;
use App\Models\ServiceUsage;
use App\Models\User;
use App\Repositories\UserReportRepository;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $data;

    public function render()
    {
        $this->data = $this->getUserSummeries();
        $chart = $this->getUserSummeryChart();
        $reportSummery = $this->reportSummery();
        $promotions = Promotion::active()->orderByDesc('updated_at')->get()->chunk(4);
        return view('livewire.front.panel.user.dashboard.index', [
            'chart' => $chart,
            'reportSummery' => $reportSummery,
            'promotions' => $promotions,
        ]);
    }

    public function getUserSummeries() : array
    {
        $user = Auth::user();
        $adsView = $user->ads()->sum('views');

        $adsComments = $user->ads()
                ->join('ad_reviews', 'ads.id', '=', 'ad_reviews.ad_id')
                ->where('ad_reviews.is_visible', true)
                ->count();

        $scores = $user->scores()->where('spent', false)->where('claimed', true)->sum('score');
        $clickCount = LinkClick::whereIn('clickable_id', $user->ads()->pluck('id'))
            ->where('clickable_type', Ad::class)
            ->sum('click_count');
        $serviceUsagesConfirmed = ServiceUsage::whereIn('ad_id', $user->ads()->pluck('id'))->where('is_confirmed', true)->count();
        return [
            'totalAdsView' => $adsView ?? 0,
            'totalClaimedScores' => $scores ?? 0,
            'totalAdsComments' => $adsComments ?? 0,
            'totalClicks' => $clickCount ?? 0,
            'serviceUsagesConfirmed' => $serviceUsagesConfirmed ?? 0,
        ];
    }

    public function getUserSummeryChart()
    {
        $chart = new UserSummery;
        $chart->labels([
            __('Total Ads View'),
            __('Total Comments'),
            __('Total Scores'),
            __('Total Service Used'),
        ]);
        $data = $this->getUserSummeries();
        $totalAdsView = (int)$data['totalAdsView'];
        $totalClaimedScores = (int)$data['totalClaimedScores'];
        $totalAdsComments = (int)$data['totalAdsComments'];
        $totalClicks = (int)$data['totalClicks'];
        $serviceUsagesConfirmed = (int)$data['serviceUsagesConfirmed'];
        $dataset = $chart->dataset(__('Ads Summary'), 'bar', [$totalAdsView, $totalAdsComments, $totalClaimedScores, $serviceUsagesConfirmed]);
        $dataset->backgroundColor(collect(['#7158e2','#3ae374', '#ff3838', '#ffc107']));
        $dataset->color(collect(['#7d5fff','#32ff7e', '#ff4d4d', '#ffc107']));
        return $chart;
    }

    public function reportSummery()
    {
        $reportRepository = new UserReportRepository();
        $chart = new WeeklyChart;
        $userId = Auth::id();
        $userReport = $reportRepository->generateReport($userId);

        $chart->labels([
            __('Link Clicks'),
            __('Ad Reviews'),
            __('Service Used'),
            __('Messages'),
            __('Claimed Scores'),
            __('Not Claimed Scores'),
            __('Spent Scores'),
        ]);

        // Access the report data
        $linkClicksWeeklyCount = $userReport['linkClicksWeeklyCount'];
        $reviewsVisibleWeeklyCount = $userReport['reviewsVisibleWeeklyCount'];
        $serviceUsagesConfirmedWeeklyCount = $userReport['serviceUsagesConfirmedWeeklyCount'];
        $messagesWeeklyCount = $userReport['messagesWeeklyCount'];
        $claimedScoresWeeklyCount = $userReport['claimedScoresWeeklyCount'];
        $NotclaimedScoresWeeklyCount = $userReport['NotclaimedScoresWeeklyCount'];
        $spentScoresWeeklyCount = $userReport['spentScoresWeeklyCount'];

        // Monthly
        $linkClicksMonthlyCount = $userReport['linkClicksMonthlyCount'];
        $reviewsVisibleMonthlyCount = $userReport['reviewsVisibleMonthlyCount'];
        $serviceUsagesConfirmedMonthlyCount = $userReport['serviceUsagesConfirmedMonthlyCount'];
        $messagesMonthlyCount = $userReport['messagesMonthlyCount'];
        $claimedScoresMonthlyCount = $userReport['claimedScoresMonthlyCount'];
        $NotclaimedScoresMonthlyCount = $userReport['NotclaimedScoresMonthlyCount'];
        $spentScoresMonthlyCount = $userReport['spentScoresMonthlyCount'];

        $dataset = $chart->dataset(__('Weekly Reports'), 'bar', [
            $linkClicksWeeklyCount,
            $reviewsVisibleWeeklyCount,
            $serviceUsagesConfirmedWeeklyCount,
            $messagesWeeklyCount,
            $claimedScoresWeeklyCount,
            $NotclaimedScoresWeeklyCount,
            $spentScoresWeeklyCount,
        ]);

        $dataset2 = $chart->dataset(__('Monthly Reports'), 'bar', [
            $linkClicksMonthlyCount,
            $reviewsVisibleMonthlyCount,
            $serviceUsagesConfirmedMonthlyCount,
            $messagesMonthlyCount,
            $claimedScoresMonthlyCount,
            $NotclaimedScoresMonthlyCount,
            $spentScoresMonthlyCount,
        ]);

        $colors = [
            '#FFD700', // Bright Yellow
            '#FFA500', // Vibrant Orange
            '#FF69B4', // Lively Pink
            '#00FF00', // Cheerful Green
            '#FFFF00', // Sunny Yellow
            '#800080', // Playful Purple
            '#00BFFF', // Blissful Blue
        ];

        $oppositeColors = [
            '#444444', // Bright Yellow -> Medium Gray
            '#444444', // Vibrant Orange -> Medium Gray
            '#66CCCC', // Lively Pink -> Medium Aqua
            '#CC4444', // Cheerful Green -> Medium Red
            '#444444', // Sunny Yellow -> Medium Gray
            '#CCCC33', // Playful Purple -> Medium Yellow
            '#CC4444', // Blissful Blue -> Medium Red
        ];
        $dataset->backgroundColor(collect($colors));
        $dataset->color(collect($colors));
        $dataset2->backgroundColor(collect($oppositeColors));
        $dataset2->color(collect($oppositeColors));
        return $chart;
    }
}
