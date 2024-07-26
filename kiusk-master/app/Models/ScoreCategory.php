<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreCategory extends Model
{
    use HasFactory;

    /**
     *
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'name_en',
        'description',
        'description_en',
        'require_score',
        'discount_percentage',
        'is_active',
        'type',
        'extra',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'extra' => 'json',
    ];

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
     * Get the category's locale description.
     *
     * @return string
     */
    public function getLocaleDescriptionAttribute()
    {
        return config('app.locale') == 'fa' ? $this->description : $this->description_en;
    }

}
