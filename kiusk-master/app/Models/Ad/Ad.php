<?php

namespace App\Models\Ad;

use App\Jobs\SitemapGenerateJob;
use App\Models\Address\City;
use App\Models\Address\State;
use App\Models\Lib\ClearsResponseCache;
use App\Models\LinkClick;
use App\Models\Log;
use App\Models\Payment\Payment;
use App\Models\PlanSubscription;
use App\Models\Rating;
use App\Models\Redirect;
use App\Models\ResponseMessage;
use App\Models\ServiceUsage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\HasTags;
use Spatie\ModelStatus\HasStatuses;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ad extends Model implements HasMedia, Sortable
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;
    use HasTags;
    use ClearsResponseCache;
    use SortableTrait;
    use HasStatuses;
    use Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'content_html',
        'excerpt',
        'is_visible',
        'is_featured',
        'price',
        'is_visible_email',
        'is_visible_phone',
        'phone',
        'email',
        'seo_title',
        'seo_description',
        'views',
        'extra',
        'user_id',
        'state_id',
        'city_id',
        'old_slug',
        'created_at',
        'updated_at',
        'title_en',
        'seo_title_en',
        'seo_description_en',
        'content_en',
        'excerpt_en',
        'telegram_message_id',
        'is_sidebar_featured',
        'is_suggestion_featured',
        'rel_canonical',
        'no_index',
        'subscription_end_date',
        'is_property_applicant',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'is_featured' => 'boolean',
        'is_visible_email' => 'boolean',
        'is_visible_phone' => 'boolean',
        'extra' => 'json',
        'created_at' => 'datetime',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        // 'saved' => SitemapGenerateJob::class,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['locale_title', 'locale_content', 'locale_excerpt'];

    /**
     * Media collections
     *
     * @var array
     */
    // protected $mediaCollections = [
    //     'SpecialImage',
    //     'SpecialImageEn',
    // ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title_en'
            ]
        ];
    }

    /**
     * Get the ad's locale description.
     *
     * @return string
     */
    public function getLocaleContentAttribute()
    {
        return config('app.locale') == 'fa' ? $this->content : $this->content_en;
    }

    /**
     * Get the ad's locale description.
     *
     * @return string
     */
    public function getLocaleExcerptAttribute()
    {
        return config('app.locale') == 'fa' ? $this->excerpt : $this->excerpt_en;
    }

    /**
     * Get the ad's locale name.
     *
     * @return string
     */
    public function getLocaleTitleAttribute()
    {
        return config('app.locale') == 'fa' ? $this->title : ucfirst($this->title_en);
    }

    public function getExpiredAttribute()
    {
        return $this->subscription_end_date ? $this->subscription_end_date <= Carbon::today() : true;
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(self::getTagClassName(), 'taggable', 'taggables', null, 'tag_id')
            ->orderBy('order_column');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function redirect()
    {
        return $this->morphOne(Redirect::class, 'redirectable');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'ad_category_pivot', 'ad_id', 'ad_category_id')
            ->withPivot('is_main')
            ->withTimestamps();
    }

    public function mainCategory()
    {
        return $this->belongsToMany(Category::class, 'ad_category_pivot', 'ad_id', 'ad_category_id')
            ->wherePivot('is_main', 1);
    }

    public function linkClick()
    {
        return $this->morphOne(LinkClick::class, 'clickable');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function attrs(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'ad_attribute_pivot', 'ad_id', 'ad_attribute_id')
            ->withPivot('text', 'boolean', 'integer', 'float', 'date_time', 'date', 'json',)
            ->withTimestamps();
    }

    public function attrs2(): HasMany
    {
        return $this->hasMany(AdAttribute::class);
    }

    // public function specialImage()
    // {
    //  return $this->media()
    //              ->first();
    // }
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaCollection('SpecialImage')
            //   ->useFallbackUrl('https://www.google.com/images/branding/googlelogo/1x/googlelogo_light_color_272x92dp.png');
            ->useFallbackPath(public_path('/images/hero-background-icons (1).jpg'));
            // ->nonQueued();
        $this->addMediaCollection('SpecialImageEn')
            ->useFallbackPath(public_path('/images/hero-background-icons (1).jpg'));
            // ->nonQueued();
        //  $this->addMediaConversion('thumb0')
        //       ->fit(Manipulations::FIT_CROP, 400, 333)
        //       ->performOnCollections('Gallery', 'SpecialImage');
        //  $this->addMediaConversion('thumb1')
        //       ->fit(Manipulations::FIT_CONTAIN, 400, 333)
        //       ->performOnCollections('Gallery', 'SpecialImage');
        //  $this->addMediaConversion('thumb2')
        //       ->fit(Manipulations::FIT_FILL, 400, 333)
        //       ->performOnCollections('Gallery', 'SpecialImage');
        //  $this->addMediaConversion('thumb3')
        //       ->fit(Manipulations::FIT_MAX, 400, 333)
        //       ->performOnCollections('Gallery', 'SpecialImage');
        //  $this->addMediaConversion('thumb4')
        //       ->fit(Manipulations::FIT_STRETCH, 400, 333)
        //       ->performOnCollections('Gallery', 'SpecialImage');
        $this->addMediaConversion('thumb')
            //   ->useFallbackUrl('/images/anonymous-user.jpg')
            //   ->useFallbackPath(public_path('/images/anonymous-user.jpg'))
            ->fit(Manipulations::FIT_STRETCH, 400, 333)
            ->performOnCollections('SpecialImage', 'SpecialImageEn')->nonQueued();
        $this->addMediaConversion('70_70')
            ->crop(Manipulations::CROP_CENTER, 70, 70)
            ->performOnCollections('SpecialImage', 'SpecialImageEn')->nonQueued();
    }

    public function getShortLinkAttribute()
    {
        $id = null;
        if (isset($this->extra->wordpressId)) {
            $id = $this->extra->wordpressId;
        } else {
            $id = $this->id;
        }

        return route('front.home', ['p' => $id]);
    }

    public function setExtraAttribute($value)
    {
        if ($value) {
            $this->attributes['extra'] = json_encode($value);
        } else {
            $this->attributes['extra'] = json_encode([]);
        }
    }

    public function getExtraAttribute()
    {
        if (isset($this->attributes['extra'])) {
            return json_decode($this->attributes['extra']);
        }
        //  return new \stdClass();
    }

    public function getSeoTitleReadyAttribute()
    {
        $list = [
            '%%sep%%' => '|',
            '%%sitename%%' => 'کیوسک',
            '%%title%%' => '',
        ];
        foreach ($list as $k => $v) {
            if ($k == '%%title%%' && !$v) {
                $v = $this->attributes['title'];
            }
            $value = str_replace($k, $v, $value);
        }

        return $value;
    }

    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function getContentAttribute($value)
    {
        if($value){
            $stringWithPs = str_replace("\n\n", "</p><p>", $value);
            $stringWithPs = str_replace("\r\n", "</p><p>", $stringWithPs);
            $stringWithPs = str_replace("\n", "</p><p>", $stringWithPs);
            $stringWithPs = "<p>" . $stringWithPs . "</p>";
            $stringWithPs = str_replace("<p></p>", "", $stringWithPs);
            foreach ([
                'h1',
                'h2',
                'h3',
                'h4',
                'h5',
                'h6',
                'li',
                'ul',
                'ol',
                'p',
            ] as $item) {
                $stringWithPs = str_replace("<p><" . $item, "<" . $item, $stringWithPs);
                $stringWithPs = str_replace("</" . $item . "></p>", "</" . $item . ">", $stringWithPs);
            }

            return $stringWithPs;
        }
        return $value;
    }

    public function getContentStripAttribute()
    {
        return strip_tags($this->original['content']);
    }

    /**
     * Is Featured Scope
     *
     * @param Builder $query
     * @return void
     */
    public function scopeIsFeatured($query)
    {
        $query->where('is_featured', 1);
    }

    /**
     * Is Featured Scope
     *
     * @param Builder $query
     * @return void
     */
    public function scopeIsPropertyApplicant($query)
    {
        $query->where('is_property_applicant', 1);
    }

    /**
     * Is Visible Scope
     *
     * @param Builder $query
     * @return void
     */
    public function scopeIsVisible($query)
    {
        $query->where('is_visible', 1);
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'loggable');
    }

    public function log()
    {
        return $this->morphOne(Log::class, 'loggable')->orderByDesc('created_at');
    }

    public function realEstateDetail()
    {
        return $this->hasOne(RealEstateDetail::class);
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class);
    }

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable');
    }

    public function responses()
    {
        return $this->morphMany(ResponseMessage::class, 'responseable');
    }

    public function serviceUsages()
    {
        return $this->hasMany(ServiceUsage::class);
    }

    public function subscription()
    {
        return $this->hasOne(PlanSubscription::class, 'model_id')->where('type', 'ad');
    }

    public function activeSubscription()
    {
        return $this->hasOne(PlanSubscription::class, 'model_id')
            ->where('is_active', true)
            ->where('type', 'ad');
    }
}
