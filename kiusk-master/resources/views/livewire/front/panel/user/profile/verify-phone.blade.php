<div id="verify-phone">
    <div class="section-title clearfix p-3 mt-4">
        <h2>{{ __('Verify Phone Number') }}</h2>
    </div>
    <form class="row g-3" wire:submit.prevent="verifySms">
        <div id="spinner" wire:loading wire:loading wire:target="verifySms,sendSms">
            <img src="{{ asset('images/ajax-loader.gif') }}"/>
        </div>
        @if($currentPage === 1)
            <div class="col-12">
                <label for="inputuserdress2" class="form-label">{{ __('Phone Number') }}</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" wire:model="phone"
                    id="inputuserdress2" placeholder="" disabled required>
                @error('phone')
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
                @if ($user->phone_verified_at)
                    <button type="button" class="btn btn-primary" disabled>{{ __('Verified') }} <i class="fa fa-check mx-2"></i>
                    </button>
                @else
                    <button type="button" wire:click="sendSms" class="btn btn-primary">{{ __('Send SMS Verification') }}
                    </button>
                @endif
                <a href="#inputuserphone" class="btn btn-secondary">{{ __('Edit') }}</a>
            </div>
        @elseif($currentPage ===2)
            <div class="col-12">
                @if ($user->phone_verified_at)
                    <button type="button" class="btn btn-primary" disabled>{{ __('Submit') }}
                    </button>
                @else
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}
                    </button>
                @endif
                <a href="#inputuserphone" class="btn btn-secondary">{{ __('Edit') }}</a>
            </div>
        @endif
    </form>
</div>
