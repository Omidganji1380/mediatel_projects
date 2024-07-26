<section class="index-blog blog-block pt-5 p-md-0 pt-md-5 pb-md-5">
    <div class="container">
        <div class="section-title clearfix">
            <h2>{{ $title }}</h2>
        </div>
        <div class="row">
            @foreach ($ads as $group)
                @foreach ($group as $ad)
                    @if($ad->adOrder)
                        <div class="col-12 col-md-4 p-2">
                            <img src="{{ $ad->adOrder?->getFirstMediaUrl(App::isLocale('fa') ? 'BlogSidebarFa' : 'BlogSidebarEn') }}" class="w-100" alt="">
                        </div>
                    @endif
                @endforeach
            @endforeach
        </div>
    </div>
</section>
