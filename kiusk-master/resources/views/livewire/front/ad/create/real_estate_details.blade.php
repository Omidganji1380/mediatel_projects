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
        <h2>{{ __('Real Estate Details') }} </h2>
    </div>
    <form class="row g-3 position-relative">
        <div class="loading " wire:loading.class="loading_show" wire:target="goTo">
            <div class="loader-show"></div>
        </div>
        @if(\App\Models\Ad\Category::find($selectedCategory)->sale_type === 'sale')
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
<div class="col-12 mt-5 d-flex justify-content-between">
    <button type="submit" class="btn btn-primary"
        wire:click="goTo('realEstateForm')">{{ __('Previous Stage') }}
    </button>
    <button type="submit" class="btn btn-success"
        wire:click="goTo('facilities')">{{ __('Next Stage') }}
    </button>
</div>
