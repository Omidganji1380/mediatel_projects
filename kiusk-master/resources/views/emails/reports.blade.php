<html lang="en">

@include('front.layouts.email-head')

<body>
    <div class="container">
        @include('front.layouts.header.email-header', ['image' => asset('images/emails/2.jpg')])
        <div class="container">
            <div class="mobile-center" style="text-align: center !important; padding-bottom: 2em;">
                <h1 class="text-danger"
                    style="padding-top: 1.5em; text-align: center !important; padding-bottom: 1rem !important;">
                    {{ __('emails.greeting', ['name' => trim($user->full_name) ?: __('User')]) }}</h1>
                {!! $message ?? __('emails.messages.intro') !!}
                {!! $content !!}
            </div>
            <div style="text-align: center;">
                <p style="width: 100%; font-weight: bold; color: #007bff; text-align: center;">
                    {{ __('emails.regards') }}
                </p>
            </div>

        </div>

        @include('front.layouts.email-footer')
    </div>

    @include('front.layouts.email-script')
</body>
</html>
