@component('mail::message')
    {{-- <h1>{{ __('messages.scores.emails.title') }}</h1> --}}
    ## {{ __('messages.scores.emails.subtitle', ['name' => $user->full_name]) }}

    {{ __('messages.scores.emails.body', [
        'score' => $score,
        'type' => $type,
    ]) }}

    {{ __('messages.scores.emails.regards') }}
    {{ __('messages.scores.emails.kiusk_team') }}
{{ config('app.name') }}
@endcomponent
