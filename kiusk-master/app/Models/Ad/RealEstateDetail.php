<?php

namespace App\Models\Ad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealEstateDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_id',
        'rooms',
        'sale_price',
        'rent_price',
        'area',
        'area_unit',
        'bathroom',
        'yearly_tax',
        'price_keep',
        'construction_year',
        'mls_number',
        'availability_date',
        'show_tel',
        'show_email',
        'facilities',
        'nearby_facilities',
        'building_facilities',
        'unit_facilities',
        'start_date',
        'end_date',
        'post_type',
        'mortgage_price',
        'user_type',
        'floor',
        'elevator',
        'warehouse',
        'balcony',
    ];

    protected $casts = [
        'availability_date' => 'date'
    ];

    public const AREA_UNIT = [
        'square_meter' => 'متر مربع',
        'square_feet' => 'فوت مربع',
    ];

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }
}
