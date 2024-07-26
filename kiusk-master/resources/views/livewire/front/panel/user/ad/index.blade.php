<div>
    @php
        $isEn = App::isLocale('en');
        $lang = App::isLocale('en') ? "en." : "";

    @endphp
    <div class="position-relative section-title clearfix p-3 pt-md-0">
        <h2>{{ __('My Ads') }}</h2>
        <p>{!! __('messages.ads.title') !!}</p>
        <a href="{{ route($lang .'front.ad.create') }}"
            class="d-none d-md-block top-0 rounded-pill p-1 ps-2 pe-2 btn btn-ads position-absolute {{ App::isLocale('fa') ? "end-0" : "" }} me-3 me-md-0"
            style="{{ App::isLocale('en') ? "right: 0;" : "" }}"
            >+ {{ __('Create Ad') }}
        </a>
    </div>
    <div class="mt-5 mt-lg-0">
        @forelse(App\Models\Ad\Ad::whereUserId(auth()->id())->whereNotNull('slug')->latest()->get() as $ad)
            <div
                class="d-flex align-items-end bg-white p-0 p-lg-2 rounded pt-lg-4 pb-lg-4 position-relative flex-wrap flex-lg-nowrap shadow-2 @if (!$loop->first) mt-4 @endif">
                <img src="{{ $ad?->getFirstMedia('SpecialImage')?->getUrl('70_70') ?: asset('images/kiusk-placeholder.jpg') }}" alt="" width="100px"
                    height="100px" class="rounded image-cart">
                <div class=" ms-2 p-1 pb-3 p-lg-0">
                    <a href="{{ route('front.ad.show', $ad->slug) }}">
                        <h3 class="fs-5 mb-4">{{ $ad->title }}
                            @if($ad->activeSubscription?->plan)
                                <span class="fs-6 text-success">
                                    ({{ $ad->activeSubscription?->plan?->name }} {{ trans_choice(
                                        'messages.plans.intervals.' . $ad->activeSubscription?->plan?->invoice_interval,
                                        $ad->activeSubscription?->plan?->invoice_period ,
                                        ['count' => $ad->activeSubscription?->plan?->invoice_period]
                                    ) }})
                                </span>
                            @elseif($ad->is_featured || $ad->is_sidebar_featured || $ad->is_suggestion_featured)
                                <span class="fs-6 text-success">
                                    {{ __('Special') }}
                                </span>
                            @endif
                        </h3>
                    </a>
                    <div class="mt-3 little-font">
                        <span class=" text-secondary"><i class="far fa-calendar-week m-1"></i>
                            {{ $ad->created_at->diffForHumans() }}</span>
                        <span class="text-secondary ms-1"><i class="fas fa-folder-open m-1"></i>
                            {{ $ad?->mainCategory?->first()?->locale_name }}</span>
                        <span class="text-secondary ms-1"><i class="far fa-chart-bar m-1"></i>{{ $ad->views }}
                            {{ __('Views') }}</span>
                        @if (!$ad->is_visible)
                            <span class="btn-danger ms-1 p-2 rounded"> {{ __('Pending Ads') }}</span>
                        @else
                            <span class="btn-success active ms-1 p-2 rounded">{{ __('Confirmed') }}</span>
                        @endif
                    </div>
                </div>
                <div class="card-list" style="{{ $isEn ? "right:0; left:80%; border:none;" : ""}}">
                    <ul class="p-0">
                        <li>
                            <a class="text-black" href="{{ route($lang . 'front.panel.user.ad.edit', $ad->id) }}"><i
                                    class="fas fa-pencil-alt"></i>{{ __('Edit Ad') }}</a>
                        </li>
                        <li wire:click.prevent="promote({{ $ad->id }})">
                            {{-- <a class="text-black" href="{{ route($lang . 'front.panel.user.plans.index', $ad->slug) }}"> --}}
                            {{-- <a class="text-black" href="{{ route('front.panel.user.ad.payment', $ad->id) }}"> --}}
                                <i class="fal fa-sort-amount-up-alt"></i>{{ __('Promote Ad') }}
                            {{-- </a> --}}
                        </li>
                        {{-- <li wire:click.prevent="pinAd({{ $ad->id }})">
                            <i class="fal fa-thumbtack"></i>{{ __('Pin Ad') }}
                        </li> --}}
                        <li wire:click.prevent="beforeDelete({{ $ad->id }})">
                            <i class="far fa-trash"></i>{{ __('Delete Ad') }}
                        </li>
                    </ul>
                </div>
            </div>
        @empty
            <div>
                <p>{{ __("You have not registered an ad yet.") }}</p>
            </div>
        @endforelse
    </div>
</div>
