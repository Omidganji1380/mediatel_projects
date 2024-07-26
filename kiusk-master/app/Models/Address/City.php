<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;

class City extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasTags;

    /**
     * @var string
     */
    protected $table = 'address_cities';
    /**
     * @var array<int, string>
     */
    protected $fillable = [
     'name',
     'slug',
     'state_id',
     'seo_title',
     'seo_description',
     'name_en',
    ];

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
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
