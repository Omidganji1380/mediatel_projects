<?php

namespace App\Http\Livewire\Front\Panel\User\Plans;

use App\Jobs\ExpireSubscriptionJob;
use App\Models\Cart;
use App\Models\Plan;
use App\Traits\Helper;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VipPlans extends Component
{
    use Helper;

    public $plans;
    public $yearly = 0;

    public function mount()
    {
        $this->plans = Plan::where('type', 'premium')
                            ->where('vip', true)
                            ->isActive()
                            ->get();
    }

    public function render()
    {
        $yearlyPlans = Plan::where('type', 'premium')
            ->where('invoice_interval', 'year')
            ->where('vip', true)
            ->isActive()
            ->orderBy('position')
            ->get();
        $monthlyPlans = Plan::where('type', 'premium')
            ->where('invoice_interval', 'month')
            ->where('vip', true)
            ->isActive()
            ->orderBy('position')
            ->get();
        return view('livewire.front.panel.user.plans.vip-plans', compact('yearlyPlans', 'monthlyPlans'));
    }

    public function addToCart($plan_slug)
    {
        $plan = Plan::where('slug', $plan_slug)->firstOrFail();
        // $this->subscribeToPlan($plan);

        $lang = App::isLocale('en') ? "en." : "";

        $description = $this->makeDescription($plan);
        $totalPrice = $this->calculateTotalPriceWithTax($plan->price, $plan->tax);
        $cart = Cart::updateOrCreate(['user_id' => Auth::id()],
            [
                'plan_id' => $plan->id,
                'title' => $plan->name,
                'price' => $plan->price,
                'tax' => $plan->tax ?: 13,
                'total_price' => $totalPrice,
                'invoice_period' => $plan->invoice_period,
                'invoice_interval' => $plan->invoice_interval,
                'description' => $description,
            ]);
        return redirect()->to(route($lang . 'front.user.cart.index'));
    }
}
