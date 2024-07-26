@php
    $lang = App::isLocale('fa') ? '' : 'en.';
@endphp

<div class="cards col pe-3 ps-2 pt-2">

    <div class="card">
        @if (count($ad->media))
            <a href="{{ $ad->slug ? route($lang . 'front.ad.show', ['slug' => $ad->slug]) : config('app.url') }}"
                class="pb-2">
                <img src="{{ App::isLocale('fa')
                    ? $ad->getFirstMediaUrl('SpecialImage', 'thumb')
                    : ($ad->getFirstMediaUrl('SpecialImageEn', 'thumb') ?:
                        $ad->getFirstMediaUrl('SpecialImage', 'thumb')) }}"
                    class="card-img-top " title="{{ $ad->title }}" alt="{{ $ad->title }}">
                {{-- <img src="{{ $ad->getFirstMedia('SpecialImage')?->getUrl('thumb') }}" class="card-img-top "
                    title="{{ $ad->title }}" alt="{{ $ad->title }}"> --}}
            </a>
        @endif
        <span class="bookmark  favorite_7636" data-toggle="tooltip" data-placement="top" wire:click="favorite"
            title=""><i
                class="@if ($isFavorite) fas

        @else() far @endif  fa-bookmark text-white fs-6"></i></span>
        @if ($local)
            <script !src="">
                document.cookie = 'favorites=@json($favorits); expires=Thu, 18 Dec 2045 12:00:00 UTC; path=/';
            </script>
        @endif
        <span class="ad_visit">{{ $ad->views }} {{ __('View') }}</span>
        {{-- @if ($ad?->state || $ad?->city)
            <h4 class="location">
                @if ($ad?->state)
                    <a class=""
                        href="{{ route($lang . 'front.ad.category.city.index.first.page', $ad?->state?->slug) }}">{{ $ad?->state?->locale_name }}</a>
                @endif
                @if ($ad?->city)
                    <a class=""
                        href="{{ route($lang . 'front.ad.category.city.index.first.page', $ad?->city?->slug) }}">{{ $ad?->city?->locale_name }}</a>
                @endif
            </h4>
        @endif --}}
        {{-- <span class="price"><span>{{ __('Call') }}</span></span> --}}
        <div class="card-body pt-2 pb-0">
            {{--   <div id="app_basic"> --}}
            {{-- <div
      id="aa"

      @input="dd"
         v-bind:title="timestamp"
         class="experiment-block"
         @click="ee"
         :key="{{$ad->id}}"
         wire:model="ddd">@{{ message }}
    </div> --}}
            {{--    <input type="text" --}}
            {{--           wire:model="rrr.aa"> --}}
            {{--    <input type="text" --}}
            {{--           wire:model="ad.title"> --}}
            {{--   </div> --}}
            <div class="{{ App::isLocale('en') ? 'meta-en text-start' : 'meta' }}">
                <a href="{{ $ad->slug ? route($lang . 'front.ad.show', ['slug' => $ad->slug]) : config('app.url') }}">
                    <h5 class="card-title text-dark" title="{{ $ad->locale_title }}">{{ $ad->locale_title }}</h5>
                </a>
                <figure>
                    <i class="fa fa-calendar-o"></i> {{ $ad->created_at->diffForHumans() }}
                </figure>
                @if ($ad?->mainCategory->count())
                    <figure>
                        <i class="fa fa-folder-open"></i><a
                            href="{{ route($lang . 'front.ad.category.index.first.page', $ad?->mainCategory->first()->slug) }}">
                            {{ $ad?->mainCategory->first()->locale_name }}</a>
                    </figure>
                @endif
                {{-- <div class="d-flex justify-content-between">
                    <figure>
                        <i class="fa fa-eye"></i>
                        {{ $ad->views }}
                    </figure>
                    <figure>
                        <i class="fa fa-heart"></i>
                        {{ $ad->favorites_count }}
                    </figure>
                </div> --}}
            </div>
        </div>
    </div>
</div>
