<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Promotion extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'name_en',
        'slug',
        'url',
        'icon',
        'background_color',
        'text_color',
        'description',
        'description_en',
        'is_visible',
        'position',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public const COLORS = [
        'primary' => 'primary',
        'secondary' => 'secondary',
        'black' => 'black',
        'dark' => 'dark',
        'danger' => 'danger',
        'info' => 'info',
        'light' => 'light',
        'success' => 'success',
        'transparent' => 'transparent',
        'warning' => 'warning',
        'white' => 'white',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['locale_name', 'locale_description'];


    /**
     * Get the category's locale description.
     *
     * @return string
     */
    public function getLocaleDescriptionAttribute()
    {
        return (auth()?->user()?->lang == 'fa' || config('app.locale') == 'fa') == 'fa' ? $this->description : $this->description_en;
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
    public function scopeActive($query)
    {
        return $query->where('is_visible', true);
    }

}
