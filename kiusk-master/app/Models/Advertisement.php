<?php

namespace App\Models;

use App\Models\Lib\ClearsResponseCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Advertisement extends Model implements HasMedia
{
    use HasFactory, HasStatuses, InteractsWithMedia, ClearsResponseCache;

    protected $fillable = [
        'user_id',
        'advertisement_type_id',
        'advertisement_order_id',
        'days',
        'title',
        'title_en',
        'description_fa',
        'description_en',
        'exclusive_design',
        'active',
        'position',
        'link',
        'extra',
    ];

    protected $casts = [
        'exclusive_design' => 'boolean',
        'active' => 'boolean',
        'extra' => 'json',
    ];

    public const STATUS = [
        'draft' => 'پیش نویس',
        'published' => 'منتشر شده',
        'pending' => 'در انتظار تایید',
        'pending_payment' => 'در انتظار پرداخت',
        'payment_completed' => 'پرداخت شده',
        'canceled' => 'لغو شده',
        'expired' => 'منقضی شده',
        'reported' => 'گزارش شده',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function advertisementType()
    {
        return $this->belongsTo(AdvertisementType::class);
    }

    public function adOrder()
    {
        return $this->belongsTo(AdvertisementOrder::class, 'advertisement_order_id');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable')->where('type', 'ad');
    }

    public function order()
    {
        return $this->morphOne(Order::class, 'orderable');
    }

    public function scopePublished($query)
    {
        $query->currentStatus('published');
    }

    public function scopeActive($query)
    {
        $query->where('active', true);
    }

    /**
     * Get the add http to links.
     *
     * @param  string  $value
     * @return string
     */
    public function getLinkAttribute($value)
    {
        return Str::contains($value, ['https://', 'http://']) ? $value : 'https://' . $value;
    }

    public function logs()
    {
        return $this->morphOne(Log::class, 'loggable')->orderByDesc('created_at');
    }
}
