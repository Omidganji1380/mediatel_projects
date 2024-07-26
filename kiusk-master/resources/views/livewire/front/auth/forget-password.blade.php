<div class="col-12 col-md mb-4 @if (!$showForm) d-none @endif" style="  transition: width 2s, height 4s;">
    <div class="section-title clearfix pb-0">
        <h2>{{ __('Forgot Password') }}</h2>
    </div>
    <form action="" autocomplete="off" class="bg-white p-4 shadow rounded ">
        <div id="spinner" wire:loading wire:loading wire:target="register">
            <img src="{{ asset('images/ajax-loader.gif') }}" />
        </div>
        @error('all')
            <span class=" text-danger">{{ $message }}</span>
        @enderror
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error('username') is-invalid  @enderror" id="floatingInput"
                autocomplete="off" wire:model="username" placeholder="name@example.com">
            <label for="floatingInput">{{ __('Telegram account email or mobile number without zero') }} *
            </label>
            @error('username')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div>
        @if($isPhone)
            <div class="form-floating mb-3">
                <div class="d-flex">
                    <p class="me-3">{{ __('Send token via?') }}</p>
                    <p>{{ __('Sms') }}</p>
                    <div class="form-check form-switch mx-3">
                        <input class="form-check-input custom-switch" type="checkbox" wire:model="sendViaSms" role="switch"
                            id="flexSwitchCheckDefault">
                    </div>
                    <p>{{ __('Telegram') }}</p>
                </div>
                @error('username')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </div>
        @endif
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                @if(!$checked)
                    <button type="button" class="btn   btn-primary"
                        style="border-top-left-radius: 0;border-bottom-left-radius: 0"
                        wire:click.prevent="checkUsername">{{ __('Send verification code') }}
                    </button>
                @elseif($isPhone && !$this->isTokenSent && $checked)
                    <button type="button" class="btn   btn-primary"
                        style="border-top-left-radius: 0;border-bottom-left-radius: 0"
                        wire:click.prevent="sendToken">{{ __('Send verification code') }}
                    </button>
                @else
                    <button type="button" class="btn btn-primary"
                        style="border-top-left-radius: 0;border-bottom-left-radius: 0"
                        >{{ __('Enter verification code') }}
                    </button>
                @endif
            </div>
            <input type="text" class="form-control @error('password') is-invalid  @enderror" autocomplete="off"
                wire:model="token" style="margin-top: 0;    height: 53.5px !important;">
        </div>
        @error('token')
            <span class=" text-danger">{{ $message }}</span>
        @enderror
        <div class="form-floating">
            <input type="password" class="form-control @error('password') is-invalid  @enderror" id="floatingPassword"
                autocomplete="new-password" wire:model="password" placeholder="Password">
            <label for="floatingPassword">{{ __('New Password') }} *
            </label>
            @error('password')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-floating">
            <input type="password" class="form-control @error('password_confirmation') is-invalid  @enderror"
                id="floatingPassword" autocomplete="new-password" wire:model="password_confirmation"
                placeholder="Password">
            <label for="floatingPassword">{{ __('Confirm new password') }} *
            </label>
            @error('password_confirmation')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <button class="btn mt-2 mb-2 btn-primary" wire:click.prevent="store">{{ __('Save') }}
            </button>
            <button class="btn mt-2 mb-2 btn-primary" wire:click.prevent="backToLogin">{{ __('Return') }}
            </button>
        </div>
    </form>
</div>
