<!DOCTYPE html>
<html lang="{{ App::isLocale('fa') ? 'fa' : 'en' }}" dir="{{ App::isLocale('fa') ? 'rtl' : 'ltr' }}">

<head>
    {!! SEO::generate() !!}
    <link rel="icon" type="image/png" href="{{ asset('storage/' . s()->favicon) }}">
    @include('front.layouts.head')
    @yield('head')
    @include('front.layouts.Seo')
    @yield('seo')
    @yield('styles')
    {{-- <style>
        @if (App::isLocale('fa'))
            /* .ad-create-ol{
                right: 30%;
            }
            .ad-create-ol li a{
                padding-left: 4em;
                padding-right: 4em;
            } */
        @else
            *, a.text-little, .card_blog_title{
                font-family: Calibri;
            }
            /* .ad-create-ol{
                left: 37%;
            }
            .ad-create-ol li a{
                padding-left: 4em;
                padding-right: 4em;
            } */
        @endif
    </style> --}}

    @stack('styles')
</head>

<body>
    <header class="bg-white header" id="header">
        @include('front.layouts.header.header')
    </header>
    <!-- header -->
    <!-- main -->
    <main @class([
        'content',
        'main-color' => request()->routeIs('front.ad.show'),
    ])>
        @yield('content')
    </main>
    <!-- footre -->
    <footer class="footer">
        @include('front.layouts.footer')
    </footer>
    @include('front.layouts.returnToTop')
    <!-- modal -->
    {{-- @include('front.layouts.modal-category.modal-category2') --}}
    <!-- script -->
    @include('front.layouts.script')
    @livewireScripts
    <livewire:front.sweet-alert />
    @yield('script')
</body>

</html>
