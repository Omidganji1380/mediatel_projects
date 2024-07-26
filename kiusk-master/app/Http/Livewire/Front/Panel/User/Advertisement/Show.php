<?php

namespace App\Http\Livewire\Front\Panel\User\Advertisement;

use App\Models\AdCart;
use App\Models\AdvertisementOrder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public AdvertisementOrder $advertisementOrder;

    public function pay()
    {
        if($this->advertisementOrder?->status == 'pending_payment'){
            $this->addToCart();
            return redirect()->route('front.user.ad-cart.index');
        }else{
            $this->addError('payment', __("It's not in pending payment status"));
        }
    }

    protected function addToCart()
    {
        AdCart::updateOrCreate(['user_id' => Auth::id()],
        [
            'advertisement_type_id' => $this->advertisementOrder?->advertisementType?->id,
            'advertisement_order_id' => $this->advertisementOrder->id,
            'title' => $this->advertisementOrder->advertisementType?->name,
            'price' => $this->advertisementOrder->advertisementType?->price,
            'total_price' => $this->advertisementOrder->total_price,
            'tax' => $this->advertisementOrder->tax,
            'invoice_period' => $this->advertisementOrder->advertisementType?->days,
            'description' => $this->advertisementOrder->advertisementType?->description,
        ]);
    }

    public function render()
    {
        return view('livewire.front.panel.user.advertisement.show');
    }
}
