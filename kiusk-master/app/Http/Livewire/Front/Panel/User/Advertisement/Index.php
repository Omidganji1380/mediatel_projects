<?php

namespace App\Http\Livewire\Front\Panel\User\Advertisement;

use App\Models\AdvertisementOrder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public AdvertisementOrder $advertisementOrders;

    public function mount()
    {
        // $this->advertisementOrders = ;
    }

    public function pay($adOrderId)
    {
        dd($adOrderId);
    }

    public function render()
    {
        return view('livewire.front.panel.user.advertisement.index');
    }
}
