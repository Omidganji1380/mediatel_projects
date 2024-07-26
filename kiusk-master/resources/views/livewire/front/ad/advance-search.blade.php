@php
    $isFa = App::isLocale('fa');
    $positionBackground =  $isFa ? "background-position: left 0.75rem center;" :  "background-position: right 0.75rem center;"
@endphp
<div class="accordion bg-transparent filter" id="accordionExample">
    <div class="accordion-item bg-transparent position-relative">
        <h2 class="accordion-header bg-transparent {{ $isFa ? "" : "d-flex justify-content-end" }}" id="headingOne">
            <button class="accordion-button collapsed bg-transparent right-apprance pb-4 {{ $isFa ? "" : "w-auto" }}" style="width: 150px;" type="button"
                data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="true" aria-controls="collapseTen">
                {{ __('Advance Search') }}
            </button>
        </h2>
        <div class="row d-sm-flex absolot w-75 d-none">
            <div class="col-12 col-md-4">
                <select class="form-select mx-1" style="{{ $positionBackground }}" wire:model="sort">
                    <option value="">{{ __('Sort by relevance') }}</option>
                    <option value="views-desc">{{ __('Sort by view (descending)') }}</option>
                    <option value="views-asc">{{ __('Sort by view (ascending)') }}</option>
                    <option value="created_at-desc">{{ __('Sort by date (descending)') }}</option>
                    <option value="created_at-asc">{{ __('Sort by date (ascending)') }}</option>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <select class="form-select mx-1" style="{{ $positionBackground }}" name="state_id" id="state" wire:model="state_id">
                    <option value="0">{{ __("All States") }}</option>
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-4">
                <select class="form-select mx-1" style="{{ $positionBackground }}" name="city_id" id="city" wire:model="city_id">
                    <option value="0">{{ __("All Cities") }}</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div id="collapseTen" class="accordion-collapse collapse bg-transparent" aria-labelledby="headingTen"
            data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <div class="row g-2 align-items-center">
                    <div class="col-md-3">
                        <input type="checkbox" wire:model="specialAd" class="@error('specialAd') is-invalid  @enderror">
                        <label for="">{{ __('Special Ad') }}</label>
                        @error('specialAd')
                            <span class=" text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <form class="row g-3 col-md-9">
                        <div class="col-12 col-md-4 d-sm-none d-block mb-3">
                            <select class="form-select mx-1" style="{{ $positionBackground }}" wire:model="sort">
                                <option value="">{{ __('Sort by relevance') }}</option>
                                <option value="views-desc">{{ __('Sort by view (descending)') }}</option>
                                <option value="views-asc">{{ __('Sort by view (ascending)') }}</option>
                                <option value="created_at-desc">{{ __('Sort by date (descending)') }}</option>
                                <option value="created_at-asc">{{ __('Sort by date (ascending)') }}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="min_price" class="form-label">{{ __('Minimum Price') }}</label>
                            <input type="number" class="form-control @error('min') is-invalid  @enderror"
                                wire:model="min" id="min_price">
                            @error('min')
                                <span class=" text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="inputPassword4" class="form-label">{{ __('Maximum Price') }}</label>
                            <input type="number" wire:model="max"
                                class="form-control @error('max') is-invalid  @enderror" id="inputPassword4">
                            @error('max')
                                <span class=" text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="inputPassword4" class="form-label">{{ __('All States') }}</label>
                            <select class="form-select mt-3" style="{{ $positionBackground }}" name="state_id" id="state" wire:model="state">
                                <option value="0">{{ __("Select state") }}</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                            @error('max')
                                <span class=" text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="inputPassword4" class="form-label">{{ __('All Cities') }}</label>
                            <select class="form-select mt-3" style="{{ $positionBackground }}" name="city_id" id="city" wire:model="city">
                                <option value="0">{{ __("Select a city") }}</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            @error('max')
                                <span class=" text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @include('livewire.front.ad.attributes')
                    </form>
                </div>
                <div>
                    <button class="btn btn-primary mt-3 mt-md-0" wire:click="startSearch">{{ __('Search') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
