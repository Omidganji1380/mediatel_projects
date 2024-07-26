<div class="main-navigation">
    <div class="container ">
        <nav class="navbar navbar-expand-lg navbar-light border-0 pb-0 mb-0 pt-1">
            @include('front.layouts.header.menu')
        </nav>
    </div>
    <p class="d-flex flex-sm-row justify-content-between col-11 col-md-12 border-top container colpas-button mb-2">
        <span class="my-2 text-title">
            <a href="{{ route('front.home') }}">{{ __('Home') }}</a>
            @switch(request()->route()?->getName())
                @case('front.rules')
                    / {{ __('Site Rules') }}
                @break

                @case('front.contact-us')
                    / {{ __('Contact Us') }}
                @break

                @case('front.ad.category.index.first.page')
                @case('front.ad.category.index')
                    @php
                        $class = new App\Services\AdCategory\AdCategory();
                    @endphp
                    @if(request()->category_page)
                        @foreach ($class->categoryAddress(request()->category_page) as $category)
                            @if ($loop->last)
                                @if (request()->page && request()->page > 1)
                                    / <a href="{{ route('front.ad.category.index.first.page', $category->slug) }}">
                                        {{ $category->locale_name }}</a> /
                                    {{ __('Page') }} {{ request()->page }}
                                @else
                                    / {{ $category->locale_name }}
                                @endif
                            @else
                                / <a href="{{ route('front.ad.category.index.first.page', $category->slug) }}">
                                    {{ $category->locale_name }}</a>
                            @endif
                        @endforeach
                    @endif
                @break

                @case('front.ad.tag.index.first.page')
                    /
                    {{ __('Tagged Products') }} “ {{ request()->tag_page->name }}”
                @break

                @case('front.ad.tag.index')
                    / <a href="{{ route('front.ad.tag.index.first.page', request()->tag_page->slug) }}">
                        {{ __('Tagged Products') }} “ {{ request()->tag_page->name }}”
                    </a> /
                    برگه {{ request()->page }}
                @break

                @case('front.ad.index')
                    @if (request()->page && request()->page > 1)
                        <a href="{{ route('front.ad.index') }}">/ {{ __('Ads') }}</a>
                        / {{ __('Page') }} {{ request()->page }}
                    @else
                        / {{ __('Ads') }}
                    @endif
                @break

                @case('front.ad.show')
                    @php
                        $class = new App\Services\AdCategory\AdCategory();
                    @endphp
                    @if (isset(request()->ad?->mainCategory) && count(request()->ad?->mainCategory))
                        @foreach ($class->categoryAddress(request()->ad->mainCategory[0]) as $category)
                            / <a href="{{ route('front.ad.category.index.first.page', $category->slug) }}">
                                {{ $category->locale_name }}</a>
                        @endforeach
                    @endif
                    / {{ request()->ad?->locale_title }}
                @break

                @case('front.blog.show')
                    <?php
                    /**
                     * @var \App\Models\Blog\Post $post
                     * */
                    $post = request()->post;
                    ?>
                    / <a
                        href="{{ route('front.blog.category.blog.index.first.page') }}">{{ $post?->category?->locale_name }}</a>
                    / {{ $post?->locale_title }}
                @break

                @case('front.panel.user.profile.show')
                    / {{ __('Profile') }}
                @break

                <!-- English routes -->
                @case('en.front.rules')
                    / {{ __('Site Rules') }}
                @break

                @case('en.front.contact-us')
                    / {{ __('Contact Us') }}
                @break

                @case('en.front.ad.category.index.first.page')

                @case('en.front.ad.category.index')
                    @php
                        $class = new App\Services\AdCategory\AdCategory();
                    @endphp
                    @if(request()->category_page)
                        @foreach ($class->categoryAddress(request()->category_page) as $category)
                            @if ($loop->last)
                                @if (request()->page && request()->page > 1)
                                    / <a href="{{ route('en.front.ad.category.index.first.page', $category->slug) }}">
                                        {{ $category->locale_name }}</a> /
                                    {{ __('Page') }} {{ request()->page }}
                                @else
                                    / {{ $category->locale_name }}
                                @endif
                            @else
                                / <a href="{{ route('en.front.ad.category.index.first.page', $category->slug) }}">
                                    {{ $category->locale_name }}</a>
                            @endif
                        @endforeach
                    @endif
                @break

                @case('en.front.ad.tag.index.first.page')
                    /
                    {{ __('Tagged Products') }} “ {{ request()->tag_page->name }}”
                @break

                @case('en.front.ad.tag.index')
                    / <a href="{{ route('en.front.ad.tag.index.first.page', request()->tag_page->slug) }}">
                        {{ __('Tagged Products') }} “ {{ request()->tag_page->name }}”
                    </a> /
                    برگه {{ request()->page }}
                @break

                @case('en.front.ad.index')
                    @if (request()->page && request()->page > 1)
                        <a href="{{ route('en.front.ad.index') }}">/ {{ __('Ads') }}</a>
                        / {{ __('Page') }} {{ request()->page }}
                    @else
                        / {{ __('Ads') }}
                    @endif
                @break

                @case('en.front.ad.show')
                    @php
                        $class = new App\Services\AdCategory\AdCategory();
                    @endphp
                    @if (isset(request()->ad?->mainCategory) && count(request()->ad?->mainCategory))
                        @foreach ($class->categoryAddress(request()->ad->mainCategory[0]) as $category)
                            / <a href="{{ route('en.front.ad.category.index.first.page', $category->slug) }}">
                                {{ $category->locale_name }}</a>
                        @endforeach
                    @endif
                    / {{ request()->ad?->locale_title }}
                @break

                @case('en.front.blog.show')
                    <?php
                    /**
                     * @var \App\Models\Blog\Post $post
                     * */
                    $post = request()->post;
                    ?>
                    / <a
                        href="{{ route('en.front.blog.category.blog.index.first.page') }}">{{ $post?->category?->locale_name }}</a>
                    / {{ $post?->locale_title }}
                @break

                @case('en.front.panel.user.profile.show')
                    / {{ __('Profile') }}
                @break

            @endswitch
        </span>
        <button class="btn btn-primary search-icon-btn" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            <i class="far fa-search text-white"></i>
            <i class="fas fa-times text-white"></i>
        </button>
    </p>
    @if (request()->route()?->named('front.login-register'))
        <div class="text-center">
            <a href="http://t.me/Kiuskcanada_bot" target="_blank"><i class="fab fa-telegram text-primary"></i>
                <strong>{{ __('Telegram bot') }}</strong></a>
            <p>{{ __('messages.telegram_bot_description') }}</p>
        </div>
    @endif
    {{-- @case('front.login-register')
    @break --}}
    <div class="collapse" id="collapseExample">
        @livewire('front.ad.search')
    </div>
    <div class="container pt-4 p-lg-0 pt-lg-0 pb-lg-0" style="z-index: 100">
        {{-- <div class="container p-3 pt-4 p-lg-0 pt-lg-4 pb-lg-5 pb-5" style="z-index: 100"> --}}

        {{--  <h1 id="headerTitle">آخرین آگهی‌ها</h1> --}}
        @switch(request()->route()?->getName())
            @case('front.rules')
                <a href="{{ route('front.rules') }}">
                    <h1 id="headerTitle"> {{ __('Site Rules') }}</h1>
                </a>
            @break

            @case('front.contact-us')
                <a href="{{ route('front.contact-us') }}">
                    <h1 id="headerTitle">{{ __('Contact Us') }}</h1>
                </a>
            @break

            @case('front.ad.category.index.first.page')
            @case('front.ad.category.index')
                @if(request()->category_page)
                    <h1 id="headerTitle">
                        {{ $title ?? '' }}
                        @if (request()->category_page->type === 'business_owner')
                            {{ __('List of businesses of') }} {{ request()->category_page->locale_name }} <span id="textBeforeState"></span>
                        @else
                            {{ __('List of ads of') }} {{ request()->category_page->locale_name }} <span id="textBeforeState"></span>
                        @endif
                        <span id="stateName"></span> <span id="cityName"></span> |
                        {{-- @if (request()->page && request()->page > 1)
                            {{ __('page') }} {{ request()->page }} {{ __('from') }} {{ request()->total_page }} |
                        @endif --}}
                        {{ s()->headerTextClose }}
                    </h1>
                @endif
            @break

            @case('front.ad.show')

                <?php
                /**
                 * @var App\Models\Ad\Ad $ad
                 * */
                $ad = request()->ad;
                ?>
                {{-- <a href="{{ route('front.ad.show', $ad->slug) }}">
                    <h1 id="headerTitle">{{ $ad->locale_title }}</h1>
                </a>

                <div class="d-flex justify-content-between pt-2">
                    <span class="text-secondary"><i class="fal fa-map-marker-alt m-1"></i>
                        @if ($ad?->state)
                            <a href="{{ route('front.ad.category.city.index.first.page', $ad?->state->slug) }}">
                                {{ $ad?->state->locale_name }}
                            </a>
                        @elseif($ad?->state && $ad?->city)
                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                        @elseif($ad?->city)
                            <a href="{{ route('front.ad.category.city.index.first.page', $ad?->city->slug) }}">
                                {{ $ad?->city->locale_name }}
                            </a>
                        @endif
                    </span>
                    <h4 class="text-secondary">
                        <livewire:front.ad.show.contact-info :ad="$ad">
                    </h4>
                </div> --}}
            @break

            @case('front.blog.show')
                <?php
                /**
                 * @var \App\Models\Blog\Post $post
                 * */
                $post = request()->post;
                ?>
                <a href="{{ $post?->link }}">
                    <h1 id="headerTitle">{{ $post?->locale_title }}</h1>
                </a>
                <div class="d-flex justify-content-between pt-2">
                    <div class="text-secondary d-flex details align-items-center">
                        <h5><i class="far fa-bookmark"></i>
                            {{ $post?->category?->locale_name }}
                        </h5>
                        <span class="ms-4">
                            <i class="fa fa-calendar-o"></i>
                            {{ $post?->created_at?->diffForHumans() }}</span>
                        </span><span><i class="fa fa-pie-chart" aria-hidden="true"></i> {{ $post?->views }}
                            {{ __('View') }}</span>
                    </div>
                </div>
            @break

            @case('front.panel.user.profile.show')
                <a href="{{ route('front.panel.user.profile.show') }}">
                    <h1 id="headerTitle">{{ __('Profile') }}</h1>
                </a>
            @break
            @case('en.front.rules')
                <a href="{{ route('en.front.rules') }}">
                    <h1 id="headerTitle"> {{ __('Site Rules') }}</h1>
                </a>
            @break

            @case('en.front.contact-us')
                <a href="{{ route('en.front.contact-us') }}">
                    <h1 id="headerTitle">{{ __('Contact Us') }}</h1>
                </a>
            @break

            @case('en.front.ad.category.index.first.page')
            @case('en.front.ad.category.index')
                @if(request()->category_page)
                    <h1 id="headerTitle">
                        {{ $title ?? '' }}
                        @if (request()->category_page->type === 'jobs')
                            {{ __('List of jobs of') }} {{ request()->category_page->locale_name }} <span id="textBeforeState"></span>
                        @else
                            {{ __('List of ads of') }} {{ request()->category_page->locale_name }} <span id="textBeforeState"></span>
                        @endif
                        <span id="stateName"></span> <span id="cityName"></span> |
                        {{-- @if (request()->page && request()->page > 1)
                            {{ __('page') }} {{ request()->page }} {{ __('from') }} {{ request()->total_page }} |
                        @endif --}}
                        {{ s()->headerTextClose }}
                    </h1>
                @endif
            @break

            @case('en.front.ad.show')

                <?php
                /**
                 * @var App\Models\Ad\Ad $ad
                 * */
                $ad = request()->ad;
                ?>
                {{-- <a href="{{ route('en.front.ad.show', $ad->slug) }}">
                    <h1 id="headerTitle">{{ $ad->locale_title }}</h1>
                </a>

                <div class="d-flex justify-content-between pt-2">
                    <span class="text-secondary"><i class="fal fa-map-marker-alt m-1"></i>
                        @if ($ad?->state)
                            <a href="{{ route('en.front.ad.category.city.index.first.page', $ad?->state->slug) }}">
                                {{ $ad?->state->locale_name }}
                            </a>
                        @elseif($ad?->state && $ad?->city)
                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                        @elseif($ad?->city)
                            <a href="{{ route('en.front.ad.category.city.index.first.page', $ad?->city->slug) }}">
                                {{ $ad?->city->locale_name }}
                            </a>
                        @endif
                    </span>
                    <h4 class="text-secondary">
                        <livewire:en.front.ad.show.contact-info :ad="$ad">
                    </h4>
                </div> --}}
            @break

            @case('en.front.blog.show')
                <?php
                /**
                 * @var \App\Models\Blog\Post $post
                 * */
                $post = request()->post;
                ?>
                <a href="{{ $post?->link }}">
                    <h1 id="headerTitle">{{ $post?->locale_title }}</h1>
                </a>
                <div class="d-flex justify-content-between pt-2">
                    <div class="text-secondary d-flex details align-items-center">
                        <h5><i class="far fa-bookmark"></i>
                            {{ $post?->category?->locale_name }}
                        </h5>
                        <span class="ms-4">
                            <i class="fa fa-calendar-o"></i>
                            {{ $post?->created_at?->diffForHumans() }}</span>
                        </span><span><i class="fa fa-pie-chart" aria-hidden="true"></i> {{ $post?->views }}
                            {{ __('View') }}</span>
                    </div>
                </div>
            @break

            @case('en.front.panel.user.profile.show')
                <a href="{{ route('front.panel.user.profile.show') }}">
                    <h1 id="headerTitle">{{ __('Profile') }}</h1>
                </a>
            @break

        @endswitch
    </div>
    <div class="background" style=";z-index: -10">
        <div class="background-image original-size"
            style="background-image: url({{ asset('images/hero-background-icons (1).jpg') }})">
            <img src="{{ asset('storage/' . s()->headerBackgroundImage) }}" alt="{{ s()->headerText }}"
                style=";z-index: -10">
        </div>
    </div>
</div>
{{-- <div class="after_header"></div> --}}

@push('scripts')
    <script>
        $(document).ready(function() {


            $(".navbar-toggler").on("click", function() {
                $("#ad-create-ol").toggle("ad-create-ol ad-create-ol-nav-open");
            });
        });
    </script>
@endpush
