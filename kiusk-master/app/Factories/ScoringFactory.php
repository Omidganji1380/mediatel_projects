<?php

namespace App\Factories;

use App\Interfaces\ScoringStrategy;
use App\Strategies\BusinessOwnerScoringStrategy;
use App\Strategies\CustomerScoringStrategy;
use App\Strategies\RealEstateScoringStrategy;
use App\Strategies\SellerScoringStrategy;
use App\Strategies\VipScoringStrategy;
use InvalidArgumentException;

class ScoringFactory
{
    public static function createScorerForUserType(string $userRole, string $type): ScoringStrategy
    {
        switch ($userRole) {
            case 'customer':
                return new CustomerScoringStrategy($type);
            case 'real_estate':
                return new RealEstateScoringStrategy($type);
            case 'seller':
                return new SellerScoringStrategy($type);
            case 'business_owner':
                return new BusinessOwnerScoringStrategy($type);
            case 'vip':
                return new VipScoringStrategy($type);
            case 'admin':
                return new VipScoringStrategy($type);
            case 'super_admin':
                return new VipScoringStrategy($type);
            case 'author':
                return new VipScoringStrategy($type);
            case 'seo':
                return new VipScoringStrategy($type);
            default:
                throw new InvalidArgumentException('Invalid user type');
        }
    }
}
