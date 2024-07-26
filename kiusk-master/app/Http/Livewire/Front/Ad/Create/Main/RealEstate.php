<?php

namespace App\Http\Livewire\Front\Ad\Create\Main;

use App\Models\Ad\Facility;
use App\Models\Ad\RealEstateDetail;
use Illuminate\Validation\Rule;
use stdClass;

trait RealEstate
{
    public $facilities = null;
    public $realEstate;
    public $rooms;
    public $sale_price;
    public $rent_price;
    public $mortgage_price;
    public $area;
    public $area_unit;
    public $bathroom;
    public $yearly_tax;
    public $price_keep;
    public $construction_year;
    public $availability_date;
    public $facility;
    public $nearby_facilities;
    public $building_facilities;
    public $unit_facilities;
    public $floor;
    public $elevator;
    public $warehouse;
    public $balcony;

    /**
     * Validate the Real estate detials
     *
     * @return void
     */
    public function validateRelaEstateDetails()
    {
        $this->validate(
            [
                'rooms' => [Rule::requiredIf($this->propertyType !== 'land'), 'nullable', 'numeric', 'min:0', 'max:1000'],
                'bathroom' => 'nullable|string|min:0|max:1000',
                'area' => 'required|numeric',
                'availability_date' => [Rule::requiredIf($this->propertyType !== 'land'), 'nullable', 'date', 'after_or_equal:today'],
                'floor' => 'nullable|numeric',
                'sale_price' => [Rule::requiredIf($this->categorySaleType === 'sale'), 'nullable', 'numeric', 'min:0', 'max:99999999'],
                'yearly_tax' => [Rule::requiredIf($this->categorySaleType === 'sale'), 'nullable', 'numeric', 'min:0', 'max:99999999'],
                'price_keep' => [Rule::requiredIf($this->categorySaleType === 'sale' && $this->propertyType !== 'land'), 'nullable', 'numeric', 'min:0', 'max:99999999'],
                'rent_price' => [Rule::requiredIf($this->categorySaleType === 'rent'), 'nullable', 'numeric', 'min:0', 'max:99999999'],
                'mortgage_price' => [Rule::requiredIf($this->categorySaleType === 'rent'), 'nullable', 'numeric', 'min:0', 'max:99999999'],
                'area_unit' => 'required|in:' . implode(",", array_keys(RealEstateDetail::AREA_UNIT)),
                'construction_year' => [Rule::requiredIf($this->propertyType !== 'land'), 'nullable', 'numeric', 'min:1800', 'max:' . now()->year],
            ]
        );
    }

}
