@component('mail::message')
# Subscription Expiration Warning

Hello {{ $data['name'] }},

Your subscription will expire on {{ $data['expirationDate'] }}. You have {{ $data['daysUntilExpiration'] }} days left.

Please renew your subscription to continue using our service.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
