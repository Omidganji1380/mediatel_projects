@component('mail::message')

## {{ __('messages.scores.emails.subtitle', ['name' => $user->full_name]) }}

{!! __('messages.unread_messages_count',['count' => $unreadCount]) !!}

@component('mail::button', ['url' => 'https://kiusk.ca/my-account'])
{{ __('messages.report.read_message') }}
@endcomponent

{{ __('messages.scores.emails.regards') }}
    {{ __('messages.scores.emails.kiusk_team') }}
{{ config('app.name') }}
@endcomponent
