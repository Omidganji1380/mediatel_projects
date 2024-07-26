<div id="verify-email">
    <div class="section-title clearfix p-3 mt-4">
        <h2>{{ __('Verify Email Address') }}</h2>
    </div>
    <form class="row g-3" wire:submit.prevent="verifyEmail">
        <div id="spinner" wire:loading wire:loading wire:target="verifyEmail,sendEmail">
            <img src="{{ asset('images/ajax-loader.gif') }}"/>
        </div>
        @if($currentPage === 1)
            <div class="col-12">
                <label for="inputuserdress2" class="form-label">{{ __('E-Mail Address') }}</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" wire:model="email"
                    id="inputuserdress2" placeholder="" disabled required>
                @error('email')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </div>
        @elseif($currentPage === 2)
            <div class="col-12">
                <label for="inputuserdress2" class="form-label">{{ __('Verification Code') }}</label>
                <input type="text" class="form-control @error('token') is-invalid @enderror" wire:model="token"
                    id="inputuserdress2" placeholder="" required>
                @error('token')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </div>
        @endif
        @if($currentPage === 1)
            <!--  -->
            <div class="col-12">
                @if ($user->email_verified_at)
                    <button type="button" class="btn btn-primary" disabled>{{ __('Verified') }} <i class="fa fa-check mx-2"></i>
                    </button>
                @else
                    <button type="button" wire:click="sendEmail" class="btn btn-primary">{{ __('Send Email Verification') }}
                    </button>
                @endif
                <a href="#inputuserEmail" class="btn btn-secondary">{{ __('Edit') }}</a>
            </div>
        @elseif($currentPage ===2)
            <div class="col-12">
                @if ($user->email_verified_at)
                    <button type="button" class="btn btn-primary" disabled>{{ __('Submit') }}
                    </button>
                @else
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}
                    </button>
                @endif
                <a href="#inputuserEmail" class="btn btn-secondary">{{ __('Edit') }}</a>
            </div>
        @endif
    </form>
</div>
