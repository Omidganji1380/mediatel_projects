<?php

namespace App\Http\Controllers\Payment;

use App\Events\PinAdEvent;
use App\Http\Controllers\Controller;
use App\Jobs\ExpireSubscriptionJob;
use App\Jobs\ExpireTelegramAdSubscriptionJob;
use App\Jobs\PromoteAd;
use App\Jobs\PurchasedPlanNotificationJob;
use App\Mail\Admins\AdminUpgradeLevelMail;
use App\Mail\User\PaymentSuccessMail;
use App\Mail\User\PromoteAdMail;
use App\Mail\User\UpgradeLevelMail;
use App\Models\Ad\Ad;
use App\Models\Cart;
use App\Models\Plan;
use App\Models\Shop\Order;
use App\Models\TelegramAd;
use App\Traits\Helper;
use App\Traits\PaypalTrait;
use App\Traits\TelegramTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Swift_TransportException;

class PaypalController extends Controller
{
    use PaypalTrait, Helper, TelegramTrait;

    protected $provider;

    public function __construct()
    {
        // $paypalConf = config('paypal');
        // $this->provider = new PayPal($paypalConf);
        $this->provider = new PayPalClient;
        $paypalConf = \Config::get('paypal');
        $paypalConf['mode'] = s()->PAYPAL_MODE;
        $paypalConf['sandbox']['client_id'] = s()->PAYPAL_CLIENT_ID;
        $paypalConf['sandbox']['client_secret'] = s()->PAYPAL_SECRET;
        $paypalConf['live']['client_id'] = s()->PAYPAL_CLIENT_ID;
        $paypalConf['live']['client_secret'] = s()->PAYPAL_SECRET;
        $this->provider->setApiCredentials($paypalConf);
        $this->provider = \PayPal::setProvider();
        $this->provider->getAccessToken();
    }

    public function createOrder(Request $request)
    {
        $plan = Plan::find($request->plan_id);
        $cart = Cart::find($request->cart_id);

        if (!$plan)
            return response()->json(['success' => false, 'message' => 'Plan Not found!']);
        if (!$cart)
            return response()->json(['success' => false, 'message' => 'Cart Not found!']);

        $ad = null;
        $adType = 'ad';
        if ($request->ad_id) {
            $ad = Ad::find($request->ad_id);
            $adType = 'ad';
        }
        if ($request->telegram_ad_id) {
            $ad = TelegramAd::find($request->telegram_ad_id);
            $adType = 'telegramAd';
        }

        $currency = config('paypal.currency') ?? 'USD';
        $price = $cart->price;
        $tax = $cart->tax;
        $totalPrice = $cart->total_price;
        $description =  "The Plan id: {$plan->id} and the price is $ {$cart->total_price}";

        $response = $this->createPaypalOrder($currency, $totalPrice, $description);

        Log::info(json_encode($response));

        $customer = $this->createCustomer();

        // Create Kiusk Order with paypal order and customer id
        $createdOrder = $this->createUserOrder($response, $customer, $price, $totalPrice, $tax, $plan->id);

        if ($ad) {
            // Create orderItem
            $this->createOrderItem($createdOrder, $plan, $ad, $adType);

            $this->subscribe($plan, $adType, $ad->id);
        } else {
            $this->createOrderItem($createdOrder, $plan, $ad);
            $this->subscribeToVip($plan);
        }

        return response()->json($response);
    }

    public function paymentSuccess(Request $request)
    {
        $orderId = $request->get('orderId');

        try {
            $response = $this->provider->capturePaymentOrder($orderId);

            Log::info(json_encode($response));
            $user = Auth::user();
            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                $order = Order::where('number', $response['id'])->firstOrFail();
                $order->update(['order_status' => $response['status'], 'status' => 'delivered']);
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

                if ($order->plan && !$order->plan?->vip && $order->plan->model_type === 'ad') {
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
                if ($order->plan?->model_type === 'telegramAd') {
                    $telegramAd = $order->orderItem?->telegramAd;
                    if ($telegramAd) {
                        $telegramAd->update(['is_paid' => true]);
                        ExpireTelegramAdSubscriptionJob::dispatch($telegramAd)->delay(now()->addDays($subscription->plan?->convertDays() ?? 30));
                    }
                }
                ExpireSubscriptionJob::dispatch($subscription)
                    // ->onQueue('expire')
                    ->delay(now()->addDays($subscription->plan->convertDays()));
                $orderMessage = __('messages.order_transaction_success', [
                    'orderId' => $order->id,
                    'transactionId' => $response['id'] ?? 0,
                    'price' => $order->total_price
                ]);
            }else{
                $order = Order::where('number', $response['id'] ?? 0)->firstOrFail();
                $order->update(['order_status' => $response['status'] ?? 'FAILD' , 'status' => 'not-paid']);
                $orderMessage = __('messages.order_transaction_failed', [
                    'orderId' => $order->id,
                    'transactionId' => $response['id'] ?? 0,
                    'price' => $order->total_price
                ]);
            }
            $lang = App::isLocale('fa') ? "" : "/en";
            $message = $user->telegram_id ? $this->sendMessage($user->telegram_id, $orderMessage) : null;
            Log::info(json_encode(['message' => $message]));
            return response()->json([
                'response' => $response,
                'lang' => $lang
            ]);
        } catch (\Exception $e) {
            // Handle the exception and display an error message
            // return view('payments.unsuccessful', compact('e'));
            return response()->json(['success' => false, 'message' => 'Payment capture failed: ' . $e->getMessage()]);
        }
    }

    public function paymentCancel(Request $request)
    {
        return view('payments.cancel');
    }
}
