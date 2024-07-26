<div>
    <div class="section-title clearfix">
        <h2>{{ __('Verify and publish') }}</h2>
    </div>
    <form class="row g-3 position-relative">
        <div class="loading " wire:loading.class="loading_show" wire:target="goTo">
            <div class="loader-show"></div>
        </div>
        <div class="col-md-12">
            <label for="title" class="form-label">{{ __('Ad Persian Title') }}</label>
            <input type="text" disabled wire:model="ad.title" class="form-control" id="title">
        </div>
        <div class="col-md-12">
            <label for="title" class="form-label">{{ __('Ad English Title') }}</label>
            <input type="text" disabled wire:model="ad.title_en" class="form-control" id="title">
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="email" disabled value="{{ auth()->user()->email }}" class="form-control" id="email"
                placeholder="{{ __('Email') }}">
        </div>
        <div class="col-md-6">
            <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
            <input type="text" disabled value="{{ auth()->user()->phone }}" class="form-control" id="phone"
                placeholder="{{ __('Phone Number') }}">
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" disabled id="gridCheck">
                <label class="form-check-label" for="gridCheck">
                    {{ __('Do not display the email in the ad') }}
                </label>
            </div>
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" disabled id="gridCheck">
                <label class="form-check-label" for="gridCheck">
                    {{ __('Do not display the phone number in the ad') }}
                </label>
            </div>
        </div>
        <div class="form-floating">
            <textarea class="form-control" wire:model="content" placeholder="{{ __('Ad Description') }}" disabled
                id="floatingTextarea2" style="height: 200px !important"></textarea>
            <label for="floatingTextarea2">{{ __('Ad Description') }}</label>
        </div>
        <div class="form-floating">
            <textarea class="form-control" wire:model="content_en" placeholder="{{ __('Ad English Description') }}" disabled
                id="floatingTextarea3" style="height: 200px !important"></textarea>
            <label for="floatingTextarea3">{{ __('Ad English Description') }}</label>
        </div>
        {{-- <div class="row g-3">
            @include('front.pages.ads.create.review-attributes', [
                'formAttributes' => $formAttributes,
            ])
        </div> --}}
        <div class="row g-3">
            <div class="col">
                <select class="form-select" disabled wire:model="ad.state_id" aria-label="Default select example"
                    style="{{ $isEn ? 'background-position: right 0.75rem center;' : 'background-position: left 0.75rem center;' }}">
                    <option selected>{{ __('State') }}</option>
                    @foreach (\App\Models\Address\State::all() as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <select class="form-select" wire:model="ad.city_id" disabled aria-label="Default select example"
                    style="{{ $isEn ? 'background-position: right 0.75rem center;' : 'background-position: left 0.75rem center;' }}">
                    <option selected>{{ __('City') }}</option>
                    @foreach (\App\Models\Address\City::whereStateId($ad->state_id)->get() as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>
            @if(Auth::user()->getRoleNames()->first() !== 'property_applicant')
                <div class="section-title clearfix is-invalid">
                    <h2>{{ __('Ad Images') }}</h2>
                </div>
                <div class="container-file">
                    <div class="dropzone" style="height: auto ;min-height: 200px">
                        {{--        <label for="files" --}}
                        {{--               class="dropzone-container"> --}}
                        {{--         <div class="file-icon">+</div> --}}
                        {{--         <div class="dropzone-title"> --}}
                        {{--          جهت بارگذاری تصویر کلیک کنید --}}
                        {{--         </div> --}}
                        {{--        </label> --}}
                        <div class="d-flex flex-wrap justify-content-around">
                            @foreach ($previewPhotos as $photo)
                                <div class="position-relative ">
                                    <img class="img-thumbnail m-1" height="200" width="200"
                                        src="{{ $photo->original_url }}">
                                </div>
                            @endforeach
                        </div>
                        <input id="files" {{--               name="files[]" --}}type="file" class="file-input" multiple
                            wire:model="photos" />
                    </div>
                </div>
                @error('photos')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            @endif
        </div>

        <div class="section-title clearfix">
            <h2>{{ __('Real Estate Details') }}</h2>
        </div>

        @if (\App\Models\Ad\Category::find($selectedCategory)->sale_type === 'sale')
            <div class="row mt-2">
                <div class="col-md-6 mb-2">
                    <label for="sale_price" class="form-label">{{ __('Sale Price') }}</label>
                    <input type="number" disabled wire:model="sale_price"
                        class="form-control mt-0 @error('sale_price') is-invalid @enderror" id="sale_price">
                    @error('sale_price')
                        <span class=" text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 mb-2">
                    <label for="yearly_tax" class="form-label">{{ __('Yearly Tax') }}</label>
                    <input type="number" disabled wire:model="yearly_tax"
                        class="form-control mt-0 @error('yearly_tax') is-invalid @enderror" id="yearly_tax">
                    @error('yearly_tax')
                        <span class=" text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-12 mb-2">
                    <label for="price_keep" class="form-label">{{ __('Price Keep') }}</label>
                    <input type="number" disabled wire:model="price_keep"
                        class="form-control mt-0 @error('price_keep') is-invalid @enderror" id="price_keep">
                    @error('price_keep')
                        <span class=" text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @else
            <div class="row mt-2">
                <div class="col-md-6 mb-2">
                    <label for="mortgage_price" class="form-label">{{ __('Mortgage Price') }}</label>
                    <input type="number" disabled wire:model="mortgage_price"
                        class="form-control mt-0 @error('mortgage_price') is-invalid @enderror" id="mortgage_price">
                    @error('mortgage_price')
                        <span class=" text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 mb-2">
                    <label for="rent_price" class="form-label">{{ __('Rent Price') }}</label>
                    <input type="number" disabled wire:model="rent_price"
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
                <input type="number" disabled wire:model="area"
                    class="form-control mt-0 @error('area') is-invalid @enderror" id="area">
                @error('area')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6 mb-2">
                <label for="area_unit" class="form-label">{{ __('Area Unit') }}</label>
                <select class="form-select @error('area_unit') is-invalid @enderror" wire:model="area_unit"
                    aria-label="Default select example"
                    disabled
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
                <select class="form-select @error('construction_year') is-invalid @enderror" disabled
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
                <input type="number" disabled wire:model="floor"
                    class="form-control mt-0 @error('floor') is-invalid @enderror" id="floor">
                @error('floor')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6 mb-2">
                <label for="availability_date" class="form-label">{{ __('Availability Date') }}</label>
                <input type="date" disabled wire:model="availability_date"
                    class="form-control mt-0 @error('availability_date') is-invalid @enderror" id="availability_date">
                @error('availability_date')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6 mb-2">
                <label for="room" class="form-label">{{ __('Room') }}</label>
                <input type="number" disabled wire:model="rooms"
                    class="form-control mt-0 @error('rooms') is-invalid @enderror" id="room">
                @error('rooms')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-12 mb-2">
                <label for="bathroom" class="form-label">{{ __('Bathroom') }}</label>
                <input type="number" disabled wire:model="bathroom"
                    class="form-control mt-0 @error('bathroom') is-invalid @enderror" id="bathroom">
                @error('bathroom')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        @if ($selectedFacilities)
            <div class="section-title clearfix">
                <h2>{{ __('Facilities') }}</h2>
            </div>
            @foreach ($selectedFacilities as $key => $value)
                <div class="row mb-2">
                    <div>
                        {{ __('messages.facilities.' . $key) }}
                    </div>
                    @foreach ($value as $facility)
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" disabled checked id="gridCheck">
                                <label class="form-check-label" for="gridCheck">
                                    {{ $facility->locale_name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif
    </form>
</div>
<div class="col-12 mt-5 d-flex justify-content-between">
    <button type="submit" class="btn btn-primary" wire:click="goTo('facilities')">{{ __('Previous Stage') }}
    </button>
    <button type="submit" class="btn btn-success" wire:click="storeRealEstat">{{ __('Verify and publish') }}
    </button>
</div>
