@php
    $margin = App::isLocale('fa') ? "me-3 me-md-0" : "";
    $marginEn = App::isLocale('en') ? "mx-3 mx-md-0" : "";
    $marginEnFav = App::isLocale('en') ? "mx-3 mx-md-0" : "me-3 me-md-0";
    $lang = App::isLocale('fa') ? "" : "en.";
    $unreadMessageCount = \App\Models\ChMessage::where('to_id', Auth::id())->where('seen', false)->count();
@endphp
<div class="bg-dark">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-dark p-0">
            <div class="container-fluid">
                {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class=""><i class="fas fa-bars text-white"></i></span>
                </button> --}}
                {{-- <div class="collapse navbar-collapse" id="navbarNavDropdown"> --}}
                <div class="w-100" id="navbarNavDropdown">
                    <ul class="d-flex flex-row justify-content-evenly navbar-nav pb-1 pt-1 w-100">
                        <li class="nav-item position-static">
                            @auth
                                <a class="nav-link text-white font {{ $margin }}">
                                    <i class="fa fa-user text-secondary"></i> {{ __('Welcome') }} {{ auth()->user()->name }} </a>
                                <ul class="inner-ul p-0 profile text-start" style="width:200px">
                                    <li class="nav-item"><a href="{{ route($lang . 'front.panel.user.dashboard.index') }}"><i
                                                class="fas fa-chart-pie m-1"></i>{{ __('Dashboard') }}</a></li>
                                    <li class="nav-item"><a href="{{ route($lang . 'front.panel.user.ad.index') }}"><i
                                                class="fas fa-bullhorn m-1"></i>{{ __('My Ads') }}</a></li>
                                    <li class="nav-item"><a href="{{ route($lang . 'front.panel.user.favorite.index') }}"><i
                                                class="fa fa-bookmark m-1"></i>{{ __('Favorites') }}</a></li>
                                    <li class="nav-item"><a href="{{ route($lang .'front.panel.user.ad-orders.index') }}"><i
                                                class="fa fa-calendar-star m-1"></i>{{ __('My Advertisements') }}</a></li>
                                    {{-- <li class="nav-item"><a href="{{ route($lang . 'front.panel.user.plans.index') }}"><i
                                                class="fa fa-calendar-star m-1"></i>{{ __('Plans') }}</a></li> --}}
                                    <li class="nav-item">
                                        <a href="{{ route($lang . 'front.panel.user.payment.index') }}"><i
                                                class="far fa-credit-card m-1"></i>{{ __('Payments') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route($lang . 'front.panel.user.tickets.index') }}"><i
                                                class="far fa-ticket-alt m-1"></i>{{ __('Tickets') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route($lang . 'front.chat') }}"><i
                                                class="far fa-comment-alt m-1"></i>{{ __('messages.messages') }}
                                            @if ($unreadMessageCount)
                                                <span class="ms-2 badge bg-info">{{ $unreadMessageCount }}</span>
                                            @endif
                                        </a>
                                    </li>
                                    <li class="nav-item active-link"><a href="{{ route($lang . 'front.panel.user.upgrade.index') }}" class="font-weight-bold text-black"><i
                                                class="fa fa-arrow-alt-from-bottom m-1"></i>{{ __('Upgrade Level') }}</a></li>
                                    <li class="nav-item"><a href="{{ route($lang . 'front.panel.user.profile.edit') }}"><i
                                                class="fa fa-edit m-1"></i>{{ __('My Account') }}</a></li>
                                    <li class="nav-item"><a href="{{ route($lang . 'front.panel.user.profile.show') }}"><i
                                                class="fa fa-user m-1"></i>{{ __('Profile') }}</a></li>
                                    <li class="nav-item"><a href="{{ route($lang . 'front.panel.user.scores.index') }}"><i
                                                class="fa fa-star m-1"></i>{{ __('Scores') }}</a></li>
                                    @livewire('front.auth.logout')
                                </ul>
                            @endauth
                            @guest
                                <a href="{{ route($lang . 'front.panel.user.ad.index') }}" class="nav-link active text-white font {{ $margin }}">
                                    <i class="fa fa-sign-in text-secondary"></i> {{ __('Login') }} / {{ __('Register') }} </a>
                            @endguest
                        </li>
                        @foreach (s()->headerBlackMenu as $item)
                            <li class="nav-item">
                                <a href="{{ $item['url'] }}" class="nav-link text-white font {{ $marginEnFav }}">
                                    <i class="{!! $item['icon'] !!} text-secondary"></i> {!! $item['text'] !!} </a>
                            </li>
                        @endforeach
                        <li class="nav-item flex-grow-1">
                            <a href="{{ route($lang . 'front.advertisement.index') }}">
                                <button class="btn btn-sm btn-warning blink_me my-0 py-0 px-2 font-weight-bold fs-small">Ad</button>
                            </a>
                        </li>
                        <li class="nav-item d-flex">
                            <div class="d-flex align-self-center">
                                <div class="nav-item {{ $margin }}">
                                    <a class="nav-link fs-small text-white py-0" href="{{ route('set.locale', [
                                            'lang' => 'fa',
                                            'current_url' => url()->current(),
                                            'current_lang' => app()->getLocale(),
                                        ]) }}">
                                        <span class="fi fi-ir"></span>
                                    </a>
                                </div>
                                <div class="nav-item {{ $marginEn }}">
                                    <a class="nav-link fs-small text-white py-0" href="{{ route('set.locale', [
                                            'lang' => 'en',
                                            'current_url' => url()->current(),
                                            'current_lang' => app()->getLocale(),
                                        ]) }}">
                                        <span class="fi fi-ca"></span>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div><!-- main navigation -->
