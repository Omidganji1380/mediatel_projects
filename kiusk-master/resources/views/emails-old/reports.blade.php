@component('mail::message')
    ## {{ __('messages.scores.emails.subtitle', ['name' => $user->full_name]) }}

    {{ __('messages.report.intro') }}

    {!! $content !!}

    {{ __('messages.scores.emails.regards') }}
    {{ __('messages.scores.emails.kiusk_team') }}
{{ config('app.name') }}
@endcomponent
