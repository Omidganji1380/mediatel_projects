@extends('front.base')
@section('head')
<style>
    .carousel-control-prev, .carousel-control-next{
        top: 150px;
        bottom: 60px;
    }
</style>
@endsection
@section('seo')
@endsection
@section('content')
    {{-- <div class="mb-3">
        <img src="{{ asset('images/nowruz.jpg') }}" class="w-100" alt="">
    </div> --}}

    {{-- <livewire:front.ad.last-ads :category="$category" :ads="$category->ads" :banners="$banners[$key] ?? []"> --}}
    @php $i = -1; @endphp
    @php $j = -1; @endphp
    @foreach ($categories as $key => $category)
        @php
            $banner = $category->has_banner ? ($banners[++$i] ?? []) : [];
            $advertisement = $category->has_banner ? ($advertisements[++$j] ?? []) : [];
        @endphp
        <livewire:front.ad.last-ads :category="$category" :banners="$banner" :advertisements="$advertisement" :key="$category->id">
        {{-- <div class="m-auto mt-3 main-page-ad">
            @if (isset($selectedAds[$category->id]))
            @php
                $ad = $selectedAds[$category->id];
            @endphp
                <a href="{{ route($lang . 'front.advertisement.index') }}">
                    <img src="{{ App::isLocale('fa') ? $ad->getFirstMediaUrl('HomeBgLargeFa') : $ad->getFirstMediaUrl('HomeBgLargeEn') }}" alt="" class="w-100">
                </a>
            @else
                <a href="{{ route($lang . 'front.advertisement.index') }}">
                    <img src="{{ asset(App::isLocale('fa') ? 'images/ads-main-fa.jpg' : 'images/ads-main-en.jpg') }}" alt="" class="w-100">
                </a>
            @endif
        </div> --}}
    @endforeach

    @php
        $posts = \App\Models\Blog\Post::with([
            'category',
            'favorites',
            'media' => function ($q) {
                $q->whereCollectionName('SpecialImage');
            },
        ])
            ->withCount('favorites')
            ->latest()
            ->lang()
            ->limit(s()->numberBlogPostsHomePage)
            ->get()
            ->chunk(4);
    @endphp
    @include('front.pages.home.home.articles', [
        'posts' => $posts,
        'title' => __('Blog'),
        'css' => 'row-cols-md-4',
    ])
@endsection

@section('script')
    <script>
        // $(document).ready(function() {
        //     $(".more-content").slice(0, {{ s()->numberAdsHomePage }}).show();
        //     $(".loadmore").on("click", function(e) {
        //         e.preventDefault();
        //         $(".more-content:hidden").slice(0, 8).slideDown();
        //         if ($(".more-content:hidden").length == 0) {
        //             $(".loadmore")
        //                 // .text("وجود ندارد")
        //                 .addClass("noContent");
        //         }
        //     });
        // })
    </script>
@endsection
