<?php

namespace App\Http\Livewire\Front\Auth;

use Livewire\Component;

class Logout extends Component
{
    public function logout()
    {
        auth()->logout();
        $this->dispatchBrowserEvent('swal:modal', [
            'icon' => 'success',
            'title' => __('messages.logout'),
            'timerProgressBar' => true,
            'timer' => 1000,
            'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> ' . __('I understand'),
            'width' => 300
        ]);
        return redirect()
            ->route('front.home')
            ->with('success', __('messages.logout'));
    }

    public function render()
    {
        return view('livewire.front.auth.logout');
    }
}
