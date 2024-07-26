<?php

namespace App\Strategies;

use App\Interfaces\ScoringStrategy;
use App\Models\User;

class VipScoringStrategy implements ScoringStrategy
{
    public function calculateScore($type): int
    {
        switch ($type) {
            case 'comment':
                return s()->scores['vip']['comment'] ?? 2;
                break;
            case 'review':
                return s()->scores['vip']['review'] ?? 2;
                break;
            case 'rate':
                return s()->scores['vip']['rate'] ?? 2;
                break;
            case 'referral':
                return s()->scores['vip']['referral'] ?? 6;
                break;
            case 'complete_registration':
                return s()->scores['vip']['complete_registration'] ?? 2;
                break;
            case 'google_review':
                return s()->scores['vip']['google_review'] ?? 10;
                break;
            case 'send_video':
                return s()->scores['vip']['send_video'] ?? 15;
                break;
            case 'service_usage':
                return s()->scores['vip']['service_usage'] ?? 25;
                break;

            default:
                return 1;
                break;
        }
    }
}
