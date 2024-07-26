@component('mail::message')
<div>
    <!-- write an email with registered user details -->
    <h1 style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('emails.admin.created_ad') }}</h1>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Title') }}: <b>{{ $ad->locale_title }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __("Username") }}:  <b>{{ $ad->user->full_name }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __("Role") }}: <b>{{ __('messages.roles.' . $ad->user?->getRoleNames()?->first()) }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __("Email") }}:  <b>{{ $ad->user->email }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Phone Number') }}: <b dir="ltr">{{ $ad->user->full_phone }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Ad Number') }}: <b>{{ $adNumber }}</b></p>
    @component('mail::button', ['url' => route('filament.resources.ad/ads.edit', $ad)])
        {{ __('View Ad') }}
    @endcomponent
</div>
{{ config('app.name') }}
@endcomponent
