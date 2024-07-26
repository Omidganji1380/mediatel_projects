<?php

namespace App\Strategies;

use App\Interfaces\MetricCalculationStrategy;
use App\Models\Ad\Ad;
use App\Models\ServiceUsage;

class ServiceUsagesConfirmedMetricStrategy implements MetricCalculationStrategy
{
    public function calculateWeeklyCount($context = null): int
    {
        $ad = $context;
        return ServiceUsage::where('ad_id', $ad->id)->where('is_confirmed', true)->count();
    }

    public function calculateMonthlyCount($context = null): int
    {
        $ad = $context;
        return ServiceUsage::where('ad_id', $ad->id)->where('is_confirmed', true)->count();
    }
}
