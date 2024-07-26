<?php

namespace App\Http\Livewire\Front\Advertisement;

use App\Models\AdCart as ModelsAdCart;
use Livewire\Component;

class AdCart extends Component
{
    public $cart;
    public $acceptRules = false;
    public $preview = false;

    public function render()
    {
        return view('livewire.front.advertisement.ad-cart');
    }

    public function toggleCheckbox()
    {
        // $this->acceptRules = !$this->acceptRules;
        $this->emit('scriptsReloaded');
    }

    public function preview()
    {
        $this->preview = true;
    }

    public function backToCart(){
        $this->preview = false;
    }

    public function deleteItem($cartId)
    {
        ModelsAdCart::find($cartId)->delete();
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => __('messages.destroy', ['name' => '']),
            'timerProgressBar' => true,
            'timer' => 20000,
            'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
            'width' => 300,
           ]);
        return redirect()->to(route('front.advertisement.index'));
    }
}
