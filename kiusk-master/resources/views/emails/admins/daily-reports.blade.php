@component('mail::message')
<div>
    <!-- write an email with registered user details -->
    <h1 style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Daily Reports') }}</h1>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Number Of Registered User') }}: <b>{{ $users }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __("Created Ad") }}:  <b>{{ $ads }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};" dir="rtl">{{ __("Orders") }}: <b dir="ltr">${{ $orders }}</b></p>

</div>
{{ config('app.name') }}
@endcomponent
