<div>
    <div class="row">
        <div class="col">
            <a class="rounded-pill p-1 ps-2 pe-2 btn btn-ads me-3 me-md-0
                position-absolute end-0"
                href="{{ route($lang . 'front.ad.show', $ad->slug) }}" style="width:110px">
                {{ __('Show') }} <i class="fa fa-plus mx-2"></i>
            </a>
        </div>
    </div>
    <div class="section-title clearfix">
        <h2>{{ __('Ad Info') }} </h2>
    </div>
    <form class="row g-3">
        <div class="col-md-12">
            <label for="title" class="form-label">{{ __('Ad Persian Title') }}</label>
            <input type="text" wire:model="ad.title" class="form-control  @error('ad.title') is-invalid @enderror"
                id="title">
            @error('ad.title')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-12">
            <label for="title_en" class="form-label">{{ __('Ad English Title') }}</label>
            <input type="text" wire:model="ad.title_en" class="form-control  @error('ad.title_en') is-invalid @enderror"
                id="title_en">
            @error('ad.title_en')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div>
        {{-- <div class="col-md-4 price-2 position-relative">
            <label for="inputPassword4price" class="form-label">{{ __('Price') }}</label>
            <input type="number" style="direction: rtl !important;" wire:model="ad.price"
                class="form-control  @error('ad.price') is-invalid @enderror" id="inputPassword4price">
            @error('ad.price')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div> --}}
        <div class="col-md-6">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="email" disabled value="{{ auth()->user()->email }}" class="form-control" id="email"
                placeholder="{{ __('Email') }}">
        </div>
        <div class="col-md-6">
            <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
            <input type="text" disabled value="{{ auth()->user()->phone }}" class="form-control " id="phone"
                placeholder="{{ __('Phone Number') }}">
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" wire:model="showEmail" id="gridCheck">
                <label class="form-check-label" for="gridCheck">
                    {{ __('Display email in ad') }}
                </label>
            </div>
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" wire:model="showPhone" id="show_phone">
                <label class="form-check-label" for="show_phone">
                    {{ __('Display phone number in ad') }}
                </label>
            </div>
        </div>
        <div class="form-floating">
            <textarea class="form-control @error('content') is-invalid @enderror" wire:model="content"
                placeholder="{{ __('Ad Persian Description') }}" id="floatingTextarea2" style="height: 200px !important"></textarea>
            <label for="floatingTextarea2">{{ __('Ad Description') }}</label>
            @error('content')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-floating">
            <textarea class="form-control @error('content_en') is-invalid @enderror" wire:model="content_en"
                placeholder="{{ __('Ad Description') }}" id="content_en" style="height: 200px !important"></textarea>
            <label for="content_en">{{ __('Ad English Description') }}</label>
            @error('content_en')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="row g-3">
            <div class="col">
                <select class="form-select @error('ad.state_id') is-invalid @enderror" wire:model="ad.state_id"
                    aria-label="Default select example">
                    <option selected>{{ __('State') }}</option>
                    @foreach (\App\Models\Address\State::all() as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
                @error('ad.state_id')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col">
                <select class="form-select @error('ad.city_id') is-invalid @enderror" wire:model="ad.city_id"
                    aria-label="Default select example">
                    <option selected>{{ __('City') }}</option>
                    @foreach (\App\Models\Address\City::whereStateId($ad->state_id)->get() as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
                @error('ad.city_id')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="row g-3">
                @include('front.pages.ads.create.attributes', ['formAttributes' => $formAttributes])
            </div>
            <div class="section-title clearfix ">
                <h2>{{ __('Ad Imags') }}</h2>
            </div>
            <p class="text-center">{{ __('Adding a photo will increase your ad views up to three times.') }}</p>
            <div class="container-file ">
                <div class="dropzone">
                    <label for="files" class="dropzone-container">
                        <div class="file-icon">+</div>
                        <div class="dropzone-title">
                            {{ __('Click to load the image') }}
                        </div>
                        <div class="spinner-border" role="status" wire:loading wire:target="photos">
                            <span class="visually-hidden">{{ __('Loading') }}...</span>
                        </div>
                    </label>
                    <div class="d-flex flex-wrap justify-content-around">
                        @foreach ($previewPhotos as $photo)
                            <div class="position-relative mb-1">
                                <img class="img-thumbnail " height="200" width="200"
                                    src="{{ $photo->original_url }}">
                                <span class="position-absolute right-0 start-100 translate-middle p-2 rounded-circle delete-image-icon">
                                    <i class="fa fa-trash" aria-hidden="true"
                                        wire:click="mediaDelete({{ $photo->id }})"></i>
                                    <span class="visually-hidden">New alerts</span>
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <input id="files" type="file" class="file-input" multiple wire:model="photos" />
                </div>
            </div>
            @php
                $message = '';
            @endphp
            @foreach ($errors->getMessageBag()->messages() as $key => $error)
                @if (Str::is('photos*', $key))
                    @foreach ($error as $e)
                        @php
                            $message .= $e;
                        @endphp
                    @endforeach
                @endif
            @endforeach
            @if ($message)
                <span class=" text-danger">{{ $message }}</span>
            @endif
        </div>

        @if($categoryType === 'real_estate')
        <div class="col-12">
            <div class="section-title clearfix">
                <h2>{{ __('The Property Details') }} </h2>
            </div>
            <form class="row g-3 position-relative">
                <div class="loading " wire:loading.class="loading_show" wire:target="goTo">
                    <div class="loader-show"></div>
                </div>
                @if($ad->mainCategory?->first()?->sale_type === 'sale')
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="sale_price" class="form-label">{{ __('Sale Price') }}</label>
                            <input type="number" wire:model="sale_price"
                                class="form-control mt-0 @error('sale_price') is-invalid @enderror" id="sale_price">
                            @error('sale_price')
                                <span class=" text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="yearly_tax" class="form-label">{{ __('Yearly Tax') }}</label>
                            <input type="number" wire:model="yearly_tax"
                                class="form-control mt-0 @error('yearly_tax') is-invalid @enderror" id="yearly_tax">
                            @error('yearly_tax')
                                <span class=" text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="price_keep" class="form-label">{{ __('Price Keep') }}</label>
                            <input type="number" wire:model="price_keep"
                                class="form-control mt-0 @error('price_keep') is-invalid @enderror" id="price_keep">
                            @error('price_keep')
                                <span class=" text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                @else
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="mortgage_price" class="form-label">{{ __('Mortgage Price') }}</label>
                            <input type="number" wire:model="mortgage_price"
                                class="form-control mt-0 @error('mortgage_price') is-invalid @enderror" id="mortgage_price">
                            @error('mortgage_price')
                                <span class=" text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="rent_price" class="form-label">{{ __('Rent Price') }}</label>
                            <input type="number" wire:model="rent_price"
                                class="form-control mt-0 @error('rent_price') is-invalid @enderror" id="rent_price">
                            @error('rent_price')
                                <span class=" text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="area" class="form-label">{{ __('Area') }}</label>
                        <input type="number" wire:model="area"
                            class="form-control mt-0 @error('area') is-invalid @enderror" id="area">
                        @error('area')
                            <span class=" text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="area_unit" class="form-label">{{ __('Area Unit') }}</label>
                        <select class="form-select @error('area_unit') is-invalid @enderror"
                            wire:model="area_unit" aria-label="Default select example"
                            style="{{ $isEn ? 'background-position: right 0.75rem center;' : 'background-position: left 0.75rem center;' }}"
                            id="area_unit">
                            <option selected>{{ __('Area Unit') }}</option>
                            @foreach (\App\Models\Ad\RealEstateDetail::AREA_UNIT as $key => $value)
                                <option value="{{ $key }}">{{ __('messages.area_unit.' . $key) }}</option>
                            @endforeach
                        </select>
                        @error('area_unit')
                            <span class=" text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="construction_year" class="form-label">{{ __('Construction Year') }}</label>
                        <select class="form-select @error('construction_year') is-invalid @enderror"
                            wire:model="construction_year" aria-label="Default select example"
                            style="{{ $isEn ? 'background-position: right 0.75rem center;' : 'background-position: left 0.75rem center;' }}">
                            <option selected>{{ __('Construction Year') }}</option>
                            @foreach (range(now()->year, 1940) as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                        @error('construction_year')
                            <span class=" text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="floor" class="form-label">{{ __('Floor') }}</label>
                        <input type="number" wire:model="floor"
                            class="form-control mt-0 @error('floor') is-invalid @enderror" id="floor">
                        @error('floor')
                            <span class=" text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="availability_date" class="form-label">{{ __('Availability Date') }}</label>
                        <input type="date" wire:model="availability_date"
                            class="form-control mt-0 @error('availability_date') is-invalid @enderror" id="availability_date">
                        @error('availability_date')
                            <span class=" text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="room" class="form-label">{{ __('Room') }}</label>
                        <input type="number" wire:model="rooms"
                            class="form-control mt-0 @error('rooms') is-invalid @enderror" id="room">
                        @error('rooms')
                            <span class=" text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12 mb-2">
                    <label for="bathroom" class="form-label">{{ __('Bathroom') }}</label>
                    <input type="number" wire:model="bathroom"
                        class="form-control mt-0 @error('bathroom') is-invalid @enderror" id="bathroom">
                    @error('bathroom')
                        <span class=" text-danger">{{ $message }}</span>
                    @enderror
                </div>
                {{-- <div class="row">
                    <div class="col-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="warehouse" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                {{ __('Warehouse') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="elevator" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                {{ __('Elevator') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="balcony" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                {{ __('Balcony') }}
                            </label>
                        </div>
                    </div>
                </div> --}}
            </form>
        </div>

            <div class="col-12 mt-2">
                <div class="section-title clearfix">
                    <h2>{{ __('The Property Facilities') }} </h2>
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
        @endif

        <div class="alert alert-info" role="alert"><i class="fa fa-exclamation-triangle"></i>
            {{ __('Note: Your ad will be published on the site after review and approval by management.') }}
        </div>
        <button class="btn btn-info col-12 col-md-3 mb-3" wire:click.prevent="update">{{ __('Update Ad') }}
        </button>
    </form>
</div>
