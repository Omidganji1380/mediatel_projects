<?php

namespace App\Models\Shop;

use App\Models\Ad\Ad;
use App\Models\Plan;
use App\Models\TelegramAd;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'shop_order_items';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'shop_order_id',
        'shop_product_id',
        'plan_id',
        'ad_id',
        'telegram_ad_id',
        'qty',
        'unit_price',
    ];

    /**
     * Order Relations
     *
     * @return BelongsTo
     */
    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class, 'shop_order_id');
    }

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    public function telegramAd()
    {
        return $this->belongsTo(TelegramAd::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
