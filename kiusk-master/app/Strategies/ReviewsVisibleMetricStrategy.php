<?php

namespace App\Strategies;

use App\Interfaces\MetricCalculationStrategy;
use App\Models\Ad\Ad;
use App\Models\Ad\Review;

class ReviewsVisibleMetricStrategy implements MetricCalculationStrategy
{
    public function calculateWeeklyCount($context = null): int
    {
        $ad = $context;
        return Review::where('ad_id', $ad->id)->where('is_visible', true)->count();
    }

    public function calculateMonthlyCount($context = null): int
    {
        $ad = $context;
        return Review::where('ad_id', $ad->id)->where('is_visible', true)->count();
    }
}
