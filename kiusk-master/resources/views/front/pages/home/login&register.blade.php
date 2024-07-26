@extends('front.base')
@section('seo')
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/countrySelect.min.css') }}">
    <style>
        .country-select {width: 100%;}
        .country-select .country-list{
            left: 0;
        }
        @if(App::isLocale('en'))

            #country_code_from input[type="text"]{
                padding-left: 4em !important;
            }
        @endif
    </style>
@endsection
@section('content')
    <?php
    $newAdAlert = session('url.intended') === route('front.ad.create');
    ?>
    <div class="position-relative">
        <div id="loading_all" class="loading ">
            <div class="loader-show"></div>
        </div>
        <section class=" blog-block m-0 pt-3">
            <div @class(['container', 'pt-4' => $newAdAlert])>
                @if ($newAdAlert)
                    <div class="alert alert-warning" role="alert">
                        <div>
                            <h2>{{ __('Login to create ads') }}</h2>
                        </div>
                        <div>
                            <p class="m-0">{!!  __('messages.login_message') !!}<br>
                                </p>
                        </div>
                    </div>
                @endif
                <div @class(['row', 'mt-5' => $newAdAlert])>
                    @livewire('front.auth.forget-password')

                    @livewire('front.auth.login')

                    @livewire('front.auth.register')
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/countrySelect.min.js') }}"></script>
    <script>
        $("#country").countrySelect();
        Livewire.on('toggleFormForgetPassword', function() {
            $('#loading_all').addClass('loading_show')
            setTimeout(() => {
                $('#loading_all').removeClass('loading_show')
            }, 1000);
        });
        Livewire.on('toggleFormLogin', function() {
            $('#loading_all').addClass('loading_show')
            setTimeout(() => {
                $('#loading_all').removeClass('loading_show')
            }, 1000);
        })
    </script>
@endsection
