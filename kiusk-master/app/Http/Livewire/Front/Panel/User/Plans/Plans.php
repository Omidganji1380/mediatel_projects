<?php

namespace App\Http\Livewire\Front\Panel\User\Plans;

use App\Models\Cart;
use App\Models\Plan;
use App\Traits\Helper;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Plans extends Component
{
    use Helper;
    public $ad;
    public $modelType;
    public $yearly = 0;

    public function mount()
    {
        $this->modelType = request('model_type') ?? '';
    }

    public function render()
    {

        $yearlyPlans = Plan::where('type', 'premium')
            ->where('invoice_interval', 'year')
            ->where('vip', false)
            ->where('model_type', $this->modelType)
            ->isActive()
            ->orderBy('position')
            ->get();
        $monthlyPlans = Plan::where('type', 'premium')
            ->where('invoice_interval', 'month')
            ->where('vip', false)
            ->where('model_type', $this->modelType)
            ->isActive()
            ->orderBy('position')
            ->get();
        $plans = Plan::where('type', 'premium')
            ->where('model_type', $this->modelType)
            ->isActive()
            ->orderBy('position')
            ->get();
        return view('livewire.front.panel.user.plans.plans', compact('yearlyPlans', 'monthlyPlans'));
    }

    public function addToCart($plan_slug)
    {
        $plan = Plan::where('slug', $plan_slug)->firstOrFail();
        $lang = App::isLocale('en') ? "en." : "";

        // $this->testCreate($plan->id, $this->ad->id);

        $description = $this->makeDescription($plan);

        $totalPrice = $this->calculateTotalPriceWithTax($plan->price, $plan->tax);

        $cart = Cart::updateOrCreate(
            [
                'plan_id' => $plan->id,
                'user_id' => Auth::id()
            ],
            [
                'ad_id' => $this->ad instanceof \App\Models\Ad\Ad ? $this->ad->id : null,
                'model_type' => get_class($this->ad),
                'model_id' => $this->ad?->id,
                'title' => $plan->title,
                'price' => $plan->price,
                'tax' => $plan->tax ?: 13,
                'total_price' => $totalPrice,
                'invoice_period' => $plan->invoice_period,
                'invoice_interval' => $plan->invoice_interval,
                'description' => $plan->description,
            ]
        );
        return redirect()->to(route($lang . 'front.user.cart.index'));
    }

    public function makeDescription($plan)
    {
        $description = "";
        if (!$plan->pin_ad) {
            $description = __('messages.cart_description', [
                'show_in_main_page' => $plan->show_in_main_page ? __('main page') : '',
                'show_in_suggestion' => $plan->show_in_suggestion ? __(', suggestion bar in ads page') : '',
                'show_in_sidebar' => $plan->show_in_sidebar ? __('and sidebar in ads page') : '',
            ]);
        }
        if ($plan->vip) {
            $description .= "\n" . __('messages.cart_description_pin');
        }
        if (!$plan->vip && $plan->pin_ad) {
            $description = __('messages.cart_description_pin');
        }
        return $description;
    }
}
