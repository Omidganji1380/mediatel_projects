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
        .arial-font{
            font-family: Arial, Helvetica, sans-serif !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/content-styles.css') }}" type="text/css">
@endsection
@section('seo')
@if ($ad->no_index)
    <meta name="robots" content="noindex" />
@endif
@endsection
@section('content')
    <livewire:front.ad.show :ad="$ad" />
    @php
        $adsUser = App\Models\Ad\Ad::with([
            'state',
            'city',
            'media' => function ($q) {
                $q->whereCollectionName('SpecialImage');
            },
            'mainCategory',
            'favorites' => function ($q) {
                if (auth()->check()) {
                    $q->whereUserId(auth()->id());
                }
            },
        ])
            ->whereUserId($ad->user_id)
            ->inRandomOrder()
            ->whereIsVisible(true)
            ->whereNotIn('id', [$ad->id])
            ->limit(s()->numberAdsUserShowAdPage)
            ->get();
        $adsUserIds = $adsUser->pluck('id');
        $suggestedAds = App\Models\Ad\Ad::with([
            'state',
            'city',

            'media' => function ($q) {
                $q->whereCollectionName('SpecialImage');
            },
            'mainCategory',
            'favorites' => function ($q) {
                if (auth()->check()) {
                    $q->whereUserId(auth()->id());
                }
            },
        ])
            // ->whereHas('categories', function ($q) use ($ad) {
            //     $q->whereIn('ad_categories.id', $ad->categories->pluck('id'));
            // })
            /*->orWhere('city_id',$ad->city_id)
             ->orWhere('state_id',$ad->state_id)*/
            ->inRandomOrder()
            ->whereIsVisible(true)
            ->where('is_suggestion_featured', 1)
            ->whereNotIn('id', [$ad->id /*,...$adsUserIds*/])
            ->limit(s()->numberAdsSimilarShowAdPage)
            ->get();
        $adsSimilar = App\Models\Ad\Ad::with([
            'state',
            'city',

            'media' => function ($q) {
                $q->whereCollectionName('SpecialImage');
            },
            'mainCategory',
            'favorites' => function ($q) {
                if (auth()->check()) {
                    $q->whereUserId(auth()->id());
                }
            },
        ])
            ->whereHas('categories', function ($q) use ($ad) {
                $q->whereIn('ad_categories.id', $ad->categories->pluck('id'));
            })
            /*->orWhere('city_id',$ad->city_id)
             ->orWhere('state_id',$ad->state_id)*/
            ->inRandomOrder()
            ->whereIsVisible(true)
            // ->where('extra->special', true)
            ->whereNotIn('id', [$ad->id /*,...$adsUserIds*/])
            ->limit(s()->numberAdsSimilarShowAdPage)
            ->get();
        $title = __('Other ads');
    @endphp
    @includeWhen(count($adsUser), 'livewire.front.ad.layouts.owl', [
        'title' => __('Other ads'),
        'ads' => $adsUser,
    ])
    @includeWhen(count($suggestedAds), 'livewire.front.ad.layouts.owl', [
        'title' => __('Suggested Ads'),
        'ads' => $suggestedAds,
    ])
    @includeWhen(count($adsSimilar), 'livewire.front.ad.layouts.owl', [
        'title' => __('Similar Ads'),
        'ads' => $adsSimilar,
    ])
@endsection
@section('script')
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
@endsection
