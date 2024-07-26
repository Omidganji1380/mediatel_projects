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
    <img src="{{ $src }}" alt="" width="100px">
    <div class="col-7">
        <p>{{ $ad['title'] }}</p>
        <div class="little-font-favarot">
            <span class="text-secondary"><i class="far fa-calendar-week"></i> {{ Carbon\Carbon::now()->diffForHumans($ad['created_at']) }}</span>
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
