<?php

namespace App\Interfaces;

use App\Models\Ad\Ad;

interface MetricCalculationStrategy
{
    public function calculateWeeklyCount($context = null): int;
    public function calculateMonthlyCount($context = null): int;
}
