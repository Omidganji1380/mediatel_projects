<?php

namespace App\Strategies;

use App\Interfaces\MetricCalculationStrategy;
use App\Models\ChMessage as Message;
use App\Models\Score;
use Carbon\Carbon;

class ClaimedScoreMetricStrategy implements MetricCalculationStrategy
{
    /**
     * Calculate weekly count of scores
     *
     * @param int $context
     * @return integer
     */
    public function calculateWeeklyCount($context = null): int
    {
        // $context can be used to pass any required data related to the metric calculation
        $userId = $context;
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();

        return Score::where('user_id', $userId)
            ->where('claimed', true)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('score');
    }

    /**
     * Calculate monthly count of scores
     *
     * @param int $context
     * @return integer
     */
    public function calculateMonthlyCount($context = null): int
    {
        $userId = $context;
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        return Score::where('user_id', $userId)
            ->where('claimed', true)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('score');
    }
}
