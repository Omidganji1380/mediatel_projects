@include('front.layouts.header.header-black')
@if (request()->routeIs(
    'front.blog.category.news.index.first.page',
    'front.blog.category.news.index',
    'front.blog.category.blog.index',
    'front.home',
    'en.front.blog.category.news.index.first.page',
    'en.front.blog.category.news.index',
    'en.front.blog.category.blog.index',
    'en.front.home'
    ))
    @include('front.layouts.header.mainNavigationOpen')
@else
    @include('front.layouts.header.mainNavigationClose')
@endif
