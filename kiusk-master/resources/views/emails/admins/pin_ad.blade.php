@component('mail::message')
    <h1 style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('New Ad To be pinned!') }}</h1>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">A user has purchased a pin ad plan. Please review the details.</p>
    @if($ad)
        @component('mail::button', ['url' => route('filament.resources.ad/ads.edit', $ad->id)])
            {{ __('View Ad') }}
        @endcomponent
    @endif
@endcomponent
