@component('mail::message')

## {{ __('messages.scores.emails.subtitle', ['name' => $user->full_name]) }}

    {{ __('messages.report.daily_intro') }}

    {!! $content !!}

@component('mail::button', ['url' => 'https://kiusk.ca'])
{{ __('messages.report.visit') }}
@endcomponent

{{ __('messages.scores.emails.regards') }}
    {{ __('messages.scores.emails.kiusk_team') }}
{{ config('app.name') }}
@endcomponent
