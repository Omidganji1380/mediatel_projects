<?php

namespace App\Strategies;

use App\Interfaces\MetricCalculationStrategy;
use App\Models\Ad\Ad;

class LinkClicksMetricStrategy implements MetricCalculationStrategy
{
    public function calculateWeeklyCount($context = null): int
    {
        $ad = $context;
        return $ad->click_count ?? 0;
    }

    public function calculateMonthlyCount($context = null): int
    {
        $ad = $context;
        return $ad->click_count ?? 0;
    }
}
