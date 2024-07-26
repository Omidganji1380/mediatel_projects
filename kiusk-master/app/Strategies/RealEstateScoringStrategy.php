<?php

namespace App\Strategies;

use App\Interfaces\ScoringStrategy;
use App\Models\User;

class RealEstateScoringStrategy implements ScoringStrategy
{
    public function calculateScore($type): int
    {
        switch ($type) {
            case 'comment':
                return s()->scores['real_estate']['comment'] ?? 2;
                break;
            case 'review':
                return s()->scores['real_estate']['review'] ?? 2;
                break;
            case 'rate':
                return s()->scores['real_estate']['rate'] ?? 2;
                break;
            case 'referral':
                return s()->scores['real_estate']['referral'] ?? 6;
                break;
            case 'complete_registration':
                return s()->scores['real_estate']['complete_registration'] ?? 2;
                break;
            case 'google_review':
                return s()->scores['real_estate']['google_review'] ?? 10;
                break;
            case 'send_video':
                return s()->scores['real_estate']['send_video'] ?? 15;
                break;
            case 'service_usage':
                return s()->scores['real_estate']['service_usage'] ?? 25;
                break;

            default:
                return 1;
                break;
        }
    }
}
