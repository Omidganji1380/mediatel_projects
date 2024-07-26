@extends('front.base')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/content-styles.css') }}" type="text/css">
    <style>

        @media (min-width: 765px) {
            .sticky-image {
                display: none;
            }
        }

        @media only screen and (max-width: 765px) {
            .sticky-image {
                position: -webkit-sticky;
                position: fixed;
                bottom: 0;
                width: 250px;
                z-index: 999;
            }

            .sticky-image .carousel .carousel-inner .carousel-item img {
                max-height: 400px;
            }

            .ck-content {
                word-wrap: break-word;
            }
        }
    </style>
@endsection
@section('content')
    @php
        $lang = App::isLocale('fa') ? '' : 'en.';
    @endphp
    <section class=" blog-block m-0 pt-5">
        <div class="container">
            <article>
                <div class="row row-cols-1 row-cols-2 pt-4 article">
                    @include('front.layouts.partials.blog_sidebar')
                    {{-- <div class="col-12 col-md-4">
                        <div class="mb-3 rounded bg-white shadow">
                            <div class="p-2">
                                <h5 class="text-center border-bottom p-2">آخرین ها</h5>
                                <!--blue-list-style اضاقه کردن کلاس -->
                                <ul class="pe-2 ps-2 list-style-type blue-list-style">
                                    @php
                                        $posts = \App\Models\Blog\Post::latest()
                                            ->limit(s()->numberPostsSidebarShowBlogPage)
                                            ->get();
                                    @endphp
                                    @foreach ($posts as $key => $post0)
                                        <li>
                                            <a href="{{ $post0->link }}">{{ $post0->title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="mb-3 rounded bg-white shadow">
                            <h5 class="text-center border-bottom p-3">آخرین آگهی‌ها</h5>
                            <div class="p-2">
                                <!--  -->
                                <ul class="p-0">
                                    @php
                                        $ads = \App\Models\Ad\Ad::with([
                                            'user',
                                            'media' => function ($q) {
                                                $q->whereCollectionName('SpecialImage');
                                            },
                                        ])
                                            ->whereIsVisible(true)
                                            ->latest()
                                            ->limit(s()->numberAdsSidebarShowBlogPage)
                                            ->get();
                                    @endphp
                                    @foreach ($ads as $key => $ad)
                                        <li @class([
                                            'border-bottom' => !$loop->last,
                                        ])>
                                            <div class="d-flex align-items-center">
                                                <div class="p-2 pe-0 pb-2">
                                                    <a href="{{ route('front.ad.show', [$ad->slug]) }}">
                                                        <img src="{{ $ad?->getFirstMedia('SpecialImage')?->getUrl('70_70') }}"
                                                            alt="" width="50px" height="50px"
                                                            class="border rounded">
                                                    </a>
                                                </div>
                                                <div class="ms-3">
                                                    <a class="name"
                                                        href="{{ route('front.ad.show', [$ad->slug]) }}">{{ $ad?->title }}</a>
                                                    <p class="text-success text-little m-0">تماس بگیرید</p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div> --}}
                    <!--  -->
                    <livewire:front.blog.show :post="$post" />
                </div>
            </article>
        </div>
        {{-- <div id="T4Tutorials_UP1" class="T4Tutorials">
            <div class="T4Tutorials_UP">
                @if ($sidebarAdsTop?->count())
                    <div id="carouselSpecialAdsControls" class="carousel slide " data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($sidebarAdsTop as $ad)
                                <div class="carousel-item @if ($loop->first) active @endif">
                                    <img src="{{ $ad->getFirstMediaUrl('image') }}" class="w-100" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <img src="{{ asset('images/ads.jpg') }}" class="w-100" alt="kiusk.ca">
                @endif
            </div>
        </div> --}}

        {{-- @if ($sidebarAdsTop)
            <div id="carouselSpecialAdsControls" class="carousel slide " data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($sidebarAdsTop as $ad)
                        <div class="carousel-item @if ($loop->first) active @endif">
                            <img src="{{ $ad->getFirstMediaUrl('image') }}" class="w-100" alt="">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif --}}


    </section>
    <div class="sticky-image">
        <button type="button" style="z-index: 999;"
            class="btn btn-primary close px-2 py-0 {{ App::isLocale('fa') ? 'float-end' : 'float-start' }}" id="close"
            aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{-- <img src="{{ asset('images/ads.jpg') }}" class="w-100" alt="Your image"> --}}
        <div id="carouselSpecialAdsControls" class="carousel slide " data-bs-ride="carousel">
            <div class="carousel-inner">
                @if (isset($sidebarAdsTop) && $sidebarAdsTop?->count())
                    @foreach ($sidebarAdsTop as $ad)
                        <div class="carousel-item @if ($loop->first) active @endif">
                            <img src="{{ $ad->adOrder?->getFirstMediaUrl(App::isLocale('fa') ? 'BlogSidebarFa' : 'BlogSidebarEn') }}"
                                class="w-100" alt="">
                        </div>
                    @endforeach
                @else
                    <div class="carousel-item active">
                        <a href="{{ route($lang . 'front.advertisement.index') }}">
                            <img src="{{ asset(App::isLocale('fa') ? 'images/ads.jpg' : 'images/ads-en.jpg') }}"
                                class="w-100" alt="Your image">
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            Livewire.emit('viewed')

        })

        $("#close").on("click", function() {
            $(this).parent().remove();
        });
        $('.ck-content').css('list-style-type', 'decimal !important');
    </script>
@endsection
