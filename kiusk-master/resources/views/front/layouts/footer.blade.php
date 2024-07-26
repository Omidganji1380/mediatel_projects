@php
    $lang = App::isLocale('fa') ? "" : "en.";
@endphp
<div class="container">
    <div class="row">
        <div class="col-md-5">
            <div class="brand-sec d-flex">
                <a href="" class="brand mx-2 w-100">
                    {{--     <img src="{{asset('images/4611.png')}}" --}}
                    <img class="w-100" src="{{ asset(App::isLocale('fa') ? 'images/kiusk logo-fa.png' : 'images/kiusk logo-en.png') }}"
                    {{-- <img src="{{ asset('storage/' . s()->logo) }}" --}}
                        alt="کیوسک | نیازمندی های ایرانیان کانادا | آگهی رایگان نیازمندی ها">
                </a>
                {!! s()->footerDescription !!}
            </div>
        </div>
        <!--end col-md-5-->
        <div class="col-md-3">
            <h2>{{ s()->footerTitleMenu }}</h2>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <nav>
                        <div class="">
                            <ul id="" class="list-unstyled">
                                @foreach (s()->footerMenuUrls as $item)
                                    <li id="menu-item-52"
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-52">
                                        <a href="{{ $item['url'] }}">
                                            {!! $item['text'] !!}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <!--end col-md-3-->
        <div class="col-md-4">
            <h2>{{ s()->footerTitleContactUs }}</h2>
            <address>
                @foreach (s()->footerListContactUs as $item)
                    <p>
                        <a href="{!! $item['addressValue'] !!}"
                            class="text-decoration-none">
                            <strong>
                                <i class="{{ $item['addressIcon'] }}" aria-hidden="true"></i> {!! $item['addressName'] !!}
                            </strong>
                            @if(\Str::contains($item['addressValue'], 'mailto:'))
                                {!! str_replace("mailto:", "", $item['addressValue']) !!}
                            @endif
                        </a>
                    </p>
                @endforeach
            </address>
            <div class="row app_download"></div>
        </div>
        <!--end col-md-4-->
    </div>
    <div class="row cp-footer">
        <div class="text-center copyright">
            {!! s()->copyright !!}
        </div>
        <div class="text-center copyright">
            <a href="{{ route($lang .'front.rules') }}">Terms and Conditions</a>
        </div>
    </div>
</div>
<div class="background">
    <div class="background-image original-size"
        style="background-image: url({{ asset('storage/' . s()->footerBackgroundImage) }});">
        <img src="{{ asset('storage/' . s()->footerBackgroundImage) }}" alt="{{ s()->headerText }}">
    </div>
    <!--end background-image-->
</div>
