<?php

namespace App\Models\Ad;

use App\Jobs\SitemapGenerateJob;
use App\Models\Lib\ClearsResponseCache;
use App\Models\Redirect;
use App\Models\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;

class Category extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;
    use ClearsResponseCache;
    use HasTags;
    use NodeTrait;

    /**
     * @var string
     */
    protected $table = 'ad_categories';
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'position',
        'is_visible',
        'has_banner',
        'seo_title',
        'seo_description',
        'attributes',
        'parent_id',
        'name_en',
        'description_en',
        'full_description',
        'full_description_en',
        'tag_line',
        'tag_line_en',
        'old_slug',
        'current_url',
        'old_url',
        '_lft',
        '_rgt',
        'show_in_telegram',
        'emoji',
        'type',
        'sale_type',
        'property_type',
        'extra',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => SitemapGenerateJob::class,
    ];

    public const NAV_ICONS = [
        'buying-and-selling-new-and-used-goods' => 'shopping-cart',
        'iranian-businesses-in-canada' => 'briefcase',
        'property' => 'building',
        'default' => 'circle'
    ];

    public const TYPES = [
        'business_owner' => 'شغل',
        'real_estate' => 'مشاور املاک',
        'seller' => 'فروش کالا',
        'property_applicant' => 'متقاضی ملک',
    ];

    public const SALE_TYPES = [
        'rent' => 'اجاره',
        'sale' => 'فروش',
    ];

    public const PROPERTY_TYPES = [
        'land' => 'زمین',
        'house' => 'خانه',
        'apartment' => 'آپارتمان',
        'commercial' => 'تجاری',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['locale_name', 'locale_description', 'locale_full_description', 'locale_tag_line', 'name_with_emoji', 'extra_as_object'];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_visible' => 'boolean',
        'attributes' => 'json',
        // 'extra' => 'object',
        'extra' => 'json',
    ];

    public function getExtraAsObjectAttribute()
    {
        // return json_decode($this->extra);
    }

    /**
     * Get the category's locale description.
     *
     * @return string
     */
    public function getLocaleDescriptionAttribute()
    {
        return config('app.locale') == 'fa' ? $this->description : $this->description_en;
    }

    /**
     * Get the category's locale description.
     *
     * @return string
     */
    public function getLocaleFullDescriptionAttribute()
    {
        return config('app.locale') == 'fa' ? $this->full_description : $this->full_description_en;
    }
    /**
     * Get the category's locale description.
     *
     * @return string
     */
    public function getLocaleTagLineAttribute()
    {
        return config('app.locale') == 'fa' ? $this->tag_line : $this->tag_line_en;
    }

    /**
     * Get the category's locale name.
     *
     * @return string
     */
    public function getLocaleNameAttribute()
    {
        return (auth()?->user()?->lang == 'fa' || config('app.locale') == 'fa') ? $this->name : ucfirst($this->name_en);
    }
    /**
     * Get the category's locale name.
     *
     * @return string
     */
    public function getNameWithEmojiAttribute()
    {
        return (auth()?->user()?->lang == 'fa' || config('app.locale') == 'fa')
            ? $this->name . ' ' . $this->emoji :
            ucfirst($this->name_en) . ' ' . $this->emoji;
    }

    // public function children(): HasMany
    // {
    //     return $this->hasMany(Category::class, 'parent_id');
    // }

    // public function parent(): BelongsTo
    // {
    //     return $this->belongsTo(Category::class, 'parent_id');
    // }

    // public function descendants()
    // {
    //     return $this->children()->with('descendants');
    // }

    public function ads(): belongsToMany
    {
        return $this->belongsToMany(Ad::class, 'ad_category_pivot', 'ad_id', 'ad_category_id')
            ->withPivot('is_main')
            ->withTimestamps();
    }

    public function attrs(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'ad_attribute_category_pivot', 'ad_category_id', 'ad_attribute_id');
    }

    public function redirect()
    {
        return $this->morphOne(Redirect::class, 'redirectable');
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'loggable');
    }

    public function log()
    {
        return $this->morphOne(Log::class, 'loggable')->orderByDesc('created_at');
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
}
