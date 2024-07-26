@component('mail::message')
<div>
    <!-- write an email with registered user details -->
    <h1 style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('A new user has been registered with the following details:') }}</h1>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Email') }}:  <b>{{ $user->email }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Phone Number') }}: <b dir="ltr">{{ $user->full_phone }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Role') }}: {{ __('messages.roles.' . $user->getRoleNames()->first()) }}</p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Via') }}: <b>{{ $via }}</b></p>
</div>
{{ config('app.name') }}
@endcomponent
