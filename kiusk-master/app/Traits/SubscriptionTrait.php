<?php

namespace App\Traits;

use App\Events\PinAdEvent;
use App\Jobs\ExpireSubscriptionJob;
use App\Jobs\PurchasedPlanNotificationJob;
use App\Models\Ad\Ad;
use App\Models\Discount;
use App\Models\Plan;
use App\Models\Score;
use App\Models\Shop\Customer;
use App\Models\Shop\Order;
use App\Models\Shop\OrderItem;
use App\Models\User;
use App\Services\Plans\PlanService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait SuscriptionTrait
{

}
