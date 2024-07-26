@component('mail::message')
<div>
    <!-- write an email with registered user details -->
    <h1>{{ __('emails.admin.created_ad') }}</h1>
    <p>{{ __('Title') }}: <b>{{ $ad->locale_title }}</b></p>
    <p>{{ __("Email") }}:  <b>{{ $ad->user->email }}</b></p>
    <p>{{ __('Phone Number') }}: <b>{{ $ad->user->full_phone }}</b></p>
    <p>{{ __("Role") }}: <b>{{ __('messages.roles.' . $ad->user->getRoleNames()->first()) }}</b></p>
    @component('mail::button', ['url' => route('filament.resources.ad/ads.edit', $ad)])
        {{ __('View Ad') }}
    @endcomponent
</div>
{{ config('app.name') }}
@endcomponent
