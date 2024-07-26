<?php

namespace App\Repositories;

use App\Models\Ad\Ad;
use App\Models\User;
use App\Strategies\ClaimedScoreMetricStrategy;
use App\Strategies\LinkClicksMetricStrategy;
use App\Strategies\MessageMetricStrategy;
use App\Strategies\MetricCalculationStrategy;
use App\Strategies\NotClaimedScoreMetricStrategy;
use App\Strategies\ReviewsVisibleMetricStrategy;
use App\Strategies\ServiceUsagesConfirmedMetricStrategy;
use App\Strategies\SpentScoreMetricStrategy;

class UserReportRepository
{
    private $userAdMetricStrategies;
    private $userMetricStrategies;

    public function __construct()
    {
        $this->userAdMetricStrategies = [
            'linkClicks' => new LinkClicksMetricStrategy(),
            'reviewsVisible' => new ReviewsVisibleMetricStrategy(),
            'serviceUsagesConfirmed' => new ServiceUsagesConfirmedMetricStrategy(),
        ];

        $this->userMetricStrategies = [
            'messages' => new MessageMetricStrategy(),
            'claimedScores' => new ClaimedScoreMetricStrategy(),
            'NotclaimedScores' => new NotClaimedScoreMetricStrategy(),
            'spentScores' => new SpentScoreMetricStrategy(),
        ];
    }

    public function generateReport($userId)
    {
        $user = $this->getUser($userId);
        $ads = $this->getUserAds($user);

        $reportData = [];

        foreach ($this->userAdMetricStrategies as $metricName => $metricStrategy) {
            $weeklyCount = 0;
            $monthlyCount = 0;
            if ($ads->isNotEmpty() && method_exists($metricStrategy, 'calculateWeeklyCount')) {
                $weeklyCount = 0;
                foreach ($ads as $ad) {
                    $weeklyCount += $metricStrategy->calculateWeeklyCount($ad);
                }
            }

            if ($ads->isNotEmpty() && method_exists($metricStrategy, 'calculateMonthlyCount')) {
                $monthlyCount = 0;
                foreach ($ads as $ad) {
                    $monthlyCount += $metricStrategy->calculateMonthlyCount($ad);
                }
            }

            $reportData[$metricName . 'WeeklyCount'] = $weeklyCount;
            $reportData[$metricName . 'MonthlyCount'] = $monthlyCount;
        }

        foreach ($this->userMetricStrategies as $metricName => $metricStrategy) {

            $weeklyCount = $metricStrategy->calculateWeeklyCount($user->id);
            $monthlyCount = $metricStrategy->calculateMonthlyCount($user->id);

            $reportData[$metricName . 'WeeklyCount'] = $weeklyCount;
            $reportData[$metricName . 'MonthlyCount'] = $monthlyCount;
        }

        return $reportData;
    }

    private function getUser($userId)
    {
        return User::findOrFail($userId);
    }

    private function getUserAds($user)
    {
        return Ad::where('user_id', $user->id)->get();
    }

}
