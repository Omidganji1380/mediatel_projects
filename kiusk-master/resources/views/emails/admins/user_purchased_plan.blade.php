@component('mail::message')
<div>
    <!-- write an email with registered user details -->
    <h1 style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('A new order has been created with the following details:') }}</h1>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Email') }}:  <b>{{ $user->email }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Phone Number') }}: <b>{{ $user->full_phone }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Role') }}: <b>{{ __('messages.roles.' . $user->getRoleNames()->first()) }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Order Number') }}: <b>{{ $order?->number }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Order Price') }}: <b>${{ $price }}</b></p>
</div>
{{ config('app.name') }}
@endcomponent
