<div class="container py-3 h-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-xl-6">
            <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                <div class="card-body p-4 p-md-5">
                    {{-- <div class="text-center mb-4">
                        <img src="{{ asset('im') }}"
                            alt="{{ __('Jabeh | List of Iranian ads and businesses in Canada') }}">
                    </div> --}}
                    @if($otpSent)
                        <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 fs-5 text-center">{{ __('messages.sent_code') }}
                        </h3>
                        <form wire:submit.prevent=confirm>
                            <div class="row">
                                <div class="mb-4">
                                    <input type="phone" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror" id="phone"
                                        wire:model.lazy="sent_code"
                                        placeholder="{{ __('Enter the sent code') }}"
                                        required autocomplete="sent_code" autofocus>
                                        @error('sent_code')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <input class="btn btn-primary btn-lg" type="submit" value="{{ __('Confirm and Continue') }}">
                            </div>
                        </form>
                    @else
                        <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 fs-5 text-center">{{ __('messages.signup-phone') }}
                        </h3>
                        <form wire:submit.prevent=sendSms>
                            <div class="row">
                                <div class="col-md-12 mb-4 d-flex flex-column align-items-center">
                                    <div class="">
                                        <div class="form-outline d-flex w-100" dir="ltr">
                                            <select name="country_code" wire:model.lazy="country_code" id="country_code" class="form-control w-25">
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">
                                                        {{ $country->name_with_code }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="phone" name="phone"
                                                class="form-control w-75 @error('phone') is-invalid @enderror" id="phone"
                                                wire:model.lazy="phone"
                                                placeholder="{{ __('Enter Phone Number') }}"
                                                required autocomplete="phone" autofocus>
                                        </div>
                                        <div class="d-flex {{ App::isLocale('fa') ? "flex-row-reverse" : "" }}">
                                            <div class="w-25"></div>
                                                <div class="w-75">
                                                    @error('phone')
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                        </div>
                                    </div>
                                    <p class="align-self-lg-start fs-small mt-2 text-secondary">{{ __('Enter phone number without country code or 0') }}*</p>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <input class="btn btn-primary btn-lg" type="submit" value="{{ __('Continue') }}">
                            </div>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')

<script src="{{ asset('front/vendor/country-select-js/build/js/countrySelect.min.js')}}"></script>

<script>
    $(document).ready(function () {

        $("#country").countrySelect({
            defaultCountry: "ca",
            preferredCountries: ['ca', 'ir', 'us'],
            responsiveDropdown: true
        });

        $('.select-icon')

        var countryData = $("#country").countrySelect("getSelectedCountryData");
        $('.country-list').removeAttr("style");
    });
</script>
@endpush
