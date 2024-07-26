<?php

namespace App\Http\Livewire\Front\Panel\User;

use Livewire\Component;

class PanelLogout extends Component
{
 public function logout()
 {
  auth()->logout();
  $this->dispatchBrowserEvent('swal:modal', [
   'icon' => 'success',
   'title' => 'با موفقیت خارج شدید.',
   'timerProgressBar' => true,
   'timer' => 1000,
   'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> متوجه شدم',
   'width' => 300
  ]);
  return redirect()
   ->route('front.home')
   ->with('success', 'با موفقیت خارج شدید.');
 }

 public function render()
 {
  return view('livewire.front.panel.user.panel-logout');
 }
}