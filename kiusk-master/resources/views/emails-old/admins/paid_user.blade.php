@component('mail::message')
<div>
    <!-- write an email with registered user details -->
    <h1>{{ __('emails.admin.purchased_title_text', ['type' => $type]) }}</h1>
    <p>{{ __('Plan') }}/{{ __('Advertisements') }}: <b>{{ $model->name }}</b></p>
    <p>{{ __("Email") }}:  <b>{{ $user->email }}</b></p>
    <p>{{ __('Phone Number') }}: <b>{{ $user->full_phone }}</b></p>
    <p>{{ __("Role") }}: <b>{{ __('messages.roles.' . $user->getRoleNames()->first()) }}</b></p>
    <p>{{ __('Price') }}: <b>{{ $price }}</b></p>
</div>
{{ config('app.name') }}
@endcomponent
