<?php

namespace App\Strategies;

use App\Interfaces\MetricCalculationStrategy;
use App\Models\ChMessage as Message;
use Carbon\Carbon;

class MessageMetricStrategy implements MetricCalculationStrategy
{
    public function calculateWeeklyCount($context = null): int
    {
        // $context can be used to pass any required data related to the metric calculation
        // In this case, you can pass the user ID or any other relevant information

        // Example implementation:
        $userId = $context;
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();

        return Message::where('to_id', $userId)
            ->where('seen', false)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
    }

    public function calculateMonthlyCount($context = null): int
    {
        // Example implementation:
        $userId = $context;
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        return Message::where('to_id', $userId)
            ->where('seen', false)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
    }
}
