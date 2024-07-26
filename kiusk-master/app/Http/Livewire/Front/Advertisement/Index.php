<?php

namespace App\Http\Livewire\Front\Advertisement;

use App\Models\AdvertisementType;
use Livewire\Component;

class Index extends Component
{
    public $advertisement;
    public $price;
    public $mainPrice;
    public $weeks;
    public $prices;

    protected $rules = [
        'weeks' => 'required|min:1|max:4|integer',
    ];

    public function mount()
    {
        $this->prices = AdvertisementType::PRICES;
        $this->mainPrice = $this->price = $this->prices[$this->weeks] ?? 0;
    }

    public function increment()
    {
        $this->weeks++;
        $this->validate();
        if($this->weeks > 4){
            $this->weeks = 4;
        }elseif($this->weeks < 1){
            $this->weeks = 1;
        }
        $this->price = $this->prices[$this->weeks] ?? 10;
    }
    public function decrement()
    {
        $this->weeks--;
        $this->validate();
        if($this->weeks > 4){
            $this->weeks = 4;
        }elseif($this->weeks < 1){
            $this->weeks = 1;
        }
        $this->price = $this->prices[$this->weeks] ?? 10;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        if($this->weeks > 4){
            $this->weeks = 4;
        }elseif($this->weeks < 1){
            $this->weeks = 1;
        }
        $this->price = $this->prices[$this->weeks] ?? 10;
        // dd($propertyName, $this->weeks);
    }

    public function continueToCreateOrder()
    {
        $this->validate();
        return redirect()->to(
            route('front.advertisement.create', [
                'advertisement_slug' => $this->advertisement->slug,
                'weeks' => $this->weeks
            ])
        );
    }

    public function render()
    {
        return view('livewire.front.advertisement.index');
    }
}
