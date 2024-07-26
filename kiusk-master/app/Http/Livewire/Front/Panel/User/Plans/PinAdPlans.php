<?php

namespace App\Http\Livewire\Front\Panel\User\Plans;

use App\Models\Ad\Ad;
use App\Models\Cart;
use App\Models\Plan;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PinAdPlans extends Component
{
    public $plans;
    public Ad $ad;

    public function mount()
    {
        $this->plans = Plan::where('type', 'premium')
                            ->where('pin_ad', true)
                            ->isActive()
                            ->get();
    }

    public function render()
    {
        return view('livewire.front.panel.user.plans.pin-ad-plans');
    }

    public function addToCart($plan_slug)
    {
        $plan = Plan::where('slug', $plan_slug)->firstOrFail();
        $description = $this->makeDescription($plan);
        $cart = Cart::updateOrCreate(['user_id' => Auth::id()],
            [
                'plan_id' => $plan->id,
                'ad_id' => $this->ad->id,
                'title' => $plan->name,
                'price' => $plan->price,
                'invoice_period' => $plan->invoice_period,
                'invoice_interval' => $plan->invoice_interval,
                'description' => $description,
            ]);
        return redirect()->to(route('front.user.cart.index'));
    }

    public function makeDescription($plan)
    {
        $description = "";
        if(!$plan->pin_ad){
            $description = __('messages.cart_description', [
                'show_in_main_page' => $plan->show_in_main_page ? __('main page') : '',
                'show_in_suggestion' => $plan->show_in_suggestion ? __(', suggestion bar in ads page') : '',
                'show_in_sidebar' => $plan->show_in_sidebar ? __('and sidebar in ads page') : '',
            ]);
        }
        if($plan->vip){
            $description .= "\n" . __('messages.cart_description_pin');
        }
        if(!$plan->vip && $plan->pin_ad){
            $description = __('messages.cart_description_pin');
        }
        return $description;
    }
}
