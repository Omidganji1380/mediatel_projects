<div class="col-11 m-auto">
    <div class="alert alert-primary" role="alert">
        <div class="d-flex justify-content-between">
            <p> {{ __('You are posting an ad in the category') }}
                {{ \App\Models\Ad\Category::find($selectedCategory)->locale_name }} </p>
            <button class="btn-primary p-1" wire:click="goTo('category')">{{ __('Change Category') }}
            </button>
        </div>
    </div>
</div>
<div class="col-11 m-auto ">
    <div class="section-title clearfix">
        <h2>{{ __('Real Estate Facilities') }} </h2>
    </div>
    <form class="row g-3 position-relative">
        <div class="loading " wire:loading.class="loading_show" wire:target="goTo">
            <div class="loader-show"></div>
        </div>
        <div class="row g-3">
            <div class="col-md-12">
                @if ($facilities)
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="accordion" id="accordionExample">
                        <!-- Parkings -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="parkingFacility">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#parking" aria-expanded="true" aria-controls="parking">
                                    {{ __('Parkings') }}
                                </button>
                            </h2>
                            <div id="parking" class="accordion-collapse collapse show"
                                aria-labelledby="parkingFacility" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    @foreach ($facilities->where('type', 'parking') as $parking)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                wire:model.defer="adFacilities.{{ $parking->id }}" id="gridCheck">
                                            <label class="form-check-label" for="gridCheck">
                                                {{ $parking->locale_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- General Facilities -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="generalFacility">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#facility" aria-expanded="false" aria-controls="facility">
                                    {{ __('General Facilities') }}
                                </button>
                            </h2>
                            <div id="facility" class="accordion-collapse collapse" aria-labelledby="generalFacility"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    @foreach ($facilities->where('type', 'facility') as $facility)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                wire:model.defer="adFacilities.{{ $facility->id }}" id="gridCheck">
                                            <label class="form-check-label" for="gridCheck">
                                                {{ $facility->locale_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Nearby Facilities -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="nearbyFacilities">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#nearby_facility" aria-expanded="false"
                                    aria-controls="nearby_facility">
                                    {{ __('Nearby Facilities') }}
                                </button>
                            </h2>
                            <div id="nearby_facility" class="accordion-collapse collapse"
                                aria-labelledby="nearbyFacilities" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    @foreach ($facilities->where('type', 'nearby_facility') as $nearbyFacilities)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                wire:model.defer="adFacilities.{{ $nearbyFacilities->id }}"
                                                id="gridCheck">
                                            <label class="form-check-label" for="gridCheck">
                                                {{ $nearbyFacilities->locale_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Building Facilities -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="buildingFacilities">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#building_facility" aria-expanded="false"
                                    aria-controls="building_facility">
                                    {{ __('Building Facilities') }}
                                </button>
                            </h2>
                            <div id="building_facility" class="accordion-collapse collapse"
                                aria-labelledby="buildingFacilities" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    @foreach ($facilities->where('type', 'building_facility') as $buildingFacilities)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                wire:model.defer="adFacilities.{{ $buildingFacilities->id }}"
                                                id="gridCheck">
                                            <label class="form-check-label" for="gridCheck">
                                                {{ $buildingFacilities->locale_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Unit Facilities -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="unitFacilities">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#unit_facility" aria-expanded="false"
                                    aria-controls="unit_facility">
                                    {{ __('Unit Facilities') }}
                                </button>
                            </h2>
                            <div id="unit_facility" class="accordion-collapse collapse"
                                aria-labelledby="unitFacilities" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    @foreach ($facilities->where('type', 'unit_facility') as $unitFacilities)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                wire:model.defer="adFacilities.{{ $unitFacilities->id }}"
                                                id="gridCheck">
                                            <label class="form-check-label" for="gridCheck">
                                                {{ $unitFacilities->locale_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>
<div class="col-12 mt-5 d-flex justify-content-between">
    <button type="submit" class="btn btn-primary" wire:click="goTo('realEstateDetails')">{{ __('Previous Stage') }}
    </button>
    <button type="submit" class="btn btn-success" wire:click="goTo('realEstateReview')">{{ __('Next Stage') }}
    </button>
</div>
