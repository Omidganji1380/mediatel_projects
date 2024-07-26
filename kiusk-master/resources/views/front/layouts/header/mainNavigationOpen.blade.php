<div class="main-navigation open_navigation ">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light border-0 header_line">
            @include('front.layouts.header.menu')
        </nav>
        @switch(request()->route()->getName())
            @case('front.home')
                @if (request()->query('s') || request()->query('city_categories') || request()->query('category'))
                    <p class="d-flex justify-content-between col-12  container">
                        <span>
                            <a href="{{ route('front.home') }}">{{ __('Home') }}</a> /
                            <a href="{{ route('front.ad.index.first.page') }}"> {{ __('Ads') }}</a>
                            / {{ __('Search result for') }} “{{ request()->s }}”
                        </span>
                    </p>
                @endif
            @break
            @case('en.front.home')
                @if (request()->query('s') || request()->query('city_categories') || request()->query('category'))
                    <p class="d-flex justify-content-between col-12  container">
                        <span>
                            <a href="{{ route('front.home') }}">{{ __('Home') }}</a> /
                            <a href="{{ route('front.ad.index.first.page') }}"> {{ __('Ads') }}</a>
                            / {{ __('Search result for') }} “{{ request()->s }}”
                        </span>
                    </p>
                @endif
            @break

        @endswitch
    </div>
    <div class="page-title">
        <div class="container">
            <div class="text-center website_header_slogan">
                {!! s()->headerText !!}
                {{-- <img src="{{ asset('images/label.png') }}" alt="kiusk-nowruz" class="w-50"> --}}
            </div>
        </div>
    </div>
    @livewire('front.ad.search', ['isOpen' => true])
    <div class="d-none d-lg-block" {{-- style="font-size: 0.01px" --}}>.</div>
    <div class="background" style=";z-index: -10">
        <div class="background-image original-size"
            style="background-image: url({{ asset('images/hero-background-icons (1).jpg') }});">
            <img src="{{ asset('storage/' . s()->headerBackgroundImage) }}" alt="{{ s()->headerText }}">
        </div>
    </div>
</div>
