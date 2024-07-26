<?php

namespace App\Http\Controllers\Payment;

use App\Events\PinAdEvent;
use App\Http\Controllers\Controller;
use App\Jobs\ExpireSubscriptionJob;
use App\Jobs\PromoteAd;
use App\Jobs\PurchasedAdvertisementJob;
use App\Jobs\PurchasedPlanNotificationJob;
use App\Mail\Admins\AdminUpgradeLevelMail;
use App\Mail\Admins\PaidUserMail;
use App\Mail\User\PaymentSuccessMail;
use App\Mail\User\PromoteAdMail;
use App\Mail\User\UpgradeLevelMail;
use App\Models\Ad\Ad;
use App\Models\AdvertisementOrder;
use App\Models\AdvertisementType;
use App\Models\Payment\Discount;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;

/** All Paypal Details class **/

use App\Models\Shop\Order;
use App\Models\Plan;
use App\Models\Shop\Customer;
use App\Models\Shop\OrderItem;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\User\PaymentNotification;
use App\Responses\Errors;
use App\Services\Plans\PlanService;
use App\Traits\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
// use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Swift_TransportException;

class PaymentController extends Controller
{
    use Helper;

    private ApiContext $_api_context;
    protected $provider;
    public $service;

    public function __construct(PayPalClient $provider, PlanService $service)
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $paypal_conf['mode'] = s()->PAYPAL_MODE;
        // $paypal_conf['sandbox']['client_id'] = s()->PAYPAL_CLIENT_ID;
        // $paypal_conf['sandbox']['client_secret'] = s()->PAYPAL_SECRET;
        $paypal_conf['live']['client_id'] = s()->PAYPAL_CLIENT_ID;
        $paypal_conf['live']['client_secret'] = s()->PAYPAL_SECRET;
        // $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        // $this->_api_context->setConfig($paypal_conf['settings']);

        try {
            $this->provider = $provider;
            $this->provider->setApiCredentials($paypal_conf);
            $token = $this->provider->getAccessToken();
            $this->provider->setAccessToken($token);
            $this->service = $service;
        } catch (\Exception $exception) {
            return response(Errors::exception(Errors::$_UNKNOWN_ERROR, $exception->getMessage()), 403);
        }
    }

    /**
     * Create Paypal order
     *
     * @param Request $request
     * @return JsonResource
     */
    public function create(Request $request)
    {
        $order = $this->createOrder(json_decode($request->getContent(), true));
        return response()->json($order);
        // return response()->json(true);
    }

    /**
     * Capture Paypal response
     *
     * @param Request $request
     * @return JsonResource
     */
    public function capture(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $orderId = $data['orderID'];
        $result = $this->provider->capturePaymentOrder($orderId);

        //update database
        if (isset($result['status']) && $result['status'] == 'COMPLETED') {
            $order = Order::where('number', $result['id'])->firstOrFail();
            $order->update(['order_status' => $result['status'], 'status' => 'delivered']);
            $user = Auth::user();
            $user->cart?->delete();
            // $subscription = $user->subscriptions()?->latest()?->first();
            $subscription = $user->subscriptions()
                ?->where('plan_id', $order->orderItem?->plan_id)
                ?->where('model_id', $order->orderItem?->ad_id)?->first();
            if ($subscription) {
                $subscription->update(['is_active' => true]);
            } elseif ($subscription = $user->vipSubscription) {
                $subscription->update(['is_active' => true]);
                $currentRole = 'VIP';
                $previousRole = auth()->user()->rule;
                try {
                    Mail::to('Kiusk.ca@yahoo.com')->send(new AdminUpgradeLevelMail($user, $currentRole, $previousRole, $order->total_price));
                } catch (Swift_TransportException $exception) {
                    Log::error('Error sending email: ' . $exception->getMessage());
                }
            } else {
                Log::info(
                    'There is no subscription with plan id: ' .
                        $order->orderItem?->plan_id .
                        ' and ad id: ' . $order?->orderItem?->ad_id .
                        ' For user id: ' . $user?->id
                );
            }

            if ($order->orderItem?->plan?->pin_ad && !$order->orderItem?->plan?->vip) {
                if ($order->orderItem->ad) {
                    PinAdEvent::dispatch($order->orderItem->ad);
                }
            }

            if ($order->plan && !$order->plan?->vip) {
                $ad = $order->orderItem->ad;
                $plan = $order->orderItem->plan;
                PromoteAd::dispatch($ad, $plan);
                try {
                    Mail::to($user->email)->send(new PromoteAdMail($user, $ad));
                } catch (Swift_TransportException $exception) {
                    Log::error('Error sending email: ' . $exception->getMessage());
                }
            } else {
                try {
                    Mail::to($user->email)->send(new UpgradeLevelMail($user));
                } catch (Swift_TransportException $exception) {
                    Log::error('Error sending email: ' . $exception->getMessage());
                }
            }
            try {
                Mail::to($user->email)->send(new PaymentSuccessMail($user, $order));
            } catch (Swift_TransportException $exception) {
                Log::error('Error sending email: ' . $exception->getMessage());
            }
            PurchasedPlanNotificationJob::dispatch($order, $user);
            ExpireSubscriptionJob::dispatch($subscription)
                // ->onQueue('expire')
                ->delay(now()->addDays($subscription->plan->convertDays()));
        }

        // $this->createTransaction($result, $order, Transaction::PAYMENT_METHOD_PAYPAL);


        return response()->json($result);
    }

    /**
     * Create Order
     *
     * @param array $data
     * @return PaypalClient
     */
    public function createOrder($data)
    {
        $plan = Plan::findOrFail($data['plan_id']);
        $ad = Ad::find($data['ad_id']);
        // auth()->user()->update(['rule' => $data['current_role']]);

        $price = $plan->price;
        $tax = $plan->tax ?? 13;
        $totalPrice = $this->calculateTotalPriceWithTax($price, $tax);
        $description = $plan->locale_description ?? $this->makeDescription($plan);

        // Create paypal order
        $order = $this->paypalOrder($totalPrice, $description);

        // Create Customer
        $customer = $this->createCustomer();

        // Create Kiusk Order with paypal order and customer id
        $createdOrder = $this->createUserOrder($order, $customer, $price, $totalPrice, $tax);

        if ($ad) {
            // Create orderItem
            $createOrderItem = $this->createOrderItem($createdOrder, $plan, $ad);

            $this->subscribe($plan, 'ad', $ad->id);
            // $this->updateAdSubscription($plan, $ad);
        } else {
            $this->subscribeToVip($plan);
        }
        return $order;
    }

    // public function makeDescription($plan)
    // {
    //     $description = "";
    //     if(!$plan->pin_ad){
    //         $description = __('messages.cart_description', [
    //             'show_in_main_page' => $plan->show_in_main_page ? __('main page') : '',
    //             'show_in_suggestion' => $plan->show_in_suggestion ? __(', suggestion bar in ads page') : '',
    //             'show_in_sidebar' => $plan->show_in_sidebar ? __('and sidebar in ads page') : '',
    //         ]);
    //     }
    //     if($plan->vip){
    //         $description .= "\n" . __('messages.cart_description_pin');
    //     }
    //     if(!$plan->vip && $plan->pin_ad){
    //         $description = __('messages.cart_description_pin');
    //     }
    //     return $description;
    // }

    /**
     * Paypal create order
     *
     * @param int $price
     * @param string $description
     * @return array
     */
    public function paypalOrder($price, $description)
    {
        return $this->provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => "$price"
                    ],
                    "description" => "$description"
                ]
            ]
        ]);
    }

    /**
     * Create Customer
     *
     * @return Customer
     */
    public function createCustomer(): Customer
    {
        $user = Auth::user();
        return Customer::updateOrCreate(
            [
                'email' => $user->email,
            ],
            [
                'name' => $user->name_with_role,
                'gender' => 'male',
                'phone' => $user->phone
            ]
        );
    }

    /**
     * Create User Order
     *
     * @param array $order
     * @return Order
     */
    public function createUserOrder($order, $customer, $price, $totalPrice, $tax): Order
    {
        return Order::create([
            'shop_customer_id' => $customer->id,
            'number' => $order['id'] ?? 0,
            'status' => "new",
            'order_status' => $order['status'] ?? "created",
            'total_price' => $totalPrice,
            'currency' => "USD",
            'shipping_price' => 0,
            'price' => $price,
            'tax' => $tax,
        ]);
    }

    /**
     * Create Order Item
     *
     * @var Order $order
     * @var Plan $plan
     *
     * @return OrderItem
     */
    public function createOrderItem($createdOrder, $plan, $ad): OrderItem
    {
        return OrderItem::create([
            'shop_order_id' => $createdOrder->id,
            'plan_id' => $plan->id,
            'ad_id' => $ad->id,
            'qty' => 1,
            'unit_price' => $plan->price
        ]);
    }

    /**
     * Create transaction
     *
     * @param array $result
     * @param Order $order
     * @return void
     */
    public function createTransaction(array $result, Order $order, $mode, $price, $tax)
    {
        Transaction::create([
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'status' => $result['status'] ?? null,
            'reference_id' => $result['id'] ?? null,
            'total_price' => $order->total_price,
            'discount' => $order->discount,
            'mode' => $mode,
            'price' => $price,
            'tax' => $tax,
            // 'transactionable_type' =>
        ]);
    }

    public function index()
    {
        return view('paywithpaypal');
    }

    public function payWithpaypal($name = 'Item 1', $price = 0, $description = '', $returnUrl = '/return', $cancelUrl = '/cancel')
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName($name)
            /** item name **/
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($price);
        /** unit price **/
        $item_list = new ItemList();
        $item_list->setItems([$item_1]);
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($price);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($description);
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(route('payment'))
        /** Specify return URL **/
        ->setCancelUrl(route('payment'));
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions([$transaction]);
        //  dd($payment->create($this->_api_context));exit;
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');

                return Redirect::to($cancelUrl);
            } else {
                \Session::put('error', 'Some error occur, sorry for inconvenient');

                return Redirect::to($cancelUrl);
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();

                break;
            }
        }
        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        \Session::put('error', 'Unknown error occurred');

        return Redirect::to($cancelUrl);
    }

    public function getPaymentStatus()
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        $route = Session::get('paymentReturnBackRouteUrl');
        Session::forget('paymentReturnBackRouteUrl');
        if (empty(request()->PayerID) || empty(\request()->token)) {
            \Session::put('error', 'Payment failed');

            return Redirect::to($route);
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(\request()->PayerID);
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {
            //   // dump(\request()->paymentReturnBackRouteName);
            switch (Session::get('paymentReturnBackRouteName')) {
                case 'front.ad.create':
                    $adSession = \Session::get('paymentObject');
                    // dump($adSession);
                    $ad = new Ad($adSession);
                    $ad->id = $adSession['id'];
                    $discountSession = (array)Session::get('paymentDiscount');
                    $discount = new Discount($discountSession);
                    $total = Session::get('paymentTotalAmount');
                    Session::forget('paymentTotalAmount');
                    $price = Session::get('paymentPrice');
                    Session::forget('paymentPrice');
                    $extra = [
                        'payment_info' => [
                            'gateway' => 'paypal',
                            'payer_id' => \request()->PayerID,
                            'payment_id' => $payment_id,
                            'token' => \request()->token,
                        ],
                        'payment_price' => [
                            'total' => $total,
                            'price' => $price,
                            'discount_id' => $discount->id,
                        ],
                        'ad' => [
                            'special' => true,
                            'name' => 'آگهی ویژه',
                        ],
                    ];
                    \DB::transaction(function () use ($ad, $discount, $total, $extra) {
                        $adExtra = $ad->extra;
                        $adExtra->special = true;
                        Ad::find($ad->id)
                            -> //      $ad->
                            update([
                                'extra' => $adExtra,
                            ]);
                        $payment = $ad->payments()
                            ->create([
                                'amount' => $total,
                                'user_id' => auth()->id(),
                                'status' => 'complete',
                                'extra' => $extra,
                            ]);
                        Discount::whereCode($discount->code)
                            ->update([
                                'payment_id' => $payment->id,
                            ]);
                    });

                    break;
                case 'front.panel.user.ad.payment':
                    $adSession = \Session::get('paymentObject');
                    // dump($adSession);
                    $ad = new Ad($adSession);
                    $ad->id = $adSession['id'];
                    $discountSession = (array)Session::get('paymentDiscount');
                    $discount = new Discount($discountSession);
                    $total = Session::get('paymentTotalAmount');
                    Session::forget('paymentTotalAmount');
                    $price = Session::get('paymentPrice');
                    Session::forget('paymentPrice');
                    $name = Session::get('paymentName');
                    Session::forget('paymentName');
                    if ($name !== 'نردبان') {
                        $special = true;
                    } else {
                        $special = false;
                    }
                    $extra = [
                        'payment_info' => [
                            'gateway' => 'paypal',
                            'payer_id' => \request()->PayerID,
                            'payment_id' => $payment_id,
                            'token' => \request()->token,
                        ],
                        'payment_price' => [
                            'total' => $total,
                            'price' => $price,
                            'discount_id' => $discount->id,
                        ],
                        'ad' => [
                            'special' => $special,
                            'name' => $name,
                        ],
                    ];
                    \DB::transaction(function () use ($ad, $discount, $total, $extra, $special, $name) {
                        $adExtra = $ad->extra;
                        $adExtra->special = $special;
                        $ad1 = Ad::find($ad->id);
                        $ad1->update([
                            'extra' => $adExtra,
                        ]);
                        if (\Str::contains($name, 'نردبان')) {
                            $ad1->moveToEnd();
                        }
                        $payment = $ad->payments()
                            ->create([
                                'amount' => $total,
                                'user_id' => auth()->id(),
                                'status' => 'complete',
                                'extra' => $extra,
                            ]);
                        Discount::whereCode($discount->code)
                            ->update([
                                'payment_id' => $payment->id,
                            ]);
                    });

                    break;
            }
            \Session::put('success', 'پرداخت با موفقیت انجام شد.کد پرداخت : ' . $payment_id);
            Session::get('successPayment', true);

            return Redirect::to($route);
        }
        \Session::put('error', 'پرداخت ناموفق');

        return Redirect::to($route);
    }

    public function createAdvertisement(Request $request)
    {
        $order = $this->createAdOrder(json_decode($request->getContent(), true));
        return response()->json($order);
    }

    public function captureAdvertisement(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $orderId = $data['orderID'];
        $result = $this->provider->capturePaymentOrder($orderId);

        //update database
        if (isset($result['status']) && $result['status'] == 'COMPLETED') {
            $transaction = Transaction::where('reference_id', $result['id'])->firstOrFail();
            $transaction->update(['status' => $result['status'], 'status' => 'delivered']);
            $transaction->transactionable->setStatus('payment_completed');
            $user = Auth::user();
            $user->cart?->delete();
            // $user()->notify(new PaymentNotification($order));
            PurchasedAdvertisementJob::dispatch($transaction, $user);
            Mail::to($user->email)->send(new PaymentSuccessMail($user, $transaction));
            // ExpireSubscriptionJob::dispatch($user)->delay(now()->addDays($user->subscriptionPeriod()));
        }

        // $this->createTransaction($result, $order, Transaction::PAYMENT_METHOD_PAYPAL);

        // ExpireSubscriptionJob::dispatch($user)->onQueue('expire')->delay(now()->addDays($user->subscriptionPeriod()));

        return response()->json($result);
    }

    /**
     * Create Order
     *
     * @param array $data
     * @return PaypalClient
     */
    public function createAdOrder($data)
    {
        $adType = AdvertisementType::findOrFail($data['advertisement_type_id']);
        $adOrder = AdvertisementOrder::findOrFail($data['advertisement_order_id']);

        $price = $adOrder->total_price;
        $description = $adType->description;

        $order = $this->paypalOrder($price, $description);

        $adOrder->transaction()->create([
            'user_id' => Auth::id(),
            'status' => $order['status'] ?? null,
            'reference_id' => $order['id'] ?? null,
            'total_price' => $adOrder->total_price,
            'discount' => $adOrder->discount,
            'mode' => 'paypal',
        ]);

        // $createOrderItem = $this->createTransaction($createdOrder, $plan, $ad);

        // $this->subscribe($plan, $ad);
        return $order;
    }
}
