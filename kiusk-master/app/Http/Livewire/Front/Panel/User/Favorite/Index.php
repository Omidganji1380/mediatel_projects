<?php

namespace App\Http\Livewire\Front\Panel\User\Favorite;

use App\Models\Ad\Ad;

use LaravelIdea\Helper\App\Models\Ad\_IH_Favorite_QB;
use Livewire\Component;
use Spatie\ResponseCache\Facades\ResponseCache;

class Index extends Component
{
use Favorite;
 public $ads = [];
 protected $listeners = [
  'deleteAll',
  'delete',
 ];

 public function render()
 {
  return view('livewire.front.panel.user.favorite.index');
 }

 public function mount()
 {
  if (auth()->check()) {
   $this->ads = Ad::with('media', 'mainCategory')
                  ->whereHas('favorites', function ($q) {
                   $q->whereUserId(auth()->id());
                  })
                  ->get()
                  ->toArray();
  }
  else {
   if (isset($_COOKIE['favorites'])) {
    $this->ads = Ad::with('media', 'mainCategory')
                   ->whereIn('id', json_decode(json_decode($_COOKIE['favorites'])))
                   ->get()
                   ->toArray();
   }
  }
 }

// public $local;
 public $favorits;

 public function deleteAll($event)
 {
  if ($event['isConfirmed']) {
   if (auth()->check()) {
    Favorite::whereIn('ad_id', \Arr::pluck($this->ads, 'id'))
            ->whereUserId(auth()->id())
            ->delete();
    $message = '(از روی همه سیستم هایی که با این حساب وارد شده اید . )';
   }
   else {
    $message = '(تنها از روی این سیستم )';
    $this->local = true;
    if (isset($_COOKIE['favorites'])) {
     $this->favorits = json_encode([]);
    }
   }
   $this->reset('ads');
   ResponseCache::clear();
   $this->dispatchBrowserEvent('swal:modal', [
    'icon' => 'success',
    'title' => 'آگهی با موفقیت از علاقمندی های شما حذف شد.' . $message,
    'timerProgressBar' => true,
    'timer' => 20000,
    'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> متوجه شدم',
    'width' => 300
   ]);
//   return $this->redirect(route('front.panel.user.favorite.index'));
  }
 }

 public function beforeDeleteAll()
 {
  $this->dispatchBrowserEvent('swal:confirm2', [
   'icon' => 'error',
   'title' => 'آیا مایل به حذف تمام علاقه‌مندی های خود هستید؟',
   'timerProgressBar' => true,
   'timer' => 20000,
   'confirmButtonText' => ' موافقم',
   'cancelButtonText' => ' صرف نظر',
   'showCancelButton' => true,
   'width' => 300,
   'event' => 'deleteAll'
  ]);
 }
}