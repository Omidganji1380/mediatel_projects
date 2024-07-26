<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
    @include('front.layouts.email-head')
</head>

<body>
    <div class="container">
        @include('front.layouts.header.email-header', ['image' => asset('images/emails/13.jpg')])
        <div class="container">
            <div class="d-flex justify-content-center">
                <h1 class="text-danger">{{ __('emails.greeting', ['name' => trim($user->full_name) ?: __('User')]) }}</h1>
            </div>
            <div class="" style="text-align: center !important;">
                {!! __('emails.messages.welcome') !!}
            </div>
            <div class="d-flex justify-content-center pt-3" style="text-align: center !important;">
                <p class="font-weight-bold">{{ __('emails.regards') }}</p>
            </div>
        </div>

        @include('front.layouts.email-footer')
    </div>

    @include('front.layouts.email-script')
</body>

</html>
