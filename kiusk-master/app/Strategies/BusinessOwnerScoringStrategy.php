<?php

namespace App\Strategies;

use App\Interfaces\ScoringStrategy;
use App\Models\User;

class BusinessOwnerScoringStrategy implements ScoringStrategy
{
    public function calculateScore($type): int
    {
        switch ($type) {
            case 'comment':
                return s()->scores['business_owner']['comment'] ?? 2;
                break;
            case 'review':
                return s()->scores['business_owner']['review'] ?? 2;
                break;
            case 'rate':
                return s()->scores['business_owner']['rate'] ?? 2;
                break;
            case 'referral':
                return s()->scores['business_owner']['referral'] ?? 6;
                break;
            case 'complete_registration':
                return s()->scores['business_owner']['complete_registration'] ?? 2;
                break;
            case 'google_review':
                return s()->scores['business_owner']['google_review'] ?? 10;
                break;
            case 'send_video':
                return s()->scores['business_owner']['send_video'] ?? 15;
                break;
            case 'service_usage':
                return s()->scores['business_owner']['service_usage'] ?? 25;
                break;

            default:
                return 1;
                break;
        }
    }
}
