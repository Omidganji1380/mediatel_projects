<?php

namespace App\Interfaces;

use App\Models\User;

interface ScoringStrategy
{
    public function calculateScore(string $type): int;
}
