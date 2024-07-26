<div id="user-information">
    <div class="section-title clearfix p-3 mt-4">
        <h2>{{ __('Edit Profile') }}</h2>
    </div>
    <div class="row mb-3">
        @if(count($notCompleteItems))
            <div class="alert alert-warning alert-dismissible fade show p-3" role="alert">
                {{ __('messages.warnings.edit_profile_title') }}
                <ul>
                    @foreach ($notCompleteItems as $item)
                    <li>{{ __('messages.warnings.' . $item) }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="col-md-12">
            {{ __('Profile Completion') }}
            <div class="">
                <div class="progress-bar rounded {{ $registrationProgress === 100 ? "bg-success" : "" }}" role="progressbar" style="width: {{ $registrationProgress }}%; height:1em;" aria-valuenow="{{ $registrationProgress }}" aria-valuemin="0" aria-valuemax="100">{{ $registrationProgress }}%</div>
            </div>
        </div>
    </div>
    <form class="row g-3" wire:submit.prevent="store">
        <div class="col-md-6">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input type="text" class="form-control @error('user.first_name') is-invalid @enderror"
                wire:model="user.first_name" id="name">
            @error('user.first_name')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="inputPassword4" class="form-label">{{ __('Last Name') }}</label>
            <input type="text" wire:model="user.last_name"
                class="form-control @error('user.last_name') is-invalid @enderror" id="inputPassword4">
            @error('user.last_name')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-12">
            <label for="inputuserdress" class="form-label ">{{ __('Display Name') }}</label>
            <input type="text" class="form-control @error('user.name') is-invalid @enderror" wire:model="user.name"
                id="inputuserdress" placeholder="">
            @error('user.name')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-12">
            <label for="inputuserEmail" class="form-label">{{ __('E-Mail Address') }}</label>
            <input type="email" class="form-control @error('user.email') is-invalid @enderror" wire:model="user.email"
                id="inputuserEmail" placeholder="">
            @error('user.email')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="row my-3 g-0 {{ App::isLocale('fa') ? 'flex-row-reverse' : '' }}">
            <div wire:ignore id="country_code_from" class="col-2">
                <label for="inputuserphone" class="form-label"></label>
                <input type="text" id="country" class="w-100 text-start country-code" />
                <input type="hidden" id="country_code" />
            </div>
            <div class="col-10">
                <label for="inputuserphone" class="form-label">{{ __('Phone Number') }}</label>
                <input type="text" dir="ltr" class="form-control @error('user.phone') is-invalid @enderror" wire:model="user.phone"
                    id="inputuserphone" placeholder="">
                @error('user.phone')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-12">
            <label for="inputuserdress2" class="form-label">{{ __('Address') }}</label>
            <input type="text" class="form-control @error('user.address') is-invalid @enderror" wire:model="user.address"
                id="inputuserdress2" placeholder="">
            @error('user.address')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-floating">
            <textarea class="form-control @error('user.description') is-invalid @enderror" wire:model="user.description"
                placeholder="" id="floatingTextarea24" style="height: 100px"></textarea>
            @error('user.description')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
            <label for="floatingTextarea24">{{ __('Description') }}</label>
        </div>
        <label for="floatingTextarea24">{{ __('Profile Image') }}</label>
        <div class="input-group mb-3">
            <input type="file" wire:model="avatar" placeholder="{{ __('Profile Image') }}"
                class="form-control @error('avatar') is-invalid @enderror">
            <img class="img-thumbnail" src="{{ $previewAvatar }}" alt="">
            @if ($previewAvatar)
                <span class="position-absolute top-0 start-100 translate-middle p-2   rounded-circle">
                    <i class="fa fa-trash" aria-hidden="true" wire:click="mediaDelete"></i>
                    <span class="visually-hidden">New alerts</span>
                </span>
            @endif
        </div>
        @error('avatar')
            <span class=" text-danger">{{ $message }}</span>
        @enderror
        <div class="spinner-border text-success" wire:loading wire:target="avatar"></div>
        <!--  -->
        <fieldset>
            <legend>{{ __('Change Password') }}</legend>
            <p class="">
                <label
                    for="password_current">{{ __('Previous password (if you don\'t want to change it, leave it blank)') }}
                </label>
                <span class="password-input @error('password') is-invalid @enderror"><span
                        class="show-password-input"></span>
                <input type="password" name="password" wire:model="password" id="password-field"
                        autocomplete="off"></span>
                @error('password')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </p>
            <p class="">
                <label for="password_1">{{ __('New password (if you don\'t want to change it, leave it blank)') }}</label>
                <span class="password-input @error('newPassword') is-invalid @enderror"><span
                        class="show-password-input"></span><input type="password" wire:model="newPassword"
                        autocomplete="off"></span>
                @error('newPassword')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </p>
            <p class="">
                <label for="password_2">{{ __('Confirm new password') }}</label>
                <span class="password-input @error('newPassword_confirmation') is-invalid @enderror"><span
                        class="show-password-input"></span><input type="password" wire:model="newPassword_confirmation"
                        autocomplete="off"></span>
                @error('newPassword_confirmation')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </p>
        </fieldset>
        <fieldset>
            <legend>{{ __('Send Reset Password Code Via Sms Or Telegram') }}</legend>
            <p class="">
                <label
                    for="user.send_code_via_telegram">{{ __('If you already registered in Kiusk telegram channel you can choose the methods to send code via the Telegram or Sms.') }}
                </label>
                <span class="password-input @error('user.send_code_via_telegram') is-invalid @enderror"><span
                        class="show-password-input"></span>
                <div class="d-flex">
                    <p class="me-3">{{ __('Send token via?') }}</p>
                    <p>{{ __('Sms') }}</p>
                    <div class="form-check form-switch mx-3">
                        <input class="form-check-input custom-switch" type="checkbox" wire:model="user.send_code_via_telegram" role="switch"
                            id="flexSwitchCheckDefault">
                    </div>
                    <p>{{ __('Telegram') }}</p>
                </div>
                @error('user.send_code_via_telegram')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </p>
        </fieldset>
        <!--  -->
        <div class="col-12">
            <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}
            </button>
        </div>
    </form>
</div>
@push('scripts')
    <script src="{{ asset('js/countrySelect.min.js') }}"></script>
    <script>
        window.addEventListener('progressUpdated', event => {
            Livewire.reload();
        })
    </script>
    <script>
         window.addEventListener('load', function() {
            document.getElementById('password-field').value = '';
        });
        $("#country").countrySelect({
            defaultCountry: "ca",
            onlyCountries: ["ca", "us"],
            responsiveDropdown: true
        });

        $('.country-select').addClass("mt-4");

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
