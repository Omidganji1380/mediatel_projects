@component('mail::message')
<div dir="{{ App::isLocale('fa') ? "rtl"  : "ltr"}}" style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">
    <!-- write an email with registered user details -->
    <h1 style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{!! __('emails.admin.upgrade_level') !!}</h1>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('User ID') }}: <b>{{ $user->id }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Email') }}: <b>{{ $user->email }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Username') }}: <b>{{ $user->full_name }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Previous Role') }}: <b>{{ $previousRole }}</b></p>
    <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Current Role') }}: <b>{{ $role }}</b></p>
    @if($price)
        <p style="text-align: {{ App::isLocale('fa') ? "right"  : "left"}};">{{ __('Purchase Price') }}: <b>{{ $price }}</b></p>
    @endif
    @component('mail::button', ['url' => route('filament.resources.users.edit', $user)])
        {{ __('View User') }}
    @endcomponent
</div>
{{ config('app.name') }}
@endcomponent
