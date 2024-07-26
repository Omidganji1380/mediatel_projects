@push('styles')
    <style>
        .ca-image-mobile{
            width: 100%;
        }
    </style>
@endpush

<section class="ad-list-block m-0">
    <div class="container">
        <div class="section-title clearfix">
            <h2>{{ __('Special Ads') }} ({{ $category->locale_name }})</h2>
        </div>
        @if ($ads && $ads->count())
            <div class="g-sm-0 pb-5 px-4 row">
                @if ($category->has_banner)
                    <div class="col-12 col-md-3 col-sm-6 p-0">
                        <livewire:front.ad.card :ad="$ads?->first()" :wire:key="$ads?->first()?->id" />
                    </div>
                    <div class="col-12 col-md-9 col-sm-12 p-0">
                        <div class="d-flex flex-column home-banner-container mt-4 mt-md-2 px-2">
                            {{-- <script src="https://web.adminbot.ca/ads/canada-ads.js" data-uid="0DWVlpoq3TVNPvXq"></script> --}}
                            @if (count($advertisements ?? []))
                                @foreach ($advertisements as $advertisement)
                                    <a href="{{ $advertisement->link }}" target="_blank" class="position-relative">
                                        <div class="home-banner {{ !$loop->last ? 'mb-2' : '' }}">
                                            <img src="{{ $advertisement->adOrder?->getFirstMediaUrl(App::isLocale('fa') ? 'HomeBGLargeFa' : 'HomeBGLargeEn') }}"
                                                alt="" class="w-100">
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                @foreach ($banners as $banner)
                                    <a href="{{ $banner->link }}" target="_blank" class="position-relative">
                                        <div class="home-banner {{ !$loop->last ? 'mb-2' : '' }}">
                                            <img src="{{ $banner->getFirstMediaUrl(App::isLocale('fa') ? 'image' : 'image_en') }}"
                                                alt="" class="w-100">
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @else
                    @foreach ($ads as $key => $ad)
                        <div class="col-12 col-md-3 col-sm-6 p-0">
                            <livewire:front.ad.card :ad="$ad" :wire:key="$ad['id']" />
                        </div>
                    @endforeach
                    @if ($ads->count() < 4)
                        @foreach (range(1, 4 - $ads->count()) as $advertisment)
                            <div class="col-12 col-md-3 col-sm-6 p-0">
                                @include('livewire.front.ad.advertisement-card', ['category' => $category])
                            </div>
                        @endforeach
                        {{-- <div class="col-12 col-md-3 col-sm-6 p-0">
                            <script src="https://web.adminbot.ca/ads/canada-ads.js" data-uid="0DWVlpoq3TVNPvXq"></script>
                        </div> --}}
                    @endif
                @endif
            </div>
            <div class="g-sm-0 pb-5 px-4 row">
                <div class="col-12 col-md-3 col-sm-6 p-0 mb-3">
                    @include('livewire.front.ad.advertisement-card', ['category' => $category])
                    {{-- <script src="https://web.adminbot.ca/ads/canada-ads.js" data-uid="0DWVlpoq3TVNPvXq"></script> --}}
                </div>
                <div class="col-12 col-md-9 col-sm-12 p-0">
                    <div class="d-flex flex-column home-banner-container mt-4 mt-md-2 px-2">
                        @if (count($advertisements ?? []))
                            @foreach ($advertisements as $advertisement)
                                <a href="{{ $advertisement->link }}" target="_blank" class="position-relative">
                                    <div class="home-banner {{ !$loop->last ? 'mb-2' : '' }}">
                                        <img src="{{ $advertisement->adOrder?->getFirstMediaUrl(App::isLocale('fa') ? 'HomeBGLargeFa' : 'HomeBGLargeEn') }}"
                                            alt="" class="w-100">
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <a href="{{ route($lang . 'front.advertisement.index') }}" target="_blank" class="position-relative">
                                <div class="home-banner {{ !$loop->last ? 'mb-2' : '' }}">
                                    <div>
                                        <script src="https://web.adminbot.ca/ads/canada-ads.js?version=1.0" data-uid="eF85NjUfCt0KdEnz" data-type="wide"></script>
                                    </div>
                                    {{-- <script src="https://web.adminbot.ca/ads/canada-ads.js" data-uid="0DWVlpoq3TVNPvXq"></script> --}}
                                    {{-- <img src="{{ asset(App::isLocale('fa') ? 'storage/' . s()->mainPageAdPlaceholder : 'storage/' . s()->mainPageAdPlaceholder) }}" alt="{{ env('APP_NAME') }}" class="w-100"> --}}
                                </div>
                            </a>
                            <a href="{{ route($lang . 'front.advertisement.index') }}" target="_blank" class="position-relative">
                                <div class="home-banner {{ !$loop->last ? 'mb-2' : '' }}">
                                    <div>
                                        <script src="https://web.adminbot.ca/ads/canada-ads.js?version=1.0" data-uid="eF85NjUfCt0KdEnz" data-type="wide"></script>
                                    </div>
                                    {{-- <script src="https://web.adminbot.ca/ads/canada-ads.js" data-uid="0DWVlpoq3TVNPvXq"></script> --}}
                                    {{-- <img src="{{ asset(App::isLocale('fa') ? 'storage/' . s()->mainPageAdPlaceholder2 : 'storage/' . s()->mainPageAdPlaceholder2) }}" alt="{{ env('APP_NAME') }}" class="w-100"> --}}
                                </div>
                            </a>
                            {{-- @foreach ($banners as $banner)
                                <a href="{{ $banner->link }}" target="_blank" class="position-relative">
                                    <div class="home-banner {{ !$loop->last ? 'mb-2' : '' }}">
                                        <img src="{{ $banner->getFirstMediaUrl(App::isLocale('fa') ? 'image' : 'image_en') }}"
                                            alt="" class="w-100">
                                    </div>
                                </a>
                            @endforeach --}}
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="g-sm-0 pb-5 px-4 row">
                @foreach (range(1, 4) as $advertisment)
                    <div class="col-12 col-md-3 col-sm-6 p-0">
                        @include('livewire.front.ad.advertisement-card', ['category' => $category])
                        {{-- <script src="https://web.adminbot.ca/ads/canada-ads.js" data-uid="0DWVlpoq3TVNPvXq"></script> --}}
                    </div>
                @endforeach
            </div>
        @endif
        <!-- cards -->
</section>
{{-- <section class="ad-list-block m-0">
    <div class="container">
        <div class="section-title clearfix">
            <h2>{{ __('Special Ads') }} ({{ $category->locale_name }})</h2>
        </div>
        @if ($ads && $ads->count())
            <div id="carouselSpecialAdsControls{{ $category->id }}" class="carousel slide " data-bs-ride="carousel">

                <div class="carousel-inner">
                    @foreach ($ads as $key => $group)
                        <div class="carousel-item @if ($loop->first) active @endif">
                            <div class="row row-cols-1 row-cols-md-3 row-cols-md-4 g-3 flex-nowrap flex-md-wrap">
                                @foreach ($group as $key => $ad)
                                    <livewire:front.ad.card :ad="$ad" :wire:key="$ad['id']" />
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev prev" type="button" data-bs-target="#carouselSpecialAdsControls{{ $category->id }}"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">{{ __('Previous') }}</span>
                </button>
                <button class="carousel-control-next next" type="button" data-bs-target="#carouselSpecialAdsControls{{ $category->id }}"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">{{ __('Next') }}</span>
                </button>
            </div>
        @endif
        <!-- cards -->
</section> --}}
