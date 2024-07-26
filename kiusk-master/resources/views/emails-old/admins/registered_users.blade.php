@component('mail::message')
<div>
    <!-- write an email with registered user details -->
    <h1>{{ __('A new user has been registered with the following details:') }}</h1>
    <p>{{ __('Email') }}:  <b>{{ $user->email }}</b></p>
    <p>{{ __('Phone Number') }}: <b>{{ $user->full_phone }}</b></p>
    <p>{{ __('Role') }}: {{ __('messages.roles.' . $user->getRoleNames()->first()) }}</p>
    <p>{{ __('Via') }}: <b>{{ $via }}</b></p>
</div>
{{ config('app.name') }}
@endcomponent
