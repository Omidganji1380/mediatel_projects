<?php

namespace App\Http\Livewire\Front;

use App\Models\Cart as ModelsCart;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Cart extends Component
{
    public $lang;

    public function render()
    {
        $lang = App::isLocal('fa') ? "" : "en.";
        $cart = ModelsCart::whereBelongsTo(Auth::user())->first();
        return view('livewire.front.cart', compact('cart'));
    }

    public function deleteItem($cartId)
    {
        ModelsCart::find($cartId)->delete();
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => __('messages.destroy', ['name' => 'Item']),
            'timerProgressBar' => true,
            'timer' => 20000,
            'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
            'width' => 300,
           ]);
        return redirect()->to(route($this->lang . 'front.panel.user.ad.index'));
    }
}
