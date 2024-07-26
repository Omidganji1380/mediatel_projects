@component('mail::message')
<div>
    <!-- write an email with registered user details -->
    <h1 style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{!! __('emails.admin.rejected_ad', [
        'id' => $ad->id,
        'adminId' => $admin->id,
        'adminEmail' => $admin->email,
        'reason' => $reason ?: __('No Reason')
    ]) !!}</h1>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Title') }}: <b>{{ $ad->title }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __("Username") }}:  <b>{{ $ad->user->full_name }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __("Role") }}: <b>{{ __('messages.roles.' . $ad->user?->getRoleNames()?->first()) }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __("Email") }}:  <b>{{ $ad->user->email }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Phone Number') }}: <b>{{ $ad->user->full_phone }}</b></p>
    @component('mail::button', ['url' => route('filament.resources.ad/advertisement.edit', $ad)])
        {{ __('View Advertisement') }}
    @endcomponent
</div>
{{ config('app.name') }}
@endcomponent
