@php
    $lang = App::isLocale('fa') ? "" : "en.";
@endphp

<div class="col-12 col-sm-6 col-md-3 pe-3 ps-2 pt-2">
    <div class="card">
        @if (count($ad['media']))
            @php
                foreach ($ad['media'] as $item) {
                    if(App::isLocale('en')){
                        if ($item['collection_name'] === 'SpecialImageEn') {
                            $m = new \Spatie\MediaLibrary\MediaCollections\Models\Media($item);
                            $src = $m->getUrl('thumb');
                        }elseif($item['collection_name'] === 'SpecialImage') {
                            $m = new \Spatie\MediaLibrary\MediaCollections\Models\Media($item);
                            $src = $m->getUrl('thumb');
                        }else {
                            $src = null;
                        }
                    }else {
                        if($item['collection_name'] === 'SpecialImage') {
                            $m = new \Spatie\MediaLibrary\MediaCollections\Models\Media($item);
                            $src = $m->getUrl('thumb');
                        }else {
                            $src = null;
                        }
                    }
                }
            @endphp
            <a href="{{ route( $lang . 'front.ad.show', ['slug' => $ad['slug']]) }}">
                <img src="{{ $src }}" class="card-img-top " title="{{ $lang ? $ad['title_en'] : $ad['title'] }}" alt="...">
            </a>
        @endif
        <span class=" bookmark " data-toggle="tooltip" data-placement="top" wire:click="favorite"
            title="{{ __('Add to favorites') }}"><i
                class="@if ($isFavorite) fas

        @else()far @endif fa-bookmark text-white fs-6"></i></span>
        @if ($local)
            <script !src="">
                document.cookie = 'favorites=@json($favorits); expires=Thu, 18 Dec 2045 12:00:00 UTC; path=/';
            </script>
        @endif
         <span class="ad_visit">{{$ad['views']}} {{ __('Views') }}</span>
        {{-- @if (isset($ad['state']) || $ad['city'])
            <h4 class="location">
                @if (isset($ad['state']))
                    <a class=""
                        href="{{ route( $lang . 'front.ad.category.city.index.first.page', $ad['state']['slug']) }}">{{ $ad['state']['name'] }}</a>
                @endif
                @if (isset($ad['city']))
                    <a class=""
                        href="{{ route( $lang . 'front.ad.category.city.index.first.page', $ad['city']['slug']) }}">{{ $ad['city']['name'] }}</a>
                @endif
            </h4>
        @endif --}}
        {{-- <span class="price"><span>{{ __('Call') }}</span></span> --}}
        <div class="card-body pt-2 pb-0">
            <div class="meta">
                <a href="{{ route( $lang . 'front.ad.show', ['slug' => $ad['slug']]) }}">
                    <h5 class="card-title text-dark" title="{{ $lang ? $ad['title_en'] : $ad['title'] }}">{{ $lang ? $ad['title_en'] : $ad['title'] }}</h5>
                </a>
                <figure>
                    <i class="fa fa-calendar-o"></i> {{ \Carbon\Carbon::parse($ad['created_at'])->setTimezone('America/Toronto')->diffForHumans() }}
                </figure>
                @if (isset($ad['main_category']) && count($ad['main_category']))
                    <figure>
                        <i class="fa fa-folder-open"></i><a
                            href="{{ route( $lang . 'front.ad.category.index.first.page', $ad['main_category'][0]['slug']) }}">
                            {{ $ad['main_category'][0]['name'] }}</a>
                    </figure>
                @endif
            </div>
        </div>
    </div>
</div>
