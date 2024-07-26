<div>
    @php
        $timestamp = now()->format('Y-m-d H:i:s');
        \Illuminate\Support\Facades\Log::info("Current timestamp: $timestamp");
    @endphp
    <section class=" blog-block m-0 p-2 paragrapg-margin">
        <div class="container border-0">
            <div class="row">
                <div class="col-12 col-md-8 pt-0">
                    @if ($ad->mainCategory->first()?->type === 'real_estate')
                        <section id="main-carousel" class="splide" aria-label="main ads slider" dir="ltr">
                            <div class="splide__track">
                                <ul class="splide__list image-box">
                                    <li class="splide__slide">
                                        @if (App::isLocale('fa'))
                                            <img src="{{ $ad->getFirstMediaUrl('SpecialImage') ?: asset('images/kiusk-placeholder.jpg') }}"
                                                class="img-fluid w-100" alt="{{ $ad->locale_title }}">
                                        @else
                                            <img src="{{ $ad->getFirstMediaUrl('SpecialImageEn') ?: ($ad->getFirstMediaUrl('SpecialImage') ?: asset('images/kiusk-placeholder.jpg'))  }}"
                                                class="img-fluid w-100" alt="{{ $ad->locale_title }}">
                                        @endif
                                    </li>
                                    @foreach ($ad->getMedia('Gallery') as $image)
                                        <li class="splide__slide"><img src="{{ $image->getUrl() }}"
                                                class="d-block w-100"></li>
                                    @endforeach
                                </ul>
                            </div>
                        </section>
                        <section id="thumbnail-carousel" class="splide mt-2"
                            aria-label="The carousel with thumbnails. Selecting a thumbnail will change the Beautiful Gallery carousel.">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    <li class="splide__slide">
                                        @if (App::isLocale('fa'))
                                            <img src="{{ $ad->getFirstMediaUrl('SpecialImage') ?: asset('images/kiusk-placeholder.jpg') }}"
                                                class="img-fluid w-100" alt="{{ $ad->locale_title }}">
                                        @else
                                            <img src="{{ $ad->getFirstMediaUrl('SpecialImageEn') ?: ($ad->getFirstMediaUrl('SpecialImage') ?: asset('images/kiusk-placeholder.jpg')) }}"
                                                class="img-fluid w-100" alt="{{ $ad->locale_title }}">
                                        @endif
                                    </li>
                                    @foreach ($ad->getMedia('Gallery') as $image)
                                        <li class="splide__slide">
                                            <img src="{{ $image->getUrl() }}" class="d-block w-100">
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </section>
                    @else
                        @if (App::isLocale('fa'))
                            <img src="{{ $ad->getFirstMediaUrl('SpecialImage') ?: asset('images/kiusk-placeholder.jpg') }}"
                                class="img-fluid w-100" alt="{{ $ad->locale_title }}" style="max-height: 613px;">
                        @else
                            <img src="{{ $ad->getFirstMediaUrl('SpecialImageEn') ?: ($ad->getFirstMediaUrl('SpecialImage') ?: asset('images/kiusk-placeholder.jpg')) }}"
                                class="img-fluid w-100" alt="{{ $ad->locale_title }}" style="max-height: 613px;">
                        @endif
                    @endif
                    <div class="accordion accordion-flush mt-4 rounded" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button  pb-0 ps-0  border-bottom-accordin" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    <h4 class="heading-border">{{ __('Ad Description') }}</h4>
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="ck-content-ad  ad-description">
                                        {!! $ad->locale_content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box d-md-none">
                        <div class="row contact-box">
                            <button type="button" wire:click="showContactInfo"
                                class="btn btn-primary info-btn col-6 col-md-6 col-sm-12 pull-right contact_info">{{ __('Contact Info') }}
                            </button>
                            @if($ad->user_id == auth()->id())
                                <a href="{{ route($lang . 'front.panel.user.ad.edit', $ad->id) }}" class="btn btn-secondary col-4 pt-2 pb-2">{{ __('Edit') }}</a>
                            @endif
                            @if ($local)
                                <script !src="">
                                    document.cookie = 'favorites=@json($favorits); expires=Thu, 18 Dec 2045 12:00:00 UTC; path=/';
                                </script>
                            @endif
                            <button data-toggle="tooltip" data-placement="top" title="" wire:click="favorite"
                                type="button" onclick=""
                                class="btn info-btn btn-primary btn-icon btn-framed col-md-6 col-sm-12 pull-right">
                                <i class="@if ($isFavorite) fas @else fal @endif fa-bookmark"></i>
                            </button>
                        </div>
                        <ul class="p-0 info-contact">
                            <li class="border-bottom d-flex justify-content-between p-2">
                                <span>{{ __('Category') }}</span>
                                @foreach ($ad->categories as $category)
                                    <span><a
                                            href="{{ route('front.ad.category.index.first.page', ['slug' => $category->slug]) }}">{{ $category->locale_name }}</a></span>
                                @endforeach
                            </li>
                            <li class="border-bottom d-flex justify-content-between p-2">
                                <span>{{ __('City') }}/ {{ __('District') }}</span>
                                <span>
                                    @if ($ad?->city)
                                        <a
                                            href="{{ route('front.ad.category.city.index.first.page', ['slug' => $ad?->city->slug]) }}">{{ $ad?->city->name }}</a>
                                    @endif
                                </span>
                            </li>
                            <li class="border-bottom d-flex justify-content-between p-2">
                                <span>{{ __('Published Date') }}</span>
                                <span>{{ \Carbon\Carbon::parse($ad['created_at'])->setTimezone('America/Toronto')->diffForHumans() }}</span>
                            </li>
                            @foreach ($ad->attrs as $attribute)
                                @if ($attribute->is_visible_on_front)
                                    @switch($attribute->type)
                                        @case('Text')
                                        @case('Select')
                                            <li class="border-bottom d-flex justify-content-between p-2">
                                                <span>{{ $attribute->name }}</span><span>{{ $attribute->pivot->text }}</span>
                                            </li>
                                        @break
                                    @endswitch
                                @endif
                            @endforeach
                            <li class="d-flex justify-content-between pt-2 p-2">
                                <span>{{ __('Price') }}</span>
                                <span>
                                    @if ($ad->price)
                                        ${{ $ad->price }}
                                    @elseif($ad->is_visible_phone)
                                        <a href="tel:{{ $ad->phone }}" class="text-success">{{ __('Call') }}</a>
                                    @elseif($ad->is_visible_email)
                                        <a href="mailto:{{ $ad->email }}"
                                            class="text-success">{{ __('Call') }}</a>
                                    @else
                                        {{ __("The user's contact information is not available") }}
                                    @endif
                                </span>
                            </li>
                            {{-- <li class="border-top d-flex justify-content-between pt-2 p-2">
                                <span>{{ __('Website') }}</span>
                                <a href="#" wire:click="trackLinkClick('{{ $ad->website ?? $ad->slug }}')">{{ $ad->title }}</a>
                            </li> --}}
                            @auth
                                <li class="d-flex justify-content-between pt-2 p-2">
                                    <a
                                        href="{{ route($lang . 'front.panel.user.profile.edit', ['ad_slug' => $ad->slug]) . '#service_usage' }}">
                                        {{ __('Send Used Service/Contract/Purchase Proof') }}
                                    </a>
                                </li>
                            @endauth
                        </ul>
                        {{-- <div class="warning_ad">
                            {{ __('Address, phone number and website address of Iranian jobs and businesses in Canada') }}
                        </div> --}}
                        <section class="report_ad mt-3 d-flex justify-content-between">
                            @if ($ad->user)
                                <a href="{{ route('front.chat.message', ['id' => $ad->user->id]) }}"
                                    class="btn btn-sm btn-primary py-2">
                                    <i class="fa fa-comment-alt-dots mx-1"></i> {{ __('Message and Live Chat') }}
                                </a>
                            @endif
                            <a href="#" wire:click.prevent="report" class="align-self-center"><i
                                    class="fa fa-flag"></i>
                                {{ __('Report Problem') }}</a>
                        </section>
                    </div>
                    @if ($ad->realEstateDetail)
                        <div class="box d-md-none my-5">
                            <div class="row contact-box d-flex justify-content-center">
                                <h5>{{ __('The Property Details') }}</h5>
                            </div>
                            <ul class="p-0 info-contact">
                                <li class="border-bottom d-flex justify-content-between p-2">
                                    <span>{{ __('Area') }}</span>
                                    <span dir="ltr">{{ $ad->realEstateDetail->area }}
                                        {{ __('messages.area_unit_short.' . $ad->realEstateDetail->area_unit) }}</span>
                                </li>
                                <li class="border-bottom d-flex justify-content-between p-2">
                                    <span>{{ __('Rooms') }}</span>
                                    <span>
                                        {{ $ad->realEstateDetail->rooms }}
                                    </span>
                                </li>
                                <li class="border-bottom d-flex justify-content-between p-2">
                                    <span>{{ __('Bathrooms') }}</span>
                                    <span>{{ $ad->realEstateDetail->bathroom }}</span>
                                </li>
                                <li class="border-bottom d-flex justify-content-between p-2">
                                    <span>{{ __('Floor') }}</span>
                                    <span>{{ $ad->realEstateDetail->floor }}</span>
                                </li>
                                <li class="border-bottom d-flex justify-content-between p-2">
                                    <span>{{ __('Construction Year') }}</span>
                                    <span>{{ $ad->realEstateDetail->construction_year }}</span>
                                </li>
                                <li class="border-bottom d-flex justify-content-between p-2">
                                    <span>{{ __('Availability Date') }}</span>
                                    <span>{{ $ad->realEstateDetail->availability_date?->format('Y-m-d') }}</span>
                                </li>
                                @if ($ad->mainCategory->first()?->sale_type === 'rent')
                                    <li class="border-bottom d-flex justify-content-between p-2">
                                        <span>{{ __('Mortgage Price') }}</span>
                                        <span>${{ $ad->realEstateDetail->mortgage_price }}</span>
                                    </li>
                                    <li class="border-bottom d-flex justify-content-between p-2">
                                        <span>{{ __('Rent Price') }}</span>
                                        <span>${{ $ad->realEstateDetail->rent_price }}</span>
                                    </li>
                                @else
                                    <li class="border-bottom d-flex justify-content-between p-2">
                                        <span>{{ __('Sale Price') }}</span>
                                        <span>${{ $ad->realEstateDetail->sale_price }}</span>
                                    </li>
                                    <li class="border-bottom d-flex justify-content-between p-2">
                                        <span>{{ __('Yearly Tax') }}</span>
                                        <span>${{ $ad->realEstateDetail->yearly_tax }}</span>
                                    </li>
                                    <li class="border-bottom d-flex justify-content-between p-2">
                                        <span>{{ __('Keeping Price') }}</span>
                                        <span>${{ $ad->realEstateDetail->price_keep }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endif
                    @if ($ad->facilities?->count())
                        <div class="box d-md-none my-5">
                            <div class="row contact-box d-flex justify-content-center">
                                <h5>{{ __('The Property Facilities') }}</h5>
                            </div>
                            <ul class="p-0 info-contact">
                                @foreach ($ad->facilities->groupBy('type') as $type => $facilities)
                                    <h6 class="mb-t">{{ __('messages.facilities.' . $type) }}</h6>
                                    @foreach ($facilities->chunk(2) as $chunk)
                                        <li
                                            class="{{ $loop->last ? '' : 'border-bottom' }} d-flex justify-content-between p-2">
                                            @foreach ($chunk as $facility)
                                                <span><i class="fa fa-check"></i> {{ $facility->locale_name }}</span>
                                            @endforeach
                                        </li>
                                    @endforeach
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="accordion accordion-flush mt-3 mb-4 rounded" id="accordionFlushExampleThree">
                        <div class="accordion-item" id="rating">
                            <h2 class="accordion-header" id="flush-headingThree">
                                <button class="accordion-button  border-bottom pb-0 ps-0" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseThree"
                                    aria-expanded="false" aria-controls="flush-collapseThree">
                                    <h4 class="heading-border">{{ __('Ratings') }}</h4>
                                </button>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse show"
                                aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExampleThree">
                                <div class="accordion-body">
                                    {{-- <div>
                                        <p>{{ __('There are no reviews for this ad.') }}</p>
                                        <p>{{ __('messages.comment_title', ['title' => $ad->locale_title]) }}</p>
                                    </div> --}}
                                    <div>
                                        @auth
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span class="star {{ $rating >= $i ? 'filled' : '' }}"
                                                        wire:click="rate({{ $i }})"
                                                        wire:mouseover="highlightStar({{ $i }})"
                                                        wire:mouseout="resetStars">&#9733;</span>
                                                @endfor
                                            </div>
                                            <p>{{ __('Current rating') }}: {{ $rating }}</p>
                                        @else
                                            <p class="fs-6">
                                                <i class="fa fa-star text-secondary"></i> {!! __('messages.rate_login_message', ['url' => route($lang . 'front.login-register')]) !!}
                                            </p>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion accordion-flush mt-3 mb-4 rounded" id="accordionFlushExampleTwo">
                        <div class="accordion-item" id="review">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button  border-bottom pb-0 ps-0" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                                    aria-expanded="false" aria-controls="flush-collapseTwo">
                                    <h4 class="heading-border">{{ __('Express your opinion') }}</h4>
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse show"
                                aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExampleTwo">
                                <div class="accordion-body">
                                    <div>
                                        <p>{{ __('There are no reviews for this ad.') }}</p>
                                        <p>{{ __('messages.comment_title', ['title' => $ad->locale_title]) }}</p>
                                        <p>{{ __('Your email address will not be published. Required sections are marked') }}
                                            * </p>
                                    </div>
                                    <div>
                                        @if (Auth::check())
                                            <form action="" id="adShowFormComment">
                                                <div id="spinner" wire:loading wire:loading
                                                    wire:target="storeComment">
                                                    <img src="{{ asset('images/ajax-loader.gif') }}" />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exampleFormControlTextarea1"
                                                        class="form-label">{{ __('Your Comment') }} *
                                                    </label>
                                                    <textarea class="form-control @error('comment') is-invalid  @enderror" id="exampleFormControlTextarea1"
                                                        wire:model="comment" 313 rows="6"></textarea>
                                                    @error('comment')
                                                        <span class=" text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exampleFormControlInputName"
                                                        class="form-label">{{ __('Name') }} *
                                                    </label>
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid  @enderror"
                                                        wire:model="name" id="exampleFormControlInputName"
                                                        placeholder="">
                                                    @error('name')
                                                        <span class=" text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exampleFormControlInputEmail"
                                                        class="form-label">{{ __('Email') }} *</label>
                                                    <input type="email"
                                                        class="form-control @error('email') is-invalid  @enderror"
                                                        wire:model="email" id="exampleFormControlInputEmail"
                                                        placeholder="name@example.com">
                                                    @error('email')
                                                        <span class=" text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <button class="btn btn-primary" id="adShowCommentSave"
                                                        wire:click.prevent="storeComment">{{ __('Submit') }}
                                                    </button>
                                                </div>
                                            </form>
                                        @else
                                            <p class="fs-6"><i class="fa fa-comment text-secondary"></i> {!! __('messages.comment_login_message', ['url' => route($lang . 'front.login-register')]) !!}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
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
                <!--  -->
                <div class="col-12 col-md-4">
                    <aside>
                        <div class="mb-5">
                            <div class="box d-none d-md-block mt-0">
                                <div class="row contact-box d-flex justify-content-between">
                                    <button type="button" wire:click="showContactInfo"
                                        class="btn btn-primary info-btn col-9 col-md-5 col-sm-12 pull-right contact_info">{{ __('Contact Info') }}
                                    </button>
                                    @if($ad->user_id == auth()->id())
                                        <a href="{{ route($lang . 'front.panel.user.ad.edit', $ad->id) }}" class="btn btn-secondary col-md-4">{{ __('Edit') }}</a>
                                    @endif
                                    @if ($local)
                                        <script !src="">
                                            document.cookie = 'favorites=@json($favorits); expires=Thu, 18 Dec 2045 12:00:00 UTC; path=/';
                                        </script>
                                    @endif
                                    <button data-toggle="tooltip" data-placement="top" title=""
                                        wire:click="favorite" type="button" onclick=""
                                        class="btn info-btn btn-primary btn-icon btn-framed col-md-6 col-sm-12 pull-right">
                                        <i
                                            class="@if ($isFavorite) fas @else fal @endif fa-bookmark"></i>
                                    </button>
                                </div>
                                <ul class="p-0 info-contact">
                                    <li class="border-bottom d-flex justify-content-between p-2">
                                        <span>{{ __('Category') }}</span>
                                        @foreach ($ad->categories as $category)
                                            <span><a
                                                    href="{{ route('front.ad.category.index.first.page', ['slug' => $category->slug]) }}">{{ $category->locale_name }}</a></span>
                                        @endforeach
                                    </li>
                                    <li class="border-bottom d-flex justify-content-between p-2">
                                        <span>{{ __('City') }}/{{ __('District') }}</span>
                                        <span>
                                            @if ($ad?->city)
                                                <a
                                                    href="{{ route('front.ad.category.city.index.first.page', ['slug' => $ad?->city->slug]) }}">{{ $ad?->city->name }}</a>
                                            @endif
                                        </span>
                                    </li>
                                    <li class="border-bottom d-flex justify-content-between p-2">
                                        <span>{{ __('Published Date') }}</span>
                                        <span>{{ \Carbon\Carbon::parse($ad['created_at'])->setTimezone('America/Toronto')->diffForHumans() }}</span>
                                    </li>
                                    @foreach ($ad->attrs as $attribute)
                                        @if ($attribute->is_visible_on_front)
                                            @switch($attribute?->type)
                                                @case('Text')
                                                @case('Select')
                                                    <li class="border-bottom d-flex justify-content-between p-2">
                                                        <span>{{ $attribute->name }}</span><span>{{ $attribute->pivot->text }}</span>
                                                    </li>
                                                @break
                                            @endswitch
                                        @endif
                                    @endforeach
                                    <li class="d-flex justify-content-between pt-2 p-2">
                                        <span>{{ __('Price') }}</span>
                                        <span>
                                            <span>
                                                @if ($ad->price)
                                                    <span class="arial-font">${{ $ad->price }}</span>
                                                @elseif($ad->is_visible_phone)
                                                    <a href="tel:{{ $ad->phone }}"
                                                        class="text-success">{{ __('Call') }}</a>
                                                @elseif($ad->is_visible_email)
                                                    <a href="mailto:{{ $ad->email }}"
                                                        class="text-success">{{ __('Call') }}</a>
                                                @else
                                                    {{ __("The user's contact information is not available") }}
                                                @endif
                                            </span>
                                        </span>
                                    </li>
                                    {{-- <li class="border-top d-flex justify-content-between pt-2 p-2">
                                        <span>{{ __('Website') }}</span>
                                        <a href="#" wire:click="trackLinkClick('{{ $ad->website ?? $ad->slug }}')">{{ $ad->title }}</a>
                                    </li> --}}
                                    @auth
                                        <li class="border-top d-flex justify-content-between pt-2 p-2">
                                            <span>{{ __('Used Service/Contract/Purchase Proof') }}</span>
                                            <a
                                                href="{{ route($lang . 'front.panel.user.service-usage.index', ['ad_slug' => $ad->slug]) }}">
                                                {{ __('Send') }}
                                            </a>
                                        </li>
                                    @endauth
                                </ul>
                                {{-- <div class="warning_ad">
                                    {{ __('Address, phone number and website address of Iranian jobs and businesses in Canada') }}
                                </div> --}}
                                <section class="report_ad mt-3 d-flex justify-content-between">
                                    @if ($ad->user)
                                        <a href="{{ route('front.chat.message', ['id' => $ad->user->id]) }}"
                                            class="btn btn-sm btn-primary py-2">
                                            <i class="fa fa-comment-alt-dots mx-1"></i>
                                            {{ __('Message and Live Chat') }}
                                        </a>
                                    @endif
                                    <a href="#" wire:click.prevent="report" class="align-self-center"><i
                                            class="fa fa-flag"></i>
                                        {{ __('Report Problem') }}</a>
                                </section>
                            </div>
                            {{-- <section class="box  mb-5 mt-4">
                                <img width="69" height="115"
                                    src="../images/4611.png" alt="" style="max-width: 100%; height: auto;">
                            </section> --}}
                            <section>
                                <div class="share">
                                    <span class="post-link__button" sss="{{ $ad->short_link }}" id="linkPost"><i
                                            class="fa fa-files-o" aria-hidden="true"></i>
                                        {{ __('Share Link') }}</span>
                                    <input type="text" id="shortlink" value="{{ $ad->short_link }}">
                                </div>
                            </section>
                            <div class="crunchify-social">
                                <span>
                                    <i class="fa fa-share-alt"></i> {{ __('Share') }} </span>
                                <a href="https://telegram.me/share/url?text=&url={{ route('front.ad.show', $ad->slug) }}"
                                    class="crunchify-link crunchify-telegram mt-2"><i
                                        class="fab fa-telegram-plane"></i></a>
                                <a class="crunchify-link crunchify-facebook mt-2"
                                    href="https://www.facebook.com/sharer/sharer.php?u={{ route('front.ad.show', $ad->slug) }}"
                                    target="_blank"><i class="fab fa-facebook-f"></i></a>
                                <a class="crunchify-link crunchify-whatsapp mt-2"
                                    href="whatsapp://send?text={{ $ad->title }} {{ route('front.ad.show', $ad->slug) }}"
                                    target="_blank"><i class="fab fa-whatsapp"></i></a>
                                <a class="crunchify-link crunchify-twitter mt-2"
                                    href="https://twitter.com/intent/tweet?text={{ $ad->title }}&url={{ route('front.ad.show', $ad->slug) }}&via=Crunchify"
                                    target="_blank"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                        @if ($ad->realEstateDetail)
                            <div class="mb-5">
                                <div class="box d-none d-md-block mt-0">
                                    <div class="row contact-box d-flex justify-content-center">
                                        <h5>{{ __('The Property Details') }}</h5>
                                    </div>
                                    <ul class="p-0 info-contact">
                                        <li class="border-bottom d-flex justify-content-between p-2">
                                            <span>{{ __('Area') }}</span>
                                            <span dir="ltr">{{ $ad->realEstateDetail->area }}
                                                {{ __('messages.area_unit_short.' . $ad->realEstateDetail->area_unit) }}</span>
                                        </li>
                                        <li class="border-bottom d-flex justify-content-between p-2">
                                            <span>{{ __('Rooms') }}</span>
                                            <span>
                                                {{ $ad->realEstateDetail->rooms }}
                                            </span>
                                        </li>
                                        <li class="border-bottom d-flex justify-content-between p-2">
                                            <span>{{ __('Bathrooms') }}</span>
                                            <span>{{ $ad->realEstateDetail->bathroom }}</span>
                                        </li>
                                        <li class="border-bottom d-flex justify-content-between p-2">
                                            <span>{{ __('Floor') }}</span>
                                            <span>{{ $ad->realEstateDetail->floor }}</span>
                                        </li>
                                        <li class="border-bottom d-flex justify-content-between p-2">
                                            <span>{{ __('Construction Year') }}</span>
                                            <span>{{ $ad->realEstateDetail->construction_year }}</span>
                                        </li>
                                        <li class="border-bottom d-flex justify-content-between p-2">
                                            <span>{{ __('Availability Date') }}</span>
                                            <span>{{ $ad->realEstateDetail->availability_date?->format('Y-m-d') }}</span>
                                        </li>
                                        @if ($ad->mainCategory->first()?->sale_type === 'rent')
                                            <li class="border-bottom d-flex justify-content-between p-2">
                                                <span>{{ __('Mortgage Price') }}</span>
                                                <span>${{ $ad->realEstateDetail->mortgage_price }}</span>
                                            </li>
                                            <li class="border-bottom d-flex justify-content-between p-2">
                                                <span>{{ __('Rent Price') }}</span>
                                                <span>${{ $ad->realEstateDetail->rent_price }}</span>
                                            </li>
                                        @else
                                            <li class="border-bottom d-flex justify-content-between p-2">
                                                <span>{{ __('Sale Price') }}</span>
                                                <span>${{ $ad->realEstateDetail->sale_price }}</span>
                                            </li>
                                            <li class="border-bottom d-flex justify-content-between p-2">
                                                <span>{{ __('Yearly Tax') }}</span>
                                                <span>${{ $ad->realEstateDetail->yearly_tax }}</span>
                                            </li>
                                            <li class="border-bottom d-flex justify-content-between p-2">
                                                <span>{{ __('Keeping Price') }}</span>
                                                <span>${{ $ad->realEstateDetail->price_keep }}</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        @endif
                        @if ($ad->facilities?->count())
                            <div class="mb-5">
                                <div class="box d-none d-md-block mt-0">
                                    <div class="row contact-box d-flex justify-content-center">
                                        <h5>{{ __('The Property Facilities') }}</h5>
                                    </div>
                                    <ul class="p-0 info-contact">
                                        @foreach ($ad->facilities->groupBy('type') as $type => $facilities)
                                            <h6 class="mb-t">{{ __('messages.facilities.' . $type) }}</h6>
                                            @foreach ($facilities->chunk(2) as $chunk)
                                                <li
                                                    class="{{ $loop->last ? '' : 'border-bottom' }} d-flex justify-content-between p-2">
                                                    @foreach ($chunk as $facility)
                                                        <span><i class="fa fa-check"></i>
                                                            {{ $facility->locale_name }}</span>
                                                    @endforeach
                                                </li>
                                            @endforeach
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div class="box d-none d-md-block mt-0">
                            <div class="border-bottom pt-3">
                                <ul class="d-flex justify-content-around px-1 border-bottom-0 nav nav-tabs"
                                    id="blog_posts_sidebar">
                                    <li class="border-bottom-0 nav-item">
                                        <a class="nav-link p-2 fs-6 active" data-bs-toggle="tab" aria-current="true"
                                            href="#top_viewed">{{ __('Top Viewed') }}</a>
                                    </li>
                                    <li class="border-bottom-0 nav-item">
                                        <a class="nav-link p-2 fs-6" data-bs-toggle="tab"
                                            href="#top_rated">{{ __('Top Rated') }}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="top_viewed">
                                    <div class="card-body">
                                        <ul class="pe-2 ps-2 list-style-type blue-list-style">
                                            @foreach ($sidebar['top_viewed_blogs'] as $blog)
                                                <li>
                                                    <a href="{{ $blog->link }}">{{ $blog->locale_title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane" id="top_rated">
                                    <div class="card-body">
                                        <ul class="pe-2 ps-2 list-style-type blue-list-style">
                                            @foreach ($sidebar['latest_blog'] as $blog)
                                                <li>
                                                    <a href="{{ $blog->link }}">{{ $blog->locale_title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
    {{-- @includeWhen(count($adsUser),'livewire.front.ad.layouts.ad-slider',['ads'=>$adsUser,'title'=>'سایر آگهی‌های این کاربر','id'=>1])@includeWhen(count($adsSimilar),'livewire.front.ad.layouts.ad-slider',['ads'=>$adsSimilar,'title'=>'آگهی‌های مشابه','id'=>2]) --}}
</div>
{{-- @php
 $adsUser=App\Models\Ad\Ad::with([
                   'state',
                      'city',
                   'media' => function ($q) {
                    $q->whereCollectionName('SpecialImage');
                   },
                   'mainCategory',
                   'favorites' => function ($q) {
                    if (auth()->check()) {
                     $q->whereUserId(auth()->id());
                    }
                   }
                  ])->whereUserId($ad->user_id)->inRandomOrder()->whereNotIn('id',[$ad->id])->limit(12)->get();

$adsUserIds=$adsUser->pluck('id');



 $adsSimilar=App\Models\Ad\Ad::with([
                   'state',
                   'city',

                   'media' => function ($q) {
                    $q->whereCollectionName('SpecialImage');
                   },
                   'mainCategory',
                   'favorites' => function ($q) {
                    if (auth()->check()) {
                     $q->whereUserId(auth()->id());
                    }
                   }
                  ])->whereHas('categories',function ($q) use($ad){
 $q->whereIn('ad_categories.id',$ad->categories->pluck('id'));
 })
->orWhere('city_id',$ad->city_id)
->orWhere('state_id',$ad->state_id)
->inRandomOrder()->whereNotIn('id',[$ad->id,...$adsUserIds])->limit(12)->get();


@endphp --}}{{-- <section class="blog-block m-0 p-4 p-md-0">
 <div class="container pb-5 mb-5">
  <div class="border-bottom mb-5">
   <h4 class="heading-border d-inline-block">توضیحات آگهی</h4>
  </div>
  <!--owl-carousel اضاصه کردن کروزل جدید با  -->
  <!-- حذق کروزل با بوت سترپ -->
  <div class="col-12 cards ads-card-title-blue">
   <div class="owl-carousel">
    @foreach ($adsSimilar as $ad)
     <livewire:front.ad.card :ad="$ad"/>
    @endforeach
   </div>
  </div>
 </div>
</section> --}}
@push('scripts')
    <script src="{{ asset('js/splide/splide.min.js')}}"></script>
    @if ($ad->mainCategory->first()?->type === 'real_estate')
        @if($ad->getMedia('Gallery')->count() || $ad->getFirstMediaUrl('SpecialImage'))
            <script>
                var main = new Splide('#main-carousel', {
                    type: 'fade',
                    fixedHeight: 500,
                    rewind: true,
                    pagination: false,
                    arrows: false,
                    breakpoints: {
                        600: {
                            fixedHeight: 300,
                        },
                    },
                });


                var thumbnails = new Splide('#thumbnail-carousel', {
                    fixedWidth: 100,
                    fixedHeight: 60,
                    gap: 10,
                    rewind: true,
                    pagination: false,
                    isNavigation: true,
                    breakpoints: {
                        600: {
                            fixedWidth: 60,
                            fixedHeight: 44,
                        },
                    },
                });


                main.sync(thumbnails);
                main.mount();
                thumbnails.mount();
            </script>
        @endif
    @endif
    @if (session('message'))
        <script>

            // var mainRelated = new Splide('#related_posts_main', {
            //     type: 'loop',
            //     perPage: 2,
            //     perMove: 1,
            //     fixedHeight: 200,
            //     autoplay: true,
            //     trimSpace: 'move',
            //     arrows: false,
            //     // focus: 2,
            //     cloneStatus: false,
            //     keyboard: true,
            //     pagination: false,
            //     gap: '1em',
            //     breakpoints: {
            //         640: {
            //             type: 'slide',
            //             rewindByDrag: true,
            //             focus: 'center',
            //             trimSpace: false,
            //             perPage: 1,
            //             keyboard: false,
            //             rewind: true,
            //             pagination: false,
            //             arrows: false,
            //         },
            //     }
            // });
            // mainRelated.mount();


            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: "{{ session('message') }}",
                    showConfirmButton: false,
                    timer: 1500
                })
            });
        </script>
    @endif
@endpush
