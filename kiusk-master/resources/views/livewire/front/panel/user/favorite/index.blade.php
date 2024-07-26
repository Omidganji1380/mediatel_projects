<div>
    <div class="section-title clearfix">
        <h2>{{ __('Favorites') }}</h2>
        @if (count($ads))
            <button wire:click="beforeDeleteAll" class="p-2 btn btn-primary position-absolute end-0"><i
                    class="fas fa-trash-alt me-2"></i> {{ __('Delete All') }}
            </button>
        @endif
    </div>
    <div>
        @if ($local)
            <script !src="">
                document.cookie = 'favorites=@json($favorits); expires=Thu, 18 Dec 2045 12:00:00 UTC; path=/';
            </script>
        @endif

        @forelse($ads as $ad)
            {{--   @livewire('front.panel.user.favorite.card',['ad'=>$ad]) --}}
            <div class="d-flex justify-content-between bg-white p-3 rounded">
                @if ($local)
                    <script !src="">
                        document.cookie = 'favorites=@json($favorites); expires=Thu, 18 Dec 2045 12:00:00 UTC; path=/';
                    </script>
                @endif
                <?php
                foreach ($ad['media'] as $item) {
                    if ($item['collection_name'] === 'SpecialImage') {
                        $m = new \Spatie\MediaLibrary\MediaCollections\Models\Media($item);
                        $src = $m->getUrl('70_70');
                    }
                }
                ?>
                <a href="{{ route('front.ad.show', ['slug' => $ad['slug']]) }}">
                    <img src="{{ $src }}" alt="" width="100px">
                </a>
                <div class="col-7">
                    <a href="{{ route('front.ad.show', ['slug' => $ad['slug']]) }}">
                        <p>{{ $ad['title'] }}</p>
                    </a>
                    <div class="little-font-favarot">
                        <span class="text-secondary"><i class="far fa-calendar-week"></i>
                            {{ date('Y-m-d', strtotime($ad['created_at'])) }}</span>
                        @if (isset($ad['main_category']) && count($ad['main_category']))
                            <span class="text-secondary ms-2"><i class="fas fa-folder-open"></i><a
                                    href="{{ route('front.ad.category.index.first.page', $ad['main_category'][0]['slug']) }}">
                                    {{ $ad['main_category'][0]['name'] }}</a></span>
                        @endif
                    </div>
                </div>
                <div wire:click="beforeDelete({{ $ad['id'] }})">
                    <i class="fas fa-bookmark"></i>
                </div>
            </div>
        @empty
            <div>
                <p>{{ __('You have not added an ad yet.') }}</p>
            </div>
        @endforelse
    </div>
</div>
