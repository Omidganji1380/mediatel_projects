<?php

namespace App\Traits;

use App\Models\Shop\Customer;
use App\Models\Shop\Order;
use App\Models\Shop\OrderItem;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

trait PaypalTrait
{
    use Helper;

    public function createPaypalOrder($currency = "USD", $price = 0, $description = 'Description')
    {
        $jsonData = json_encode([
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    "amount" => [
                        "currency_code" => "$currency",
                        "value" => "$price"
                    ],
                    "description" => "$description"
                ]
            ]
        ]);
        $data = json_decode($jsonData, true);

        return $this->provider->createOrder($data);
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
     * Create Order Item
     *
     * @var Order $order
     * @var Plan $plan
     *
     * @return OrderItem
     */
    public function createOrderItem($createdOrder, $plan, $ad = null, $type = null): OrderItem
    {
        $adId = $type === 'ad' ? $ad->id : null;
        $telegramAdId = $type === 'telegramAd' ? $ad->id : null;
        return OrderItem::create([
            'shop_order_id' => $createdOrder->id,
            'plan_id' => $plan->id,
            'ad_id' => $adId,
            'telegram_ad_id' => $telegramAdId,
            'qty' => 1,
            'unit_price' => $plan->price
        ]);
    }

    /**
     * Create User Order
     *
     * @param array $order
     * @return Order
     */
    public function createUserOrder($order, $customer, $price, $totalPrice, $tax, $planId = null): Order
    {
        return Order::create([
            'shop_customer_id' => $customer->id,
            'number' => $order['id'] ?? $this->createUniqueString(Order::class, 'number'),
            'status' => "new",
            'order_status' => $order['status'] ?? "created",
            'total_price' => $totalPrice,
            'currency' => $order['currency'] ?? "USD",
            'shipping_price' => 0,
            'price' => $price,
            'tax' => $tax,
            'plan_id' => $planId
        ]);
    }


}
