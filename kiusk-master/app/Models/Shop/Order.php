<?php

namespace App\Models\Shop;

use App\Models\Plan;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'shop_orders';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'number',
        'shop_customer_id',
        'total_price',
        'status',
        'order_status',
        'currency',
        'shipping_price',
        'shipping_method',
        'notes',
        'tax',
        'price',
        'plan_id',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'shop_customer_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'shop_order_id');
    }

    public function orderItem()
    {
        return $this->hasOne(OrderItem::class, 'shop_order_id');
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
