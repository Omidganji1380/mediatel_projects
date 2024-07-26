@push('styles')
    <style>
        /* .ads-container-jmw29CAsa5kBGNKJ,
        .ads-container-n91SuOUhx4mMPaXS,
        .ads-container-gSA7XAVeHXk4eX7P {
            display: flex;
            justify-content: center;
        }
        .ads-container-jmw29CAsa5kBGNKJ a img,
        .ads-container-n91SuOUhx4mMPaXS a img,
        .ads-container-gSA7XAVeHXk4eX7P a img {
            width: 100% !important;
        } */
        .ca-image-mobile{
            width: 100%;
        }
    </style>
@endpush

@php
    $lang = App::isLocale('fa') ? '' : 'en.';
@endphp
<div class="col-12 col-md-4 hidden">
    <div class="mb-3 rounded bg-white shadow-2">
        {{-- <div class="p-2">
            <h5 class="text-center border-bottom p-2">آخرین ها</h5>
            <ul class="pe-2 ps-2 list-style-type">
                @php
                    $latestPosts = \App\Models\Blog\Post::latest()
                        ->limit(s()->numberPostsSidebarIndexBlogPage)
                        ->get();
                @endphp
                @foreach ($latestPosts as $key => $post0)
                    <li>
                        <a href="{{ $post0->link }}">{{ $post0->title }}</a>
                    </li>
                @endforeach
            </ul>
        </div> --}}
        <div class="border-bottom pt-3">
            <ul class="d-flex justify-content-around px-1 border-bottom-0 nav nav-tabs" id="blog_posts_sidebar">
                <li class="border-bottom-0 nav-item">
                    <a class="nav-link p-2 fs-6 active" data-bs-toggle="tab" aria-current="true"
                        href="#top_viewed">{{ __('Top Viewed') }}</a>
                </li>
                <li class="border-bottom-0 nav-item">
                    <a class="nav-link p-2 fs-6" data-bs-toggle="tab" href="#top_rated">{{ __('Top Rated') }}</a>
                </li>
                {{-- <li class="border-bottom-0 nav-item">
                    <a class="nav-link p-2" data-bs-toggle="tab" href="#top_controversial">{{ __('Most Recent') }}</a>
                </li> --}}
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="top_viewed">
                <div class="card-body">
                    <ul class="pe-2 ps-2 list-style-type blue-list-style">
                        {{-- @php
                            $latestPosts = \App\Models\Blog\Post::latest()
                                ->limit(s()->numberPostsSidebarIndexBlogPage)
                                ->get();
                        @endphp --}}
                        @foreach ($sidebar['top_viewed_blogs'] as $blog)
                            <li>
                                <a href="{{ $blog->link }}">{{ $blog->locale_title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="tab-pane" id="top_rated">
                <div class="card-body">
                    <ul class="pe-2 ps-2 list-style-type blue-list-style">
                        {{-- @php
                            $latestPosts = \App\Models\Blog\Post::inRandomOrder()
                                ->limit(s()->numberPostsSidebarIndexBlogPage)
                                ->get();
                        @endphp --}}
                        @foreach ($sidebar['latest_blog'] as $blog)
                            <li>
                                <a href="{{ $blog->link }}">{{ $blog->locale_title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            {{-- <div class="tab-pane" id="top_controversial">
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush p-3">
                        @foreach ($sidebar['recent_blogs'] as $blog)
                            <li class="list-group-item mb-4 hover-shadow p-2">
                                <img src="{{ asset($blog->cover->src ?? "front/assets/images/Blog.jpg") }}" alt="" width="100%">
                                <h5 class="p-2">
                                    <a href="{{ route('fa.blog.show', ['blog' => $blog->slug]) }}"
                                        class="text-decoration-none text-dark fw-bold">
                                        {{ $blog->name }}
                                    </a>
                                </h5>
                                <p class="fs-6 p-2">{{ $blog->short_description }}</p>
                                <div class="d-flex justify-content-between p-3">
                                    <span>
                                        <i class="bi bi-calendar"></i> {{ $blog->created_at->diffForHumans() }}
                                    </span>
                                    <span><a href="{{  route('fa.blog.show', $blog->slug) }}" class="btn btn-sm btn-primary">{{ __('Read More') }}</a></span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div> --}}
        </div>

    </div>
    <div class="mb-3 rounded bg-white shadow-2">
        <div class="p-2">
            <h5 class="text-center border-bottom p-2">{{ __('Latest News') }}</h5>
            <ul class="pe-2 ps-2 list-style-type">
                {{-- @php
                    $latestPosts = \App\Models\Blog\Post::latest()
                        ->limit(s()->numberPostsSidebarIndexBlogPage)
                        ->get();
                @endphp --}}
                @foreach ($sidebar['latest_news'] as $key => $post0)
                    <li>
                        <a href="{{ $post0->link }}">{{ $post0->locale_title }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="mb-3 rounded bg-white shadow-2">
        <div class="card">
            <div class="card-body">
                @if(isset($sidebarAdsTop) && $sidebarAdsTop?->count())
                    <div id="carouselSpecialAdsControls" class="carousel slide " data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($sidebarAdsTop as $ad)
                                <div class="carousel-item @if ($loop->first) active @endif">
                                    <img src="{{ $ad->adOrder?->getFirstMediaUrl(App::isLocale('fa') ? 'BlogSidebarFa' : 'BlogSidebarEn') }}" class="w-100" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    {{-- <a href="{{ route($lang . 'front.advertisement.index') }}">
                        <img src="{{ asset(App::isLocale('fa') ? 'images/ads.jpg' : "images/ads-en.jpg") }}" class="w-100" alt="kiusk.ca">
                    </a> --}}
                    {{-- <script src="https://web.adminbot.ca/ads/canada-ads.js" data-uid="jmw29CAsa5kBGNKJ"></script> --}}
                    <div>
                        <script src="https://web.adminbot.ca/ads/canada-ads.js?version=1.0" data-uid="eF85NjUfCt0KdEnz" data-type="box"></script>
                    </div>

                @endif
            </div>
        </div>
    </div>


    <div class="mb-3 rounded bg-white shadow-2">
        <h5 class="text-center border-bottom p-3">{{ __('Latest Ads') }}</h5>
        <div class="p-2 pe-3">
            <!--به تگ aدر li ها name اضاقه کردن کلاس  -->
            <ul class="p-0">
                @php
                    $ads = \App\Models\Ad\Ad::with([
                        'user',
                        'media' => function ($q) {
                            $q->whereCollectionName('SpecialImage');
                        },
                    ])
                        ->whereIsVisible(true)
                        ->isFeatured()
                        ->latest()
                        ->limit(s()->numberAdsSidebarIndexBlogPage)
                        ->get();
                @endphp
                @foreach ($ads as $key => $ad)
                    <li @class([
                        'border-bottom' => !$loop->last,
                    ])>
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="ms-1">
                                <a class="name"
                                    href="{{ route('front.ad.show', [$ad->slug]) }}">{{ $ad?->locale_title }}</a>
                                <p class="text-success text-little">{{ __('Call') }}</p>
                            </div>
                            <div class="p-2 pe-0 pb-0">
                                <a href="{{ route('front.ad.show', [$ad->slug]) }}">
                                    <img src="{{ $ad?->getFirstMedia('SpecialImage')?->getUrl('70_70') ?: asset('images/kiusk-placeholder.jpg') }}"
                                        alt="" width="55px" height="55px" class="border">
                                </a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="mb-3 rounded bg-white shadow-2">
        <div class="card">
            <div class="card-body">
                @if($sidebarAdsBottom?->count())
                <div id="carouselSpecialAdsControls" class="carousel slide " data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($sidebarAdsBottom as $ad)
                            <div class="carousel-item @if ($loop->first) active @endif">
                                <img src="{{ $ad->adOrder?->getFirstMediaUrl(App::isLocale('fa') ? 'BlogSidebarFa' : 'BlogSidebarEn') }}" class="w-100" alt="">
                            </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div>
                    <script src="https://web.adminbot.ca/ads/canada-ads.js?version=1.0" data-uid="eF85NjUfCt0KdEnz" data-type="box"></script>
                </div>
                    {{-- <script src="https://web.adminbot.ca/ads/canada-ads.js" data-uid="gSA7XAVeHXk4eX7P"></script> --}}

                    {{-- <a href="{{ route($lang . 'front.advertisement.index') }}">
                        <img src="{{ asset(App::isLocale('fa') ? 'images/ads.jpg' : "images/ads-en.jpg") }}" class="w-100" alt="kiusk.ca">
                    </a> --}}
                @endif
            </div>
        </div>
    </div>

    <div id="carouselExampleControls" class="carousel slide " data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($sidebar['random_special_ads'] as $key => $ad)
                <div class="carousel-item @if ($loop->first) active @endif">
                    <livewire:front.ad.card :ad="$ad" :wire:key="$ad['id']" />
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')

<script>
    // $(".carousel").swipe({
    //     swipe: function (event, direction, distance, duration, fingerCount, fingerData) {
    //         if (direction == 'left') $(this).carousel('next');
    //         if (direction == 'right') $(this).carousel('prev');
    //     },
    //     allowPageScroll: "vertical"
    // });
</script>

@endpush
