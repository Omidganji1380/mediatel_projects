@extends('front.base')
@section('seo')
@endsection
@section('content')
    <section class=" blog-block m-0 pt-5">
        <div class="container">
            <article>
                <div class="row justify-content-center justify-content-md-between pt-4">
                    @include('front.layouts.partials.blog_sidebar')
                    {{-- <div class="col-4 hidden">
                        <div class="mb-3 rounded bg-white shadow-2">
                            <div class="p-2">
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
                            </div>
                            <div class="border-bottom pt-3">
                                <ul class="d-flex justify-content-around px-1 border-bottom-0 nav nav-tabs" id="blog_posts_sidebar">
                                    <li class="border-bottom-0 nav-item">
                                        <a class="nav-link p-2 fs-6 active" data-bs-toggle="tab" aria-current="true" href="#top_viewed">{{ __('Top Viewed') }}</a>
                                    </li>
                                    <li class="border-bottom-0 nav-item">
                                        <a class="nav-link p-2 fs-6" data-bs-toggle="tab" href="#top_rated">{{ __('Top Rated') }}</a>
                                    </li>
                                    <li class="border-bottom-0 nav-item">
                                        <a class="nav-link p-2" data-bs-toggle="tab" href="#top_controversial">{{ __('Most Recent') }}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="top_viewed">
                                    <div class="card-body">
                                        <ul class="pe-2 ps-2 list-style-type blue-list-style">
                                            @php
                                                $latestPosts = \App\Models\Blog\Post::latest()
                                                    ->limit(s()->numberPostsSidebarIndexBlogPage)
                                                    ->get();
                                            @endphp
                                            @foreach ($latestPosts as $blog)
                                                <li>
                                                    <a href="{{ $blog->link }}">{{ $blog->title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane" id="top_rated">
                                    <div class="card-body">
                                        <ul class="pe-2 ps-2 list-style-type blue-list-style">
                                            @php
                                                $latestPosts = \App\Models\Blog\Post::inRandomOrder()
                                                    ->limit(s()->numberPostsSidebarIndexBlogPage)
                                                    ->get();
                                            @endphp
                                            @foreach ($latestPosts as $blog)
                                                <li>
                                                    <a href="{{ $blog->link }}">{{ $blog->title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane" id="top_controversial">
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
                                </div>
                            </div>

                        </div>
                        <div class="mb-3 rounded bg-white shadow-2">
                            <div class="p-2">
                                <h5 class="text-center border-bottom p-2">{{ __('Latest News') }}</h5>
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
                            </div>
                        </div>
                        <div class="mb-3 rounded bg-white shadow-2">
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
                                                        href="{{ route('front.ad.show', [$ad->slug]) }}">{{ $ad?->title }}</a>
                                                    <p class="text-success text-little">تماس بگیرید</p>
                                                </div>
                                                <div class="p-2 pe-0 pb-0">
                                                    <a href="{{ route('front.ad.show', [$ad->slug]) }}">
                                                        <img src="{{ $ad?->getFirstMedia('SpecialImage')?->getUrl('70_70') }}"
                                                            alt="" width="55px" height="55px" class="border">
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div> --}}
                    <!--  -->
                    <div class="col-10 col-md-8">
                        <div>
                            @forelse($posts as $post)
                                <article class="rounded shadow-2 d-flex p-md-4 mb-3 bg-white flex-wrap flex-lg-nowrap">
                                    <a class="col-12 col-md-4 d-inline-block rounded position-relative"
                                        href="{{ $post->link }}">
                                        <img src="{{ $post?->getFirstMedia('SpecialImage')?->getUrl('thumb') ?: asset('images/kiusk-placeholder.jpg') }}"
                                            alt="" class="poster rounded" width="220px" height="170px">
                                        <span class="date">{{ $post->created_at->diffForHumans() }}</span>
                                    </a>
                                    <div class="ms-0 ms-md-0 p-2 pt-3 p-lg-0 article-para">
                                        <a href="{{ $post->link }}">
                                            <h2 class="text-secondary card_blog_title">{{ $post->locale_title }}</h2>
                                        </a>
                                        <p class="text-secondary">{!! $post->limit_content !!}</p>
                                        <a href="{{ $post->link }}" class="text-success text-little">{{ __('Read More') }}</a>
                                        <div class="d-flex justify-content-between justify-content-sm-end align-items-sm-end h-25">
                                            <small class="mx-sm-3 text-secondary"><i class="fa fa-eye text-info"></i> {{ $post->views }}</small>
                                            <small class="text-secondary"><i class="fa fa-heart text-danger"></i> {{ $post->favorites_count }}</small>
                                        </div>
                                    </div>
                                </article>
                            @empty
                                <article class="rounded shadow-2 d-flex p-md-4 mb-3 bg-white flex-wrap">
                                    {{ __('There is no blog!') }}
                                </article>
                            @endforelse
                            @if ($posts->count())
                                <div class="mt-3 w-100 d-flex justify-content-center overflow-auto">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            @foreach ($urls as $url)
                                                <li
                                                    class="page-item rounded @if ($url['active']) active @endif  @if (!$url['url']) disabled @endif">
                                                    <a class="page-link  bg-transparent"
                                                        href="{{ $url['url'] }}">{!! $url['label'] !!}</a></li>
                                            @endforeach
                                        </ul>
                                    </nav>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
@endsection
