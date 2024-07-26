@push('styles')
    <style>
        .ca-image-mobile{
            width: 100%;
        }

        /* .ads-container-jmw29CAsa5kBGNKJ,
        .ads-container-n91SuOUhx4mMPaXS,
        .ads-container-gSA7XAVeHXk4eX7P {
            display: flex;
            justify-content: center;
        }

        .ads-container-jmw29CAsa5kBGNKJ a img,
        .ads-container-n91SuOUhx4mMPaXS a img,
        .ads-container-gSA7XAVeHXk4eX7P a img {
            width: 100%;
        } */
    </style>
@endpush

<div class="col-12 col-md-8">
    <div class="bg-white mb-4">
        <article class="paragraph">
            <div class="card text-white front-opacity">
                <img src="{{ $post->getFirstMediaUrl('SpecialImage') }}" class="card-img" alt="...">
            </div>
            {{--

                todo must be edit 900
            --}}
            @if ($post->id > 900)
                <h5 class="card-title mt-4 ms-3">{{ $post->locale_title }}</h5>
            @endif
            <div class="p-4 ">
                <div class="ck-content">
                    {{--     @dump($post->content) --}}
                    {{-- {!! $post->content !!} --}}
                    {!! $description !!}
                </div>
                <div>
                    <div class="row justify-content-between {{ App::isLocale('en') ? 'flex-row-reverse' : '' }}">
                        @php
                            $post3 = \App\Models\Blog\Post::oldest()
                                ->where('id', '>', $post->id)
                                ->first();
                        @endphp
                        @if ($post3)
                            <div class="col text-start  justify-content-start">
                                <!--rounded اضاقه کردن کلاس  -->
                                <a class="text-dark" href="{{ $post3->link }}">
                                    <div class="bg-light rounded p-3 col-md-12 next_icon_div">
                                        <i class="fa fa-chevron-right next_icon"></i>
                                        <span class="text-secondary links text-right">{{ __('Next Contents') }}</span>
                                        <p class="text-start mt-2 links">{{ $post3->locale_title }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endif
                        @php
                            $post2 = \App\Models\Blog\Post::latest()
                                ->where('id', '<', $post->id)
                                ->first();
                        @endphp
                        @if ($post2)
                            <div class="col text-end  justify-content-end">
                                <a class="text-dark" href="{{ $post2->link }}">
                                    <div class="bg-light rounded p-3 col-md-12 before_icon_div">
                                        <i class="fa fa-chevron-left before_icon"></i>
                                        <span
                                            class="text-secondary links text-left text-center">{{ __('Previous Contents') }}</span>
                                        <p class="text-start mt-2 links">
                                            {{ $post2->locale_title }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </article>
    </div>
    @php

        $posts = \App\Models\Blog\Post::with([
            'category',
            'media' => function ($q) {
                $q->whereCollectionName('SpecialImage');
            },
        ])
            ->whereHas('category', function ($q) use ($post) {
                $q->whereId($post->blog_category_id);
            })
            ->isVisible()
            ->latest()
            ->limit(s()->numberPostsShowBlogPage)
            ->get()
            ->chunk(3);

        $ads = App\Models\Advertisement::inRandomOrder()
            ->whereHas('adOrder')
            ->active()
            ->take(6)
            ->get()
            ->chunk(3);
    @endphp

    @if ($ads?->count())
        @includeWhen($ads?->count(), 'front.pages.home.home.suggested-contents', [
            'posts' => $ads,
            'title' => __('Suggested Content'),
        ])
    @else
        <section class="pt-5 p-md-0 pt-md-5 pb-md-5">
            <div class="container">
                <div class="section-title clearfix">
                    <h2>{{ __('Suggested Content') }}</h2>
                </div>
                <div class="container">
                    <div>
                        <script src="https://web.adminbot.ca/ads/canada-ads.js?version=1.0" data-uid="eF85NjUfCt0KdEnz" data-type="wide"></script>
                    </div>
                    {{-- <script src="https://web.adminbot.ca/ads/canada-ads.js" data-uid="WQLsISogSehCGKLm"></script> --}}
                </div>
            </div>
        </section>
    @endif

    @includeWhen($posts->count() , 'front.pages.home.home.articles', [
        'posts' => $posts,
        'title' => __('Latest Blog'),
        'css' => '',
    ])


    <div>
        @auth
            <div class="rating">
                @for ($i = 1; $i <= 5; $i++)
                    <span class="star {{ $rating >= $i ? 'filled' : '' }}" wire:click="rate({{ $i }})"
                        wire:mouseover="highlightStar({{ $i }})" wire:mouseout="resetStars">&#9733;</span>
                @endfor
            </div>
            <p>{{ __('Current rating') }}: {{ $rating }}</p>
        @else
            <p class="fs-6 px-3">
                <i class="fa fa-star text-secondary"></i> {!! __('messages.rate_login_message', ['url' => route($lang . 'front.login-register')]) !!}
            </p>

        @endauth
    </div>

    <div id="comment" class="px-3">
        <h3>{{ __('Express your opinion') }} </h3>
        @auth()
            <p>{{ __('messages.comment_username', ['username' => auth()->user()->name]) }}</p>
        @endauth
        @guest()
            <p class="fs-6"><i class="fa fa-comment text-secondary"></i> {!! __('messages.comment_login_message', ['url' => route($lang . 'front.login-register')]) !!}</p>
        @endguest
        @auth
            <form wire:submit.prevent="storeComment">
                <div id="spinner" wire:loading wire:target="storeComment">
                    <img src="{{ asset('images/ajax-loader.gif') }}" />
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">{{ __('Comment') }} </label>
                    <textarea wire:model.defer="content" class="form-control @error('content') is-invalid @enderror"
                        id="exampleFormControlTextarea1" rows="6"></textarea>
                    @error('content')
                        <span class=" text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">{{ __('Name') }}*</label>
                        <input type="text" wire:model.defer="name"
                            class="form-control m-0 @error('name') is-invalid @enderror" id="name">
                        @error('name')
                            <span class=" text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">{{ __('Email') }}*</label>
                        <input type="email" wire:model.defer="email"
                            class="form-control m-0 @error('email') is-invalid @enderror" id="inputPassword4">
                        @error('email')
                            <span class=" text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <label for="inputAddress" class="form-label">{{ __('Website') }}</label>
                    <input type="text" wire:model.defer="site"
                        class="form-control m-0 @error('site') is-invalid @enderror" id="inputAddress">
                    @error('site')
                        <span class=" text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button class="btn btn-primary" type="submit">{{ __('Submit Comment') }}
                </button>
            </form>
        @endauth
    </div>
    <div class="accordion accordion-flush mt-3 mb-4 rounded">
        <div class="row d-flex justify-content-center">
            <div class="">
              <div class="card shadow-0 border p-0" style="background-color: #f0f2f5;">
                <div class="card-body p-0">

                    @forelse($comments as $comment)
                        <div class="card {{ $loop->last ? "" : "mb-4"}}">
                            <div class="card-body p-3">
                            <p>{{ $comment->content }}</p>

                            <div class="d-flex justify-content-between">
                                <div class="d-flex flex-row align-items-center">
                                <img src="{{ $comment->user?->getFirstMedia('profile')?->getUrl() ?: asset('images/avatar.png') }}" alt="avatar" width="25"
                                    height="25" />
                                <p class="small mb-0 ms-2">{{ $comment->user?->full_name ?: $comment->user?->phone }}</p>
                                </div>
                                <div class="d-flex flex-row align-items-center">
                                    <p class="small text-muted mb-0">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            </div>
                        </div>
                    @empty
                        <p class="p-2">{{ __('No comments yet.') }}</p>
                    @endforelse
                </div>
              </div>
            </div>
          </div>
    </div>
</div>
