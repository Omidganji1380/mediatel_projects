@component('mail::message')
<div dir="{{ App::isLocale('fa') ? "rtl"  : "ltr"}}">
    <!-- write an email with registered user details -->
    <h1 style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('emails.admin.purchased_title_text', ['type' => $type]) }}</h1>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Plan') }}/{{ __('Advertisements') }}: <b>{{ $model?->name }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __("Email") }}:  <b dir="ltr">{{ $user->email }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Phone Number') }}: <b dir="ltr">{{ $user->full_phone }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __("Role") }}: <b>{{ __('messages.roles.' . $user->getRoleNames()->first()) }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Price') }}: <b>${{ $price }}</b></p>
</div>
{{ config('app.name') }}
@endcomponent
