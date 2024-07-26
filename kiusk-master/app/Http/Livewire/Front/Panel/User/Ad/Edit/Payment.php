<?php

namespace App\Http\Livewire\Front\Panel\User\Ad\Edit;

use App\Http\Controllers\Payment\PaymentController;
use App\Models\Ad\Ad;
use App\Models\Payment\Discount;
use Session;

trait Payment
{
 public $storedAd;
 public Discount $discount;
 public $discountCode = '';
 public $price = 0;
 public $totalAmount = 0;

 public function pay()
 {
  \Session::forget([
                    'goToBuy',
                    'paymentReturnBackRouteUrl',
                    'paymentReturnBackRouteName',
//                    'paymentObject',
                    'paymentDiscount'
                   ]);
  \Session::put([
                 'goToBuy' => true,
                 'paymentReturnBackRouteUrl' => route('front.ad.create'),
                 'paymentReturnBackRouteName' => 'front.ad.create',
//                 'paymentObject' => $this->storedAd->toArray(),
                 'paymentDiscount' => $this->discount->toArray(),
                 'paymentTotalAmount' => $this->totalAmount,
                 'paymentPrice' => $this->price,
                ]);
//  \Session::put('goToBuy', true);
//  \Session::put('paymentReturnBackRouteUrl', route('front.ad.create'));
//  \Session::put('paymentReturnBackRouteName', 'front.ad.create');
//  if (!\Session::get('paymentObject')) {
//   \Session::put('paymentObject', Ad::find(1)
//                                    ->toArray());
//  }
  if ($this->discount) {
   $this->total($this->discount);
  }
  $route = route('front.ad.create', ['routeCallback' => 'front.ad.create']);
  (new PaymentController())->payWithpaypal('Item 1', $this->totalAmount, '', $route, $route);
 }

 public function checkDiscount()
 {
  $discount = Discount::whereCode($this->discountCode)
                      ->first();
  if ($discount) {
   if ($discount->payment_id) {
    $this->dispatchBrowserEvent('swal:modal', [
     'icon' => 'error',
     'title' => 'کد تخفیف قبلا استفاده شده است.',
     'timerProgressBar' => true,
     'timer' => 20000,
     'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> متوجه شدم',
     'width' => 300
    ]);
   }
   else {
    $this->total($discount);
    $this->discount = $discount;
    $this->dispatchBrowserEvent('swal:modal', [
     'icon' => 'success',
     'title' => 'کد تخفیف با موفقیت اعمال شد.',
     'timerProgressBar' => true,
     'timer' => 20000,
     'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> متوجه شدم',
     'width' => 300
    ]);
   }
  }
  else {
   $this->dispatchBrowserEvent('swal:modal', [
    'icon' => 'error',
    'title' => 'کد تخفیف وجود ندارد.',
    'timerProgressBar' => true,
    'timer' => 20000,
    'confirmButtonText' => '<i class="fa fa-thumbs-up"></i> متوجه شدم',
    'width' => 300
   ]);
  }
 }

 public function total(Discount $discount): void
 {
  $this->totalAmount = $this->price;
  if ($discount->percent) {
   $this->totalAmount = $this->price - ($this->price * ($discount->percent / 100));
  }
  if ($discount->amount) {
   $this->totalAmount = $this->totalAmount - $discount->amount;
  }
 }
}