<?php

namespace App\Models\Ad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fa_name', 'en_name', 'type',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['locale_name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public const FACILITY_TYPES = [
        'facility' => 'تسهیلات',
        'nearby_facility' => 'تسهیلات اطراف',
        'building_facility' => 'تسهیلات ساختمان',
        'unit_facility' => 'تسهیلات واحد',
        'parking' => 'پارکینگ',
    ];

    /**
     * Get the category's locale name.
     *
     * @return string
     */
    public function getLocaleNameAttribute()
    {
        return (auth()?->user()?->lang == 'fa' || config('app.locale') == 'fa') ? $this->fa_name : ucfirst($this->en_name);
    }

    public function ads()
    {
        return $this->belongsToMany(Facility::class);
    }
}
