<section class="blog-block m-0 p-4 p-md-0">
    <div class="container pb-5 mb-5">
        <div class="border-bottom mb-5">
            <h4 class="heading-border d-inline-block">{{ $title }}</h4>
        </div>
        <div class="col-12 cards ads-card-title-blue">
            <div class="owl-carousel">
                @foreach ($ads as $ad)
                    <livewire:front.ad.card :ad="$ad" />
                @endforeach
            </div>
        </div>
    </div>
</section>
