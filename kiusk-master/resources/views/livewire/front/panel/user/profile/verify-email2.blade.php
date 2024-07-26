<div id="verify-email">
    <div class="section-title clearfix p-3 mt-4">
        <h2>{{ __('Verify Email Address' ) }}</h2>
        @if($currentPage == 1)
            <P>{{ __('We will send an email containing a verification code to the email address you provide.') }}</P>
        @elseif($currentPage ==2)
            <p>{{ __('Enter the verification code that we sent to your phone number.') }}</p>
        @endif
    </div>

    <form class="row g-3" wire:submit.prevent="verifyEmail">
        <div id="spinner" wire:loading wire:loading wire:target="verifyEmail,sendEmail">
            <img src="{{ asset('images/ajax-loader.gif') }}"/>
        </div>
        @if($currentPage == 1)
            <div class="col-12">
                <label for="inputuserdress2" class="form-label">{{ __('E-Mail Address') }}</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model.defer="email"
                    id="inputuserdress2" disabled required>
                @error('email')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </div>
        @elseif($currentPage ==2)
            <div class="col-12">
                <label for="inputuserdress2" class="form-label">{{ __('Verification Code') }}</label>
                <input type="text" class="form-control @error('emailToken') is-invalid @enderror" wire:model="emailToken"
                    id="inputuserdress2" required>
                @error('emailToken')
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
            </div>
        @endif
    </form>
</div>
