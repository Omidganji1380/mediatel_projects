<?php

namespace App\Http\Livewire\Front\Ad\Create\Main;

use App\Models\Ad\Facility as AdFacility;
use App\Rules\FacilityRule;
use Database\Factories\Ad\AdFactory;
use stdClass;

trait Facility
{
    public $facilities = null;
    public $selectedFacilities;
    public $adFacilities = [];


    public function getFacilities()
    {
        $this->facilities = AdFacility::all();
    }

    public function validateFacilities()
    {
        $this->validate([
            'adFacilities' => ['nullable', 'array', new FacilityRule],
        ]);
    }

    public function getSelectedFacilities()
    {
        $selectedFacilities = AdFacility::whereIn('id', array_keys($this->adFacilities))->get()->groupBy('type');
        $this->selectedFacilities = collect($selectedFacilities);
    }
}
