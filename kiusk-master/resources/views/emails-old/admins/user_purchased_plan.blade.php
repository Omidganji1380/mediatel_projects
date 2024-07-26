@component('mail::message')
<div>
    <!-- write an email with registered user details -->
    <h1>{{ __('A new order has been created with the following details:') }}</h1>
    <p>{{ __('Email') }}:  <b>{{ $user->email }}</b></p>
    <p>{{ __('Phone Number') }}: <b>{{ $user->full_phone }}</b></p>
    <p>{{ __('Role') }}: <b>{{ __('messages.roles.' . $user->getRoleNames()->first()) }}</b></p>
    <p>{{ __('Order Number') }}: <b>{{ $order->number }}</b></p>
    <p>{{ __('Order Price') }}: <b>{{ $order->total_price }}</b></p>
</div>
{{ config('app.name') }}
@endcomponent
