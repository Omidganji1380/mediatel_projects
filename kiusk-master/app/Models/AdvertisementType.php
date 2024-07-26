<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AdvertisementType extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name_fa',
        'name_en',
        'description_fa',
        'description_en',
        'days',
        'price',
        'position',
        'slug',
        'is_visible'
    ];

    public const POSITIONS = [
        'post_sidebar' => 'سایدبار آگهی ها',
        'blog_sidebar' => 'سایدبار مقالات',
        'blog_end' => 'انتهای مقالات',
        'blog_between' => 'بین مقالات',
        'main_page' => 'صفحه اصلی',
    ];

    public const PRICES = [
        1 => 10,
        2 => 16,
        3 => 21,
        4 => 24,
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_visible' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name', 'description'];

    public function getNameAttribute()
    {
        return config('app.locale') == 'fa' ?  $this->name_fa : $this->name_en;
    }

    public function getDescriptionAttribute()
    {
        return config('app.locale') == 'fa' ?  $this->description_fa : $this->description_en;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaCollection('image');
        $this->addMediaConversion('thumb')
            ->crop(Manipulations::CROP_CENTER, 400, 333)
            ->performOnCollections('image')
            ->nonQueued();
        $this->addMediaConversion('150_150')
            ->crop(Manipulations::CROP_CENTER, 150, 150)
            ->performOnCollections('image')
            ->nonQueued();
    }
}
