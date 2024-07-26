<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;

class State extends Model implements HasMedia
{
    use HasTags;
    use HasFactory;
    use InteractsWithMedia;

    /**
     * @var string
     */
    protected $table = 'address_states';
    /**
     * @var array<int, string>
     */
    protected $fillable = [
     'name',
     'slug',
     'seo_title',
     'seo_description',
     'name_en'
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    /**
     * Get the category's locale name.
     *
     * @return string
     */
    public function getLocaleNameAttribute()
    {
        return config('app.locale') == 'fa' ? $this->name : ucfirst($this->name_en);
    }
}
