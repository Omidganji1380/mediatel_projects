<?php

namespace App\Models\Blog;

use App\Models\Lib\ClearsResponseCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;

class Category extends Model implements HasMedia
{
    use HasFactory;
    use ClearsResponseCache;
    use InteractsWithMedia;
    use HasTags;

    /**
     * @var string
     */
    protected $table = 'blog_categories';
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'seo_title',
        'seo_description',
        'is_visible',
        'name_en',
        'description_en',
        'seo_title_en',
        'seo_description_en',
    ];
    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_visible' => 'boolean',
    ];

    /**
     * Get the category's locale name.
     *
     * @return string
     */
    public function getLocaleNameAttribute()
    {
        return  (auth()?->user()?->lang == 'fa' || config('app.locale') == 'fa') ? $this->name : ucfirst($this->name_en);
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

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function redirect()
    {
        return $this->morphOne(Redirect::class, 'redirectable');
    }
}
