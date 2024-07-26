<?php

namespace App\Http\Livewire\Front\Panel\User\Favorite;

use Arr;
use ResponseCache;

trait Favorite
{
 public bool $local;
 public string $favorites;

 public function delete($event, $params)
 {
  if ($event['isConfirmed']) {
   if (auth()->check()) {
    Favorite::whereAdId($params[0])
            ->whereUserId(auth()->id())
            ->delete();
    $message = '(از روی همه سیستم هایی که با این حساب وارد شده اید . )';
   }
   else {
    $message = '(تنها از روی این سیستم )';
    $this->local = true;
    $this->ads = Arr::where($this->ads, function ($value, $key) use ($params) {
     return $value['id'] !== $params[0];
    });
    if (isset($_COOKIE['favorites'])) {
     $storedFavorites = json_decode(json_decode($_COOKIE['favorites']));
     $newList = array_diff($storedFavorites, [$params[0]]);
     $newList = array_values($newList);
     $this->favorites = json_encode($newList);
    }
   }
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

 public function beforeDelete($id)
 {
  $this->dispatchBrowserEvent('swal:confirm3', [
   'icon' => 'error',
   'title' => 'آیا مایل به حذف این مورد از علاقه‌مندی های خود هستید؟',
   'timerProgressBar' => true,
   'timer' => 20000,
   'confirmButtonText' => ' حذف',
   'cancelButtonText' => ' صرف نظر',
   'showCancelButton' => true,
   'width' => 300,
   'event' => 'delete',
   'params' => [$id]
  ]);
 }
}