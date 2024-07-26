@extends('front.base')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugin/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugin/assets/owl.theme.default.min.css') }}">

    <style>
        .owl-carousel .owl-nav button.owl-next,
        .owl-carousel .owl-nav button.owl-prev,
        .owl-carousel button.owl-dot {
            background-color: gray;
            color: white;
        }

        .owl-carousel .owl-stage {
            display: flex;
        }

        .owl-carousel {
            width: auto;
            height: 100%;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/content-styles.css') }}" type="text/css">
@endsection
@section('seo')
@endsection
@section('content')
<div class="container">
    <div class="row">
        <h4 class="text-center my-5">
            {{ __('messages.ad_page_title') }}
        </h4>
        <div class="row align-content-center g-0 justify-content-center">
            <div class="col-md-8">
                <livewire:front.advertisement.index :advertisement="$advertisement" :wire:key="$advertisement->id" />
            </div>
        </div>
        {{-- <div id="carouselSpecialAdsControls" class="carousel slide " data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($advertisementTypes as $key => $group)
                    <div class="carousel-item @if ($loop->first) active @endif">
                        <div class="row row-cols-1 row-cols-md-3 row-cols-md-4 g-3 flex-nowrap flex-md-wrap">
                            @foreach ($group as $key => $advertisement)
                                <livewire:front.advertisement.index :advertisement="$advertisement" :wire:key="$advertisement->id" />
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <div dir="ltr">
                <button class="carousel-control-prev prev" type="button" style="width:60px" data-bs-target="#carouselSpecialAdsControls"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">{{ __('Previous') }}</span>
                </button>
                <button class="carousel-control-next next" type="button" style="width:60px" data-bs-target="#carouselSpecialAdsControls"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">{{ __('Next') }}</span>
                </button>
            </div>
        </div> --}}

    </div>
</div>


@endsection
{{-- @section('script')
    <script src="{{ asset('plugin/owl.carousel.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            Livewire.emit('viewed')
        })
    </script>
    <script>
        let colaps = document.querySelector('.colpas-button').addEventListener("click", () => {
            document.querySelector(".fa-search").classList.toggle('d-none')
            document.querySelector(".fa-times").classList.toggle('disply')
        })
        $('.owl-carousel').owlCarousel({
            rtl: true,
            loop: true,
            margin: 10,
            autoHeight: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                },
                600: {
                    items: 3,
                    nav: false,
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: false,
                },
            },
        })
    </script>
@endsection --}}
