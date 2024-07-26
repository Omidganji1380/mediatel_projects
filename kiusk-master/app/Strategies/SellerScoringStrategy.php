<?php

namespace App\Strategies;

use App\Interfaces\ScoringStrategy;
use App\Models\User;

class SellerScoringStrategy implements ScoringStrategy
{
    public function calculateScore($type): int
    {
        switch ($type) {
            case 'comment':
                return s()->scores['seller']['comment'] ?? 2;
                break;
            case 'review':
                return s()->scores['seller']['review'] ?? 2;
                break;
            case 'rate':
                return s()->scores['seller']['rate'] ?? 2;
                break;
            case 'referral':
                return s()->scores['seller']['referral'] ?? 6;
                break;
            case 'complete_registration':
                return s()->scores['seller']['complete_registration'] ?? 2;
                break;
            case 'google_review':
                return s()->scores['seller']['google_review'] ?? 10;
                break;
            case 'send_video':
                return s()->scores['seller']['send_video'] ?? 15;
                break;
            case 'service_usage':
                return s()->scores['seller']['service_usage'] ?? 25;
                break;

            default:
                return 1;
                break;
        }
    }
}
