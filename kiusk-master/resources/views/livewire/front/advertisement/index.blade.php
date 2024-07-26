@php
    $lang = App::isLocale('en');
@endphp

<div class="align-items-stretch d-flex mb-5">

    <div class="card shadow" dir="ltr">
        {{-- <div class="card-header text-center bg-transparent">
            <h5>{{ $advertisement->name }}</h5>
        </div> --}}
        <div class="card-body">
            <img src="{{ $lang ? $advertisement->getFirstMediaUrl('image_en') : $advertisement->getFirstMediaUrl('image') }}" alt=""
                class="w-100">
        </div>
        <div class="card-footer bg-transparent border-0">
            <div class="row align-content-center g-0 justify-content-center">
                <div class="col-md-6 d-flex flex-row justify-content-center mb-2">
                    <div class="col-12" wire:ignore>
                        <select class="form-select w-100 @error('weeks') is-invalid @enderror" wire:model="weeks"
                            aria-label="Default select example" id="weeks">
                            <option value="" dir="{{ App::isLocale('fa') ? "rtl" : "ltr" }}">{{ __('Select an option')  }}</option>
                            @foreach (range(1, 4) as $weeks)
                                <option value="{{ $weeks }}" dir="{{ App::isLocale('fa') ? "rtl" : "ltr" }}">{{ trans_choice('messages.weeks', $weeks, ['weeks' => $weeks]) }}</option>
                            @endforeach
                        </select>
                        {{-- @error('weeks')
                            <span class=" text-danger">{{ $message }}</span>
                        @enderror --}}
                    </div>
                    {{-- <div class="d-flex flex-row justify-content-center shadow">
                        <button class="btn border rounded text-black {{ $lang ? "border-end-0" : "border-start-0" }}"
                            wire:click="decrement"
                            style="height: 56px;">
                            <i class="fa fa-chevron-left"></i>
                        </button>
                        <input type="text" class="border border-end-0 border-start-0 form-control rounded-0 text-center"
                            style="margin-top: 0"
                            wire:model.lazy="weeks" name="weeks">
                        <button class="btn border btn rounded text-black {{ $lang ? "border-start-0" : "border-end-0" }}"
                            wire:click="increment"
                            style="height: 56px;">
                            <i class="fa fa-chevron-right"></i>
                        </button>
                    </div>
                    <span class="align-self-center mx-3">{{ __('Weeks') }}</span> --}}
                </div>
            </div>
            <div class="row align-content-center g-0 justify-content-center">
                <div class="col-md-6">
                    <div dir="{{ App::isLocale('fa') ? "rtl" : ""}}">
                        @error('weeks')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row align-content-center g-0 justify-content-center mb-4">
                <div class="col-md-6">
                    <div class="d-flex flex-row justify-content-between mb-2">
                        <button class="btn btn-transparent flex-grow-1 font-weight-bold text-black fs-4">${{ $price }}</button>
                        <span class="align-self-center mx-3">{{ __('Price') }}</span>
                    </div>
                    <div class="d-flex flex-row justify-content-center mb-2">
                        <button class="border btn px-4 py-0 text-black rounded shadow w-100" wire:click="continueToCreateOrder">{{ __('Continue') }} <i class="mx-1 btn fa fa-play-circle text-black"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
