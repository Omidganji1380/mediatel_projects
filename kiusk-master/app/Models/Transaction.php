<?php

namespace App\Models;

use App\Models\Shop\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends Model
{
    use HasFactory;

    public const PAYMENT_METHOD_PAYPAL= "paypal";

    protected $fillable = [
        'order_id', 'user_id', 'reference_id', 'mode', 'status', 'total_price', 'discount',
        'transactionable_type', 'transactionable_id', 'tax'
    ];

    /**
     * Belongs To relation
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Belongs To relation
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * transaction
     *
     * @return MorphTo
     */
    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }
}
