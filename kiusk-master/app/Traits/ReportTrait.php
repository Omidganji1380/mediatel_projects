<?php

namespace App\Traits;

use App\Models\Ad\Ad;
use App\Models\AdvertisementOrder;
use App\Models\Shop\Order;
use App\Models\User;

trait ReportTrait
{
    /**
     * Users Count
     *
     * @return int
     */
    public function usersCount($start, $end)
    {
        return User::whereBetween('created_at', [
            $start,
            $end,
        ])
        ->where('email', 'not like', '%@telegram.telegram')
        ->count();
    }

    public function adsCount($start, $end)
    {
        return Ad::whereBetween('created_at', [
            $start,
            $end,
        ])->count();
    }

    public function ordersTotalPrice($start, $end)
    {
        return Order::where('order_status', 'COMPLETED')
        ->whereBetween('created_at', [
            $start,
            $end,
        ])->sum('total_price');

    }

    public function adOrdersTotalPrice($start, $end)
    {
        return AdvertisementOrder::currentStatus('payment_completed')
        ->whereBetween('created_at', [
            $start,
            $end,
        ])->sum('total_price');
    }
}
