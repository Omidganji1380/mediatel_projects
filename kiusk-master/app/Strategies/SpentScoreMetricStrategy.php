<?php

namespace App\Strategies;

use App\Interfaces\MetricCalculationStrategy;
use App\Models\ChMessage as Message;
use App\Models\Score;
use Carbon\Carbon;

class SpentScoreMetricStrategy implements MetricCalculationStrategy
{
    public function calculateWeeklyCount($context = null): int
    {
        // $context can be used to pass any required data related to the metric calculation
        $userId = $context;
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();

        return Score::where('user_id', $userId)
            ->where('claimed', true)
            ->where('spent', true)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('score');
    }

    public function calculateMonthlyCount($context = null): int
    {
        $userId = $context;
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        return Score::where('user_id', $userId)
            ->where('claimed', true)
            ->where('spent', true)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('score');
    }
}
