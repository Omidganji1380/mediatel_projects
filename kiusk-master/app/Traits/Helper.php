<?php

namespace App\Traits;

use App\Events\PinAdEvent;
use App\Jobs\ExpireSubscriptionJob;
use App\Jobs\PurchasedPlanNotificationJob;
use App\Mail\User\UpgradeLevelMail;
use App\Models\Ad\Ad;
use App\Models\Discount;
use App\Models\Plan;
use App\Models\Score;
use App\Models\Shop\Customer;
use App\Models\Shop\Order;
use App\Models\Shop\OrderItem;
use App\Models\User;
use App\Services\Plans\PlanService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait Helper
{
    /**
     * Create a unique Slug
     *
     * @param string $model
     * @param string $string
     * @return string
     */
    public function createUniqueSlug($model, string $string): string
    {
        $slug = Str::slug($string);
        while ($model::where('slug', $slug)->exists()) {
            $slug .= "-" . Str::random(5);
        }
        return $slug;
    }

    /**
     * Create a unique String
     *
     * @param string $model
     * @param string $string
     * @return string
     */
    public function createUniqueString($model, $column, $count = 17): string
    {
        $string = Str::random($count);
        while ($model::where($column, $string)->exists()) {
            $this->createUniqueString($model, $column, $count);
        }
        return $string;
    }

    /**
     * Generate a referral code based on user id
     *
     * @param integer $userId
     * @return string
     */
    public function generateReferralCode(int $userId): string
    {
        $length = strlen($userId) >= 15 ?: 15 - strlen($userId);
        $randomString = Str::random($length);
        $referralCode = 'KS' . substr_replace($randomString, $userId, rand(0, strlen($randomString)), 0);
        return $referralCode;
    }

    /**
     * Calcualte the the percentage of the regisration progress
     *
     * @param User $user
     * @return integer
     */
    public function calculateRegistrationProgress($user = null): int
    {
        $total = 0;
        $user = $user ?: auth()->user();
        $user->refresh();
        $properties = User::REGISTRATION_PROGRESS;
        $point = 100 / count($properties);
        foreach ($properties as $key => $value) {
            if ($user->$key) {
                $total += $value;
            }
        }
        return $total;
    }

    /**
     * calculateScoreUsage
     *
     * @param User $user
     * @param integer $totalScoreToSpend
     * @return void
     */
    public function calculateScoreUsage(User $user, int $totalScoreToSpend)
    {
        $userScores = Score::where('user_id', $user->id)
            ->where('spent', false)
            ->orderByDesc('score')
            ->get();

        // Calculate the total score to be spent
        $scoreToSpend = $userScores->sum('score');
        if ($scoreToSpend > $totalScoreToSpend) {
            $scoreToSpend = $totalScoreToSpend;
        }

        // Mark the scores as spent
        foreach ($userScores as $score) {
            if ($scoreToSpend <= 0) {
                break;
            }
            $score->spent = true;
            if ($score->score <= $scoreToSpend) {
                $scoreToSpend -= $score->score;
            } else {
                $score->score -= $scoreToSpend;
                $scoreToSpend = 0;
            }
            $score->save();
        }
    }

    /**
     * generateUniqueDiscountCode
     *
     * @param integer $userId
     * @return string
     */
    public function generateUniqueDiscountCode(int $userId): string
    {
        $length = strlen($userId) >= 15 ?: 15 - strlen($userId);
        $randomString = Str::random($length);
        $code = 'KS' . substr_replace($randomString, $userId, rand(0, strlen($randomString)), 0);
        while (Discount::where('code', $code)->exists()) {
            $this->generateUniqueDiscountCode($userId);
        }
        return $code;
    }

    // Subscriptions
    /**
     * Check if Plan has a pin type
     *
     * @param Collection $plans
     * @return bool
     */
    public function planHasPinAd($plans)
    {
        $planPinAd = false;
        foreach ($plans as $subscription) {
            if ($subscription->is_active && $subscription->plan->pin_ad) {
                $planPinAd = true;
                break;
            }
        }
        return $planPinAd;
    }

    /**
     * Check if the Plan is vip or not
     *
     * @param Collection $plans
     * @return boolean
     */
    public function isPlanVip($plans)
    {
        $vipPlan = false;
        foreach ($plans as $subscription) {
            if ($subscription->is_active && $subscription->plan->vip) {
                $vipPlan = true;
                break;
            }
        }
        return $vipPlan;
    }

    public function makeDescription(Plan $plan)
    {
        $description = "";
        if (!$plan->pin_ad) {
            $description = __('messages.cart_description', [
                'show_in_main_page' => $plan->show_in_main_page ? __('main page') : '',
                'show_in_suggestion' => $plan->show_in_suggestion ? __(', suggestion bar in ads page') : '',
                'show_in_sidebar' => $plan->show_in_sidebar ? __('and sidebar in ads page') : '',
            ]);
        }
        if ($plan->vip) {
            $description .= "\n" . __('messages.cart_description_pin');
        }
        if (!$plan->vip && $plan->pin_ad) {
            $description = __('messages.cart_description_pin');
        }
        return $description;
    }

    /**
     * Subscribe user to the vip plan
     * set vip role to user
     *
     * @param Plan $plan
     * @return void
     */
    public function subscribeToVip(Plan $plan)
    {
        $user = Auth::user();
        // $service = new PlanService;
        // $service->subscribe($user, $plan);
        $this->subscribe($plan, 'vip');
        $user->syncRoles('vip');
    }

    /**
     * Subscribe user to the specific plan
     *
     * @param Plan $plan
     * @return void
     */
    public function subscribeToPlan($plan)
    {
        $user = Auth::user();
        $this->subscribeToVip($plan);
        $subscription = $user->subscriptions()?->latest()?->first();
        $subscription->update(['is_active' => true]);
        ExpireSubscriptionJob::dispatch($subscription)
            // ->onQueue('expire')
            // ->delay(now()->addMinutes(2));
        ->delay(now()->addDays($subscription->plan->convertDays()));
    }

    /**
     * Subscribe to plan
     *
     * @param Plan $plan
     * @return void
     */
    public function updateAdSubscription(Plan $plan, Ad $ad, $end = null)
    {
        $now = Carbon::now();
        $end = $end ?: Carbon::now()->addDays($plan->convertDays());
        $user = Auth::user();

        $ad->update([
            'is_featured' => $plan->show_in_main_page,
            'is_sidebar_featured' => $plan->show_in_sidebar,
            'is_suggestion_featured' => $plan->show_in_suggestion,
            'subscription_start_date' => $now,
            'subscription_end_date' => $end,
        ]);
    }

    /**
     * Subscribe to a plan
     *
     * @param Plan $plan
     * @param string $type
     * @param int $modelId
     * @return void
     */
    public function subscribe(Plan $plan, $type, $modelId = null)
    {
        $now = Carbon::now();
        $end = Carbon::now()->addDays($plan->convertDays());
        $user = Auth::user();
        $subscription = $user->subscriptions()
            ->where('plan_id', $plan->id)
            ->where('type', $type)
            ->where('model_id', $modelId)
            ->first();
        if ($subscription) {
            $subscription->update([
                'starts_at' => $now,
                'ends_at' => $end,
                'usage' => 0,
                'is_vip' => $plan->vip,
            ]);
        } else {
            $user->subscriptions()->create([
                'plan_id' => $plan->id,
                'starts_at' => $now,
                'ends_at' => $end,
                'type' => $type,
                'model_id' => $modelId,
                'is_vip' => $plan->vip,
            ]);
        }
    }

    // Test to Skip Paypal
    /**
     * Create Paypal order
     *
     * @param Request $request
     * @return JsonResource
     */
    public function testCreate($planId, $adId)
    {
        $order = $this->testCreateOrder($planId, $adId);
        return response()->json($order);
    }

    /**
     * Create Order
     *
     * @param array $data
     * @return PaypalClient
     */
    public function testCreateOrder($planId, $adId)
    {
        $plan = Plan::findOrFail($planId);
        $ad = Ad::find($adId);

        $price = $plan->price;
        $tax = $plan->tax ?? 13;
        $totalPrice = $this->calculateTotalPriceWithTax($price, $tax);
        $description = $plan->locale_description ?? $this->makeDescription($plan);

        // Create paypal order
        // $order = $this->paypalOrder($price, $description);

        // Create Customer
        $customer = $this->testCreateCustomer();

        // Create Kiusk Order with paypal order and customer id
        $createdOrder = $this->testCreateUserOrder($customer, $price);

        if ($ad) {
            // Create orderItem
            $createOrderItem = $this->testCreateOrderItem($createdOrder, $plan, $ad);

            $this->subscribe($plan, 'ad', $ad->id);
            // $this->updateAdSubscription($plan, $ad);
        } else {
            $this->subscribeToVip($plan);
        }
        // return $order;
        $this->testCapture($createdOrder);
    }

    /**
     * Create Customer
     *
     * @return Customer
     */
    public function testCreateCustomer(): Customer
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
    public function testCreateUserOrder($customer, $price): Order
    {
        return Order::create([
            'shop_customer_id' => $customer->id,
            'number' => Str::random(),
            'status' => "new",
            'order_status' => 'SUCCESS',
            'total_price' => $price,
            'currency' => "USD",
            'shipping_price' => 0,
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
    public function testCreateOrderItem($createdOrder, $plan, $ad): OrderItem
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
     * Capture Paypal response
     *
     *
     * @return JsonResource
     */
    public function testCapture($createdOrder)
    {
        $result = [
            'id' => $createdOrder->number,
            'status' => 'COMPLETED'
        ];

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
            } else {
                Log::info(
                    'There is no subscription with plan id: ' .
                        $order->orderItem?->plan_id .
                        ' and ad id: ' . $order?->orderItem?->ad_id .
                        ' For user id: ' . $user?->id
                );
            }

            if ($order->orderItem?->plan?->pin_ad) {
                if ($order->orderItem->ad) {
                    PinAdEvent::dispatch($order->orderItem->ad);
                }
            }

            PurchasedPlanNotificationJob::dispatch($order, $user);
        }

        // $this->createTransaction($result, $order, Transaction::PAYMENT_METHOD_PAYPAL);

        ExpireSubscriptionJob::dispatch($subscription)
            // ->onQueue('expire')
            ->delay(now()->addDays($subscription->plan->convertDays()));

        return redirect()->to(route('front.panel.user.payment.index'));
    }

    /**
     * calculateTotalPriceWithTax
     *
     * @param int $price
     * @param int $tax
     * @return void
     */
    public function calculateTotalPriceWithTax($price, $tax)
    {
        $tax = $tax ?? 13;
        return $price + ($price * ($tax / 100));
    }


    // --------------------- Image Overlay -------------------------- //

    /**
     * Create Images
     *
     * @param AdOrder $adOrder
     * @param Category $category
     * @param string $titleFa
     * @param string $titleEn
     * @param string $descFa
     * @param string $descEn
     * @param string $phone1
     * @param string $phone2
     * @param string $website
     * @return void
     */
    public function createAndAssignImageToAdOrder($adOrder, $category, $titleFa, $titleEn, $descFa, $descEn, $phone1 = null, $phone2 = null, $website = null)
    {
        $HomeBGLarge = 'HomeBGLarge_' . rand(1, 2);
        $BlogBottom = 'BlogBottom_' . rand(1, 2);
        $BlogText = 'BlogText_' . rand(1, 2);
        $BlogSidebar = 'BlogSidebar_' . rand(1, 2);

        $outputHomeBgLargeFaImage = $this->textOverImageFa($category, $HomeBGLarge, $titleFa, $descFa, $phone1, $phone2, $website);
        $outputHomeBgLargeEnImage = $this->textOverImageEn($category, $HomeBGLarge, $titleEn, $descEn, $phone1, $phone2, $website);
        $outputBlogBottomFaImage = $this->textOverImageFa($category, $BlogBottom, $titleFa, $descFa, $phone1, $phone2, $website);
        $outputBlogBottomEnImage = $this->textOverImageEn($category, $BlogBottom, $titleEn, $descEn, $phone1, $phone2, $website);
        $outputBlogTextFaImage = $this->textOverImageFa($category, $BlogText, $titleFa, $descFa, $phone1, $phone2, $website);
        $outputBlogTextEnImage = $this->textOverImageEn($category, $BlogText, $titleEn, $descEn, $phone1, $phone2, $website);
        $outputBlogSidebarFaImage = $this->textOverImageFa($category, $BlogSidebar, $titleFa, $descFa, $phone1, $phone2, $website);
        $outputBlogSidebarEnImage = $this->textOverImageEn($category, $BlogSidebar, $titleEn, $descEn, $phone1, $phone2, $website);

        $adOrder->addMedia($outputHomeBgLargeFaImage)->toMediaCollection('HomeBGLargeFa');
        $adOrder->addMedia($outputHomeBgLargeEnImage)->toMediaCollection('HomeBGLargeEn');
        $adOrder->addMedia($outputBlogBottomFaImage)->toMediaCollection('BlogBottomFa');
        $adOrder->addMedia($outputBlogBottomEnImage)->toMediaCollection('BlogBottomEn');
        $adOrder->addMedia($outputBlogTextFaImage)->toMediaCollection('BlogTextFa');
        $adOrder->addMedia($outputBlogTextEnImage)->toMediaCollection('BlogTextEn');
        $adOrder->addMedia($outputBlogSidebarFaImage)->toMediaCollection('BlogSidebarFa');
        $adOrder->addMedia($outputBlogSidebarEnImage)->toMediaCollection('BlogSidebarEn');

        if (Storage::exists($outputHomeBgLargeFaImage)) {
            Storage::delete($outputHomeBgLargeFaImage);
        }
        if (Storage::exists($outputHomeBgLargeEnImage)) {
            Storage::delete($outputHomeBgLargeEnImage);
        }
        if (Storage::exists($outputBlogBottomFaImage)) {
            Storage::delete($outputBlogBottomFaImage);
        }
        if (Storage::exists($outputBlogBottomEnImage)) {
            Storage::delete($outputBlogBottomEnImage);
        }
        if (Storage::exists($outputBlogTextFaImage)) {
            Storage::delete($outputBlogTextFaImage);
        }
        if (Storage::exists($outputBlogTextEnImage)) {
            Storage::delete($outputBlogTextEnImage);
        }
        if (Storage::exists($outputBlogSidebarFaImage)) {
            Storage::delete($outputBlogSidebarFaImage);
        }
        if (Storage::exists($outputBlogSidebarEnImage)) {
            Storage::delete($outputBlogSidebarEnImage);
        }
    }

    public function textOverImageFa($category, $type, $titleFa, $descFa, $phone1 = null, $phone2 = null, $website = null)
    {
        $imagePath = $category->getFirstMedia($type)?->getPath();
        $imagePath = str_replace('\\', '/',$imagePath);

        if (!$imagePath || !file_exists($imagePath)) {
            throw new \Exception('The image file does not exist.' . ' Type: ' . $type);
        }

        $image = Image::make($imagePath);

        return $this->textPersianOnImage($image, $category, $type, $titleFa, $descFa, $phone1, $phone2, $website);
    }

    public function textOverImageEn($category, $type, $titleEn, $descEn, $phone1 = null, $phone2 = null, $website = null)
    {
        $imagePath = $category->getFirstMedia($type)?->getPath();
        $imagePath = str_replace('\\', '/',$imagePath);

        if (!$imagePath || !file_exists($imagePath)) {
            throw new \Exception('The image file does not exist.' . ' Type: ' . $type);
        }

        $image = Image::make($imagePath);

        return $this->textEnglishOnImage($image, $category, $type, $titleEn, $descEn, $phone1, $phone2, $website);
    }

    public function textPersianOnImage($image, $category, $type, $titleFa, $descFa, $phone1, $phone2, $website)
    {
        $outputFaImagePath = public_path('images/overlay_' . uniqid() . '.jpg');

        $titleFa = $this->renderPersianText($titleFa);
        // $descFa = $this->renderPersianText($descFa);

        // Create the Image
        $persianImage = $this->createPersianImage($image, $category, $type, $titleFa, $descFa, $phone1, $phone2, $website);

        // Save the image
        $persianImage->save($outputFaImagePath);

        return $outputFaImagePath;
    }

    public function textEnglishOnImage($image, $category, $type, $titleEn, $descEn, $phone1, $phone2, $website)
    {
        $outputEnImagePath = public_path('images/overlay_' . uniqid() . '.jpg');

        // Create the Image
        $englishImage = $this->createEnglishImage($image, $category, $type, $titleEn, $descEn, $phone1, $phone2, $website);

        // Save the image
        $englishImage->save($outputEnImagePath);

        return $outputEnImagePath;
    }

    public function createPersianImage($image, $category, $type, $titleFa, $descFa, $phone1, $phone2, $website)
    {
        $wrap = [
            'HomeBGLarge_1' => [
                'wrap' => 70,
                'line_height' => 33,
            ],
            'HomeBGLarge_2' => [
                'wrap' => 70,
                'line_height' => 33,
            ],
            'BlogBottom_1' => [
                'wrap' => 60,
                'line_height' => 85,
            ],
            'BlogBottom_2' => [
                'wrap' => 60,
                'line_height' => 85,
            ],
            'BlogText_1' => [
                'wrap' => 50,
                'line_height' => 22,
            ],
            'BlogText_2' => [
                'wrap' => 50,
                'line_height' => 22,
            ],
            'BlogSidebar_1' => [
                'wrap' => 60,
                'line_height' => 85,
            ],
            'BlogSidebar_2' => [
                'wrap' => 60,
                'line_height' => 85,
            ],
        ];
        $extra = json_decode(json_encode($category->extra), false);
        // Persian
        $titleFaPositionX = $extra?->$type?->positions?->fa?->title?->x ?? 0;
        $titleFaPositionY = $extra?->$type?->positions?->fa?->title?->y ?? 0;
        $titleFaSize = $extra?->$type?->positions?->fa?->title?->size ?? 14;
        $titleFaColor = $extra?->$type?->positions?->fa?->title?->color ?? "#000";
        $titleFaAlign = $extra?->$type?->positions?->fa?->title?->align ?? 'right';
        $titleFaVAlign = $extra?->$type?->positions?->fa?->title?->valign ?? 'middle';
        $descriptionFaPositionX = $extra?->$type?->positions?->fa?->description?->x ?? 0;
        $descriptionFaPositionY = $extra?->$type?->positions?->fa?->description?->y ?? 0;
        $descriptionFaSize = $extra?->$type?->positions?->fa?->description?->size ?? 14;
        $descriptionFaColor = $extra?->$type?->positions?->fa?->description?->color ?? "#000";
        $descriptionFaAlign = $extra?->$type?->positions?->fa?->description?->align ?? 'right';
        $descriptionFaVAlign = $extra?->$type?->positions?->fa?->description?->valign ?? 'middle';

        // Mutual
        $phonePositionX = $extra?->$type?->positions?->en?->phone_1?->x ?? 0;
        $phonePositionY = $extra?->$type?->positions?->en?->phone_1?->y ?? 0;
        $phoneFaSize = $extra?->$type?->positions?->fa?->phone_1?->size ?? 14;
        $phoneFaColor = $extra?->$type?->positions?->fa?->phone_1?->color ?? "#000";
        $phoneFaAlign = $extra?->$type?->positions?->fa?->phone_1?->align ?? 'right';
        $phoneFaVAlign = $extra?->$type?->positions?->fa?->phone_1?->valign ?? 'middle';
        $phone2PositionX = $extra?->$type?->positions?->en?->phone_2?->x ?? 0;
        $phone2PositionY = $extra?->$type?->positions?->en?->phone_2?->y ?? 0;
        $phone2FaSize = $extra?->$type?->positions?->fa?->phone_2?->size ?? 14;
        $phone2FaColor = $extra?->$type?->positions?->fa?->phone_2?->color ?? "#000";
        $phone2FaAlign = $extra?->$type?->positions?->fa?->phone_2?->align ?? 'right';
        $phone2FaVAlign = $extra?->$type?->positions?->fa?->phone_2?->valign ?? 'middle';
        $websitePositionX = $extra?->$type?->positions?->en?->website?->x ?? 0;
        $websitePositionY = $extra?->$type?->positions?->en?->website?->y ?? 0;
        $websiteFaSize = $extra?->$type?->positions?->fa?->website?->size ?? 14;
        $websiteFaColor = $extra?->$type?->positions?->fa?->website?->color ?? "#000";
        $websiteFaAlign = $extra?->$type?->positions?->fa?->website?->align ?? 'right';
        $websiteFaVAlign = $extra?->$type?->positions?->fa?->website?->valign ?? 'middle';

        $image = $this->putTextOverlay($image, $titleFa, $titleFaPositionX, $titleFaPositionY, $titleFaSize, $titleFaColor, $titleFaAlign, $titleFaVAlign);

        $descFa = $this->persianWordwrap($descFa, $wrap[$type]['wrap']);
        $i = 0;
        foreach($descFa as $desc){
            $desc = $this->renderPersianText($desc);
            $newPositionY = $descriptionFaPositionY + $i;
            $image = $this->putTextOverlay($image, $desc, $descriptionFaPositionX, $newPositionY, $descriptionFaSize, $descriptionFaColor, $descriptionFaAlign, $descriptionFaVAlign);
            $i += $wrap[$type]['line_height'];
        }

        if ($phone1) {
            $image = $this->putTextOverlay($image, $phone1, $phonePositionX, $phonePositionY, $phoneFaSize, $phoneFaColor, $phoneFaAlign, $phoneFaVAlign);
        }
        if ($phone2) {
            $image = $this->putTextOverlay($image, $phone2, $phone2PositionX, $phone2PositionY, $phone2FaSize, $phone2FaColor, $phone2FaAlign, $phone2FaVAlign);
        }
        if ($website) {
            $image = $this->putTextOverlay($image, $website, $websitePositionX, $websitePositionY, $websiteFaSize, $websiteFaColor, $websiteFaAlign, $websiteFaVAlign);
        }
        return $image;
    }

    public function createEnglishImage($image, $category, $type, $titleEn, $descEn, $phone1, $phone2, $website)
    {
        $wrap = [
            'HomeBGLarge_1' => 70,
            'HomeBGLarge_2' => 70,
            'BlogBottom_1' => 55,
            'BlogBottom_2' => 55,
            'BlogText_1' => 50,
            'BlogText_2' => 50,
            'BlogSidebar_1' => 55,
            'BlogSidebar_2' => 55,
        ];
        $extra = json_decode(json_encode($category->extra), false);
        // English
        $titleEnPositionX = $extra?->$type?->positions?->en?->title?->x ?? 0;
        $titleEnPositionY = $extra?->$type?->positions?->en?->title?->y ?? 0;
        $titleEnSize = $extra?->$type?->positions?->en?->title?->size ?? 14;
        $titleEnColor = $extra?->$type?->positions?->en?->title?->color ?? "#000";
        $titleEnAlign = $extra?->$type?->positions?->en?->title?->align ?? 'left';
        $titleEnVAlign = $extra?->$type?->positions?->en?->title?->valign ?? 'middle';
        $descriptionEnPositionX = $extra?->$type?->positions?->en?->description?->x ?? 0;
        $descriptionEnPositionY = $extra?->$type?->positions?->en?->description?->y ?? 0;
        $descriptionEnSize = $extra?->$type?->positions?->en?->description?->size ?? 14;
        $descriptionEnColor = $extra?->$type?->positions?->en?->description?->color ?? "#000";
        $descriptionEnAlign = $extra?->$type?->positions?->en?->description?->align ?? 'left';
        $descriptionEnVAlign = $extra?->$type?->positions?->en?->description?->valign ?? 'middle';

        // Mutual
        $phonePositionX = $extra?->$type?->positions?->en?->phone_1?->x ?? 0;
        $phonePositionY = $extra?->$type?->positions?->en?->phone_1?->y ?? 0;
        $phoneEnSize = $extra?->$type?->positions?->en?->phone_1?->size ?? 14;
        $phoneEnColor = $extra?->$type?->positions?->en?->phone_1?->color ?? "#000";
        $phoneEnAlign = $extra?->$type?->positions?->en?->phone_1?->align ?? 'left';
        $phoneEnVAlign = $extra?->$type?->positions?->en?->phone_1?->valign ?? 'middle';
        $phone2PositionX = $extra?->$type?->positions?->en?->phone_2?->x ?? 0;
        $phone2PositionY = $extra?->$type?->positions?->en?->phone_2?->y ?? 0;
        $phone2EnSize = $extra?->$type?->positions?->en?->phone_2?->size ?? 14;
        $phone2EnColor = $extra?->$type?->positions?->en?->phone_2?->color ?? "#000";
        $phone2EnAlign = $extra?->$type?->positions?->en?->phone_2?->align ?? 'left';
        $phone2EnVAlign = $extra?->$type?->positions?->en?->phone_2?->valign ?? 'middle';
        $websitePositionX = $extra?->$type?->positions?->en?->website?->x ?? 0;
        $websitePositionY = $extra?->$type?->positions?->en?->website?->y ?? 0;
        $websiteEnSize = $extra?->$type?->positions?->en?->website?->size ?? 14;
        $websiteEnColor = $extra?->$type?->positions?->en?->website?->color ?? "#000";
        $websiteEnAlign = $extra?->$type?->positions?->en?->website?->align ?? 'left';
        $websiteEnVAlign = $extra?->$type?->positions?->en?->website?->valign ?? 'middle';

        $image = $this->putTextOverlay($image, $titleEn, $titleEnPositionX, $titleEnPositionY, $titleEnSize, $titleEnColor, $titleEnAlign, $titleEnVAlign);
        $image = $this->putTextOverlay($image, $descEn, $descriptionEnPositionX, $descriptionEnPositionY, $descriptionEnSize, $descriptionEnColor, $descriptionEnAlign, $descriptionEnVAlign, $wrap[$type] ?? 60);
        if ($phone1) {
            $image = $this->putTextOverlay($image, $phone1, $phonePositionX, $phonePositionY, $phoneEnSize, $phoneEnColor, $phoneEnAlign, $phoneEnVAlign);
        }
        if ($phone2) {
            $image = $this->putTextOverlay($image, $phone2, $phone2PositionX, $phone2PositionY, $phone2EnSize, $phone2EnColor, $phone2EnAlign, $phone2EnVAlign);
        }
        if ($website) {
            $image = $this->putTextOverlay($image, $website, $websitePositionX, $websitePositionY, $websiteEnSize, $websiteEnColor, $websiteEnAlign, $websiteEnVAlign);
        }
        return $image;
    }

    public function renderPersianText($text)
    {
        // Explode the text into an array of words
        $words = explode(' ', $text);

        // Apply the PersianRender filter to each word
        $filteredWords = array_map(function ($word) {
            return \PersianRender\PersianRender::render($word);
        }, $words);

        // Implode the filtered words with a space character
        $text = implode(' ', $filteredWords);
        // $text  = \PersianRender\PersianRender::render($text); //Reversed text for GD
        $persianText = '';
        for ($i = mb_strlen($text); $i >= 0; $i--) {
            $persianText .= mb_substr($text, $i, 1);
        }
        // dd($persianText);
        return $persianText;
    }

    public function persian_wordwrap($text, $width, $break = "\n")
    {
        $wrappedText = '';
        $stringLength = mb_strlen($text, 'UTF-8');
        $lineWidth = 0;
        for ($i = 0; $i < $stringLength; $i++) {
            $char = mb_substr($text, $i, 1, 'UTF-8');
            $charWidth = mb_strwidth($char, 'UTF-8');
            if ($charWidth > 1) {
                // A Persian character
                $lineWidth += $charWidth;
            } else {
                // A non-Persian character
                $lineWidth++;
            }
            if ($lineWidth > $width) {
                $wrappedText .= $break;
                $lineWidth = $charWidth;
            }
            $wrappedText .= $char;
        }
        return $wrappedText;
    }

    public function persianWordwrap($text, $chunkLength = 50)
    {
        // $text = "متن شما در اینجاست. این یک متن آزمایشی برای تست عملکرد تابع است.";
        $words = preg_split('/\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY);
        $currentChunk = '';

        foreach ($words as $word) {
            $newChunk = $currentChunk . ' ' . $word;
            $newChunkLength = mb_strlen($newChunk);

            if ($newChunkLength > $chunkLength) {
                $chunks[] = $currentChunk;
                $currentChunk = $word;
            } else {
                $currentChunk = $newChunk;
            }
        }

        if (!empty($currentChunk)) {
            $chunks[] = $currentChunk;
        }

        // $chunks = array_reverse($chunks);

        return $chunks;
    }

    public function putTextOverlay($image, $text, $textX, $textY, $size = 14, $color = '#000', $align = 'right', $valign = 'middle', $wrap = null)
    {

        $text = $wrap ? wordwrap($text, $wrap, "\n") : $text;
        return $image->text($text, $textX, $textY, function ($font) use ($size, $color, $align, $valign) {
            $font->file(public_path('font/FontsFree-Net-ir_sans (1).ttf')); // Replace with the actual path of your font file
            $font->size($size);
            $font->color($color); // Text color (white in this example)
            $font->align($align);
            $font->valign($valign);
        });
    }
}
