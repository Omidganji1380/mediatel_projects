<?php

namespace App\Strategies;

use App\Interfaces\ScoringStrategy;
use App\Models\User;

class CustomerScoringStrategy implements ScoringStrategy
{
    public function calculateScore($type): int
    {
        switch ($type) {
            case 'comment':
                return s()->scores['customer']['comment'] ?? 1;
                break;
            case 'review':
                return s()->scores['customer']['review'] ?? 1;
                break;
            case 'rate':
                return s()->scores['customer']['rate'] ?? 1;
                break;
            case 'referral':
                return s()->scores['customer']['referral'] ?? 6;
                break;
            case 'complete_registration':
                return s()->scores['customer']['complete_registration'] ?? 2;
                break;
            case 'google_review':
                return s()->scores['customer']['google_review'] ?? 10;
                break;
            case 'send_video':
                return s()->scores['customer']['send_video'] ?? 15;
                break;
            case 'service_usage':
                return s()->scores['customer']['service_usage'] ?? 25;
                break;

            default:
                return 1;
                break;
        }
    }
}
