@extends('front.base')
@section('seo')
@endsection
@section('content')
    <?php
    $newAdAlert = session('url.intended') === route('front.ad.create');
    ?>
    <div class="position-relative">
        <div id="loading_all" class="loading ">
            <div class="loader-show"></div>
        </div>
        <section class=" blog-block m-0 pt-5">
            <livewire:front.auth.signup-phone />
        </section>
    </div>
@endsection
@section('script')
    <script>
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
