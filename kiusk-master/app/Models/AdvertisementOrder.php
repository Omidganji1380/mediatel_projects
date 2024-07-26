<?php

namespace App\Models;

use App\Models\Address\City;
use App\Models\Address\State;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\ModelStatus\HasStatuses;

class AdvertisementOrder extends Model implements HasMedia
{
    use HasFactory, HasStatuses, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'advertisement_type_id',
        'days',
        'price',
        'discount',
        'total_price',
        'first_name',
        'last_name',
        'email',
        'country_code',
        'phone',
        'phone_2',
        'business_name',
        'postal_code',
        "state_id",
        "city_id",
        'title',
        'title_en',
        'description_fa',
        'description_en',
        'currency',
        'exclusive_design',
        'extra',
        'category_id',
        'website',
        'url',
    ];

    protected $appends = ['phone_with_code'];

    protected $casts = [
        'extra' => 'json',
        'exclusive_design' => 'boolean',
    ];

    public const STATUS = [
        'draft' => 'پیش نویس',
        'published' => 'منتشر شده',
        'pending' => 'در انتظار تایید',
        'pending_payment' => 'در انتظار پرداخت',
        'payment_completed' => 'پرداخت شده',
    ];

    /**
     * Get Status Color
     *
     * @return string
     */
    public function getStatusColorAttribute()
    {
        $statuses = [
            'pending_payment' => 'primary',
            'published' => 'success',
            'COMPLETED' => 'success',
            'CANCELED' => 'warning',
        ];
        return $statuses[$this->status] ?? 'info';
    }

    /**
     * Get Phone With Code
     *
     * @return string
     */
    public function getPhoneWithCodeAttribute()
    {
        return $this->country_code . ' ' . $this->phone;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function advertisementType()
    {
        return $this->belongsTo(AdvertisementType::class, 'advertisement_type_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function design()
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', 'design');
    }

    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }
}
