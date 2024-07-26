<div id="user-referral">
    <div class="section-title clearfix p-3 mt-4">
        <h2>{{ __('Referral Code') }}</h2>
        <P>{{ __('messages.referral.description') }}</P>
    </div>
    <div class="row g-3">

        <div class="col-12 text-center">
            @if ($referralCode)
                <div class="position-relative">
                    <h4 id="copy-to-clipboard" title="{{ __("Click to copy") }}" data-link="{{ route('front.login-register', ['referral_code' => $referralCode]) }}">
                        {{ $referralCode }}</h4>
                    <div id="flash-message"></div>
                </div>
            @else
                <button type="button" wire:click.prevent="generate" class="btn btn-primary">{{ __('Generate') }}</button>
            @endif
        </div>
        <div class="col-12">
            <p>{{ __('Number of users registered with my referral code') }}: <span>{{ $userReferralCount }}</span></p>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#copy-to-clipboard').click(function() {
                var copyText = $('#copy-to-clipboard').attr('data-link');
                var tempInput = document.createElement("input");
                tempInput.value = copyText;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);

                $('#flash-message').text('Copied').fadeIn(500).delay(1000).fadeOut(500);
            });
        });
    </script>
@endpush
