<?php

namespace App\Models;

use App\Models\Ad\Ad;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 'plan_id', 'ad_id' ,'title', 'price', 'invoice_period', 'invoice_interval', 'description',
        'tax', 'total_price', 'model_type', 'model_id'
    ];

    /**
     * Cart belongs to user
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Cart belongs to user
     *
     * @return BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Cart belongs to user
     *
     * @return BelongsTo
     */
    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

}
