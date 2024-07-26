<?php

namespace App\Http\Livewire\Front\Panel\User\Ad;

use App\Http\Controllers\Payment\PaymentController;
use App\Models\Ad\Ad;
use App\Models\Payment\Discount;
use Livewire\Component;
use Session;

class Payment extends Component
{
 public $storedAd;
 public Discount $discount;
 public $discountCode = '';
 public $price = 0;
 public $totalAmount = 0;
 public Ad $ad;
 public $listPrice = [
  'star' => [
   'price' => 5,
   'total' => 5,
   'name' => '<i class="fas fa-star"></i>آگهی ویژه',
   'name2' => 'آگهی ویژه',
   'description' => 'آگهی شما با برچسب آگهی ویژه نشان داده می‌شود. این امکان علاوه بر ایجاد تمایز ظاهری و جلب توجه بیشتر برای آگهی شما، شرایط نمایش در دسته بندی آگهی‌های ویژه را فراهم می‌سازد.	'
  ],
  'rocket' => [
   'price' => 2,
   'total' => 2,
   'name' => '<i class="fas fa-rocket"></i>نردبان',
   'name2' => 'نردبان',
   'description' => 'آگهی شما تا زمان دریافت آگهی تازه‌تر در همان دسته‌بندی و شهر، به عنوان اولین آگهی نمایش داده می‌شود.	'
  ],
  'star&rocket' => [
   'price' => 7,
   'total' => 7,
   'name' => '<i class="fas fa-star"></i><i class="fas fa-rocket"></i>اگهی ویژه و نردبان',
   'name2' => 'آگهی ویژه و نردبان',
   'description' => 'آگهی شما ویژه و نردبان خواهد شد.	'
  ]
 ];

 public function mount($ad)
 {
  $this->ad = $ad;
  $this->discount = new Discount();
//  if (Session::get('goToBuy')) {
//   $this->step = 'buy';
//   Session::forget('goToBuy');
//  }
  if (Session::get('successPayment')) {
//   Session::forget('goToBuy');
//   Session::forget('paymentObject',);
   Session::forget('successPayment');
  }
  $this->price = $this->totalAmount = 5;
 }

 public function pay($key)
 {
  if ($this->discount) {
   $this->total($this->discount);
  }
  Session::forget([
                   'goToBuy',
                   'paymentReturnBackRouteUrl',
                   'paymentReturnBackRouteName',
//                    'paymentObject',
                   'paymentDiscount'
                  ]);
  $route = route('front.panel.user.ad.payment', [
   'id' => $this->ad->id,
   'routeCallback' => 'front.ad.create'
  ]);
  Session::put([
                'goToBuy' => true,
                'paymentReturnBackRouteUrl' => $route,
                'paymentReturnBackRouteName' => 'front.panel.user.ad.payment',
                'paymentObject' => $this->ad->toArray(),
                'paymentDiscount' => $this->discount->toArray(),
                'paymentTotalAmount' => $this->listPrice[$key]['total'],
                'paymentPrice' => $this->listPrice[$key]['price'],
                'paymentName' => $this->listPrice[$key]['name2'],
               ]);
//  Session::put('goToBuy', true);
//  Session::put('paymentReturnBackRouteUrl', route('front.ad.create'));
//  Session::put('paymentReturnBackRouteName', 'front.ad.create');
//  if (!Session::get('paymentObject')) {
//   Session::put('paymentObject', Ad::find(1)
//                                    ->toArray());
//  }
  (new PaymentController())->payWithpaypal('Item 1', $this->listPrice[$key]['total'], '', $route, $route);
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
  foreach ($this->listPrice as $key => $item) {
   if ($discount->percent) {
    $this->listPrice[$key]['total'] = $this->listPrice[$key]['price'] - ($this->listPrice[$key]['price'] * ($discount->percent / 100));
   }
   if ($discount->amount) {
    $this->listPrice[$key]['total'] = $this->listPrice[$key]['total'] - $discount->amount;
   }
  }
 }

 public function render()
 {
  return view('livewire.front.panel.user.ad.payment');
 }
}