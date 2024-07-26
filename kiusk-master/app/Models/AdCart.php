<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'advertisement_type_id',
        'advertisement_order_id',
        'title',
        'price',
        'invoice_period',
        'description',
        'tax',
        'total_price'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function advertisementType()
    {
        return $this->belongsTo(AdvertisementType::class);
    }

    public function advertisementOrder()
    {
        return $this->belongsTo(AdvertisementOrder::class);
    }
}
