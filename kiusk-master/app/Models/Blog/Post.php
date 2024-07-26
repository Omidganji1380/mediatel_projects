<?php

namespace App\Models\Blog;

use App\Jobs\SitemapGenerateJob;
use App\Models\Lib\ClearsResponseCache;
use App\Models\Log;
use App\Models\Rating;
use App\Models\Redirect;
use App\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\HasTags;
use Str;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use HasTags;
    use InteractsWithMedia;
    use ClearsResponseCache;
    use Sluggable;

    /**
     * @var string
     */
    protected $table = 'blog_posts';
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'old_slug',
        'current_url' ,
        'old_url',
        'rel_canonical',
        'lang',
        'content',
        'excerpt',
        'is_visible',
        'published_at',
        'seo_title',
        'seo_description',
        'user_id',
        'views',
        'extra',
        'created_at',
        'updated_at',
        'title_en',
        'content_en',
        'excerpt_en',
        'seo_title_en',
        'seo_description_en',
        'no_index',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => SitemapGenerateJob::class,
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'date',
    ];

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
     * Get the ad's locale name.
     *
     * @return string
     */
    public function getLocaleTitleAttribute()
    {
        return config('app.locale') == 'fa' ? $this->title : ucfirst($this->title_en);
    }

    /**
     * Get the ad's locale name.
     *
     * @return string
     */
    public function getLocaleContentAttribute()
    {
        return config('app.locale') == 'fa' ? $this->content : ucfirst($this->content_en);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'blog_category_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'blog_post_id');
    }

    public function favorites()
    {
        return $this->hasMany(BlogFavorite::class, 'blog_id');
    }

    public function redirect()
    {
        return $this->morphOne(Redirect::class, 'redirectable');
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

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->crop(Manipulations::CROP_CENTER, 400, 333)
            ->performOnCollections('SpecialImage')
            ->nonQueued();
        $this->addMediaConversion('thumb')
            ->crop(Manipulations::CROP_CENTER, 400, 333)
            ->performOnCollections('SpecialImageEn')
            ->nonQueued();
        //  $this->addMediaConversion('singlePage')
        //       ->crop(Manipulations::CROP_CENTER, 641, 534)
        //       ->performOnCollections('SpecialImage');
        // $this->addMediaConversion('150_150')
        //     ->crop(Manipulations::CROP_CENTER, 150, 150)
        //     ->performOnCollections('SpecialImage');
        //  $this->addMediaConversion('300x300')
        //       ->crop(Manipulations::CROP_CENTER, 150, 150)
        //       ->performOnCollections('SpecialImage','gallery');
    }

    public function getLinkAttribute()
    {
        $t = jdate($this->created_at);

        // return route('front.blog.show', [
        //     $t->getYear(),
        //     $t->getMonth(),
        //     $t->getDay(),
        //     $this->slug,
        // ]);
        $lang = config('app.locale') === 'fa' ? '' : 'en.';
        return route($lang . 'front.blog.show', $this->slug);
    }

    public function getOldLinkAttribute()
    {
        $t = jdate($this->created_at);

        return route('front.blog.old.show', [
            $t->getYear(),
            $t->getMonth(),
            $t->getDay(),
            $this->old_slug ?? $this->slug,
        ]);
        // return route('front.blog.show', $this->slug);
    }

    public function getLimitContentAttribute()
    {
        $content = Str::replace($this->locale_title, '', $this->locale_content);
        $content = strip_tags($content);

        return Str::limit($content);
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

    public function scopeLang($query)
    {
        $query->whereLang(config('app.locale'));
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'loggable');
    }

    public function log()
    {
        return $this->morphOne(Log::class, 'loggable')->orderByDesc('created_at');
    }


    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable');
    }
}
