<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,  initial-scale=1.0">{{-- <link rel="stylesheet" --}}{{--      href="{{asset('css/style_min.css')}}"> --}}
<meta name="google-site-verification" content="bXOA3bmNxTV0meIss3APTsqNhNJ7pL8enADFsq1-ljQ" />
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
@if (App::isLocale('fa'))
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@else
    <link rel="stylesheet" href="{{ asset('css/style-en.css') }}">
@endif
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
@livewireStyles

<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
<!-- Flag Icon -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Link to the file hosted on your server, -->
<link rel="stylesheet" href="{{ asset('css/splide/splide.min.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('vendor/splide/dist/css/splide.min.css') }}"> --}}


<link rel="stylesheet" href="{{ asset('css/countrySelect.min.css') }}">
<style>
    .country-select {
        width: 100%;
    }

    .country-select .country-list {
        left: 0;
    }

    /* .select2-container .select2-selection,
    .select2-container .select2-selection__rendered {
        padding: 5px;
    } */
</style>

@stack('styles')
