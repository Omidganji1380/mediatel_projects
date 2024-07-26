@php
    $isFa = App::isLocale('fa');
    $positionBackground = $isFa ? 'background-position: left 0.75rem center;' : 'background-position: right 0.75rem center;';
@endphp
<div class="col-12 col-md" style="  transition: width 2s, height 4s;">
    <div class="section-title clearfix pb-0">
        <h2>{{ __('Register') }}</h2>
    </div>
    @if($currentPage === 1)
        <form action="" class="bg-white p-4 shadow rounded">
            <div id="spinner" wire:loading wire:loading wire:target="sendSms">
                <img src="{{ asset('images/ajax-loader.gif') }}" />
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control @error('email') is-invalid  @enderror" id="floatingInput"
                    wire:model.defer="email" placeholder="name@example.com">
                <label for="floatingInput">{{ __('E-Mail Address') }} *
                </label>
                @error('email')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="row mb-3 g-0 {{ App::isLocale('fa') ? 'flex-row-reverse' : '' }}">
                <div wire:ignore id="country_code_from" class="col-2">
                    <input type="text" id="country" class="w-100 text-start country-code" />
                    <input type="hidden" id="country_code" />
                    {{-- <select class="form-select" wire:model.defer="countryCode" style="{{ $positionBackground }}">
                        <option value="0" selected>{{ __('Country Code') }}
                        </option>
                        <option value="+1">{{ __('Canada') }} (+1)</option>
                    </select> --}}
                    {{-- @error('countryCode')
                        <span class=" text-danger">{{ $message }}</span>
                    @enderror --}}
                </div>
                <div class="form-floating col-10 mb-3">
                    <input type="text" name="phone"
                        class="form-control phone-input mt-0 @error('phone') is-invalid  @enderror" id="floatingPhone"
                        wire:model.defer="phone" pattern="[0-9]*" autocomplete="new-Phone"
                        placeholder="{{ __('Phone Number') }}">
                    <label for="floatingPhone">{{ __('Phone Number') }} *
                    </label>
                    @error('phone')
                        <span class=" text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-floating mb-3">
                <select wire:model.defer="role" id="role" class="form-control @error('role') is-invalid  @enderror">
                    <option value="">{{ __('User Role') }} *</option>
                    @foreach ($roles as $key => $value)
                        <option value="{{ $key }}">{{ __('messages.roles.' . $key) }}</option>
                    @endforeach
                </select>
                @error('role')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="referralCode" class="form-control @error('referralCode') is-invalid  @enderror"
                    id="floatingReferralCode" wire:model.defer="referralCode" placeholder="Password">
                <label for="floatingReferralCode">{{ __('Referral Code') }}
                </label>
                @error('referralCode')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-floating">
                <input type="password" class="form-control @error('password') is-invalid  @enderror" id="floatingPassword"
                    autocomplete="new-password" wire:model.defer="password" placeholder="Password">
                <label for="floatingPassword">{{ __('Password') }} *
                </label>
                @error('password')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </div>
            {{-- <div class="form-floating"> --}}
            {{--  <input type="password" --}}
            {{--         class="form-control @error('password_confirmation') is-invalid  @enderror" --}}
            {{--         id="floatingPassword" --}}
            {{--         wire:model="password_confirmation" --}}
            {{--         placeholder="Password"> --}}
            {{--  <label for="floatingPassword">تایید کلمه عبور * --}}
            {{--  </label> --}}
            {{--  @error('password_confirmation') <span class=" text-danger">{{ $message }}</span> @enderror --}}
            {{-- </div> --}}
            <p class="mt-2 mb-2">{{ __('messages.register_message') }}</p>
            <div>
                <button class="btn btn-primary mt-2 mb-2" wire:click.prevent="sendSms">{{ __('Register') }}
                </button>
            </div>

        </form>
    @elseif($currentPage === 2)
        {{-- {{ $verifyCode }} --}}
        <form class="bg-white p-4 shadow rounded">
            <div id="spinner" wire:loading wire:loading wire:target="register">
                <img src="{{ asset('images/ajax-loader.gif') }}" />
            </div>
            <div>
                {{ __('messages.verify_phone_subheading') }}
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('token') is-invalid @enderror" wire:model="token"
                id="verification_code" placeholder="" required>
                <label for="verification_code">{{ __('Verification Code') }}</label>
                @error('token')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <button wire:click.prevent="register" class="btn btn-primary mt-2 mb-2">{{ __('Confirm') }}
                </button>
            </div>
        </form>
    @endif
</div>
</div>

@push('scripts')
    <script src="{{ asset('js/countrySelect.min.js') }}"></script>
    <script>
        $("#country").countrySelect({
            defaultCountry: "ca",
            onlyCountries: ["ca", "us"],
            responsiveDropdown: true
        });

        $('.country-select.inside').on('click', function() {
            var countryList = $(this).find('.country-list');
            if (countryList.is(':visible')) {
                countryList.css('width', '200px'); // Change the width value as per your requirement
            }
            $('#country').val('');
        });
        $('#country').val('');
    </script>
@endpush
