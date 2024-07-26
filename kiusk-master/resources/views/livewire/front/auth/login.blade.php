<div class="col-12 col-md mb-4 @if (!$showForm) d-none @endif" style="  transition: width 2s, height 4s;">
    <div class="section-title clearfix pb-0">
        <h2>{{ __('Login') }}</h2>
    </div>
    <form action="" class="bg-white p-4 shadow rounded ">
        @error('all')
            <span class=" text-danger">{{ $message }}</span>
        @enderror
        <div class="form-floating mb-3">
            <input type="text" dir="ltr" class="form-control @error('username') is-invalid  @enderror" id="floatingInput"
                wire:model="username" placeholder="name@example.com">
            <label for="floatingInput">{{ __('Email or phone number or telegram account without zero') }} *
            </label>
            @error('username')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-floating">
            <input type="password" dir="ltr" class="form-control @error('username') is-invalid  @enderror" id="floatingPassword"
                wire:model="password" placeholder="Password">
            <label for="floatingPassword">{{ __('Password') }} *
            </label>
            @error('password')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <button class="btn mt-2 mb-2 btn-primary" wire:click.prevent="authUser">{{ __('Login') }}
            </button>
        </div>
        <div>
            <input type="checkbox" wire:model="remember" name="" id="">
            <label for="">{{ __('Remember Me') }}</label>
        </div>
        <div>
            <span wire:click="forget" style="cursor: pointer">{{ __('Forgot Password?') }}</span>
        </div>
    </form>
    {{-- <script async src="https://telegram.org/js/telegram-widget.js?21" data-telegram-login="jabeh_bot" data-size="small" data-auth-url="/telegram/login" data-request-access="write"></script> --}}
</div>
