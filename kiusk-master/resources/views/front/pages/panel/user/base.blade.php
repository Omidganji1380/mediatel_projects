@extends('front.base')

@php
    $chevronSide = App::isLocale('fa') ? "left" : "right";
    $lang = App::isLocale('fa') ? "" : "en.";
    $unreadMessageCount = \App\Models\ChMessage::where('to_id', Auth::id())->where('seen', false)->count();
@endphp

@section('content')
    <section class=" blog-block m-0 p-4">
        <div class="container border-0 border-bottom p-0 p-md-3">
            {{--   <p>بازدیدها: 719</p> --}}
            <section class="row justify-content-between">
                <div class="col-12 col-md-3 d-none d-md-block">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <a href="{{ route($lang .'front.panel.user.dashboard.index') }}"
                                class="{{ !request()->routeIs($lang .'front.panel.user.dashboard.index') ?: 'active-link' }}">
                                <i class="fas fa-chart-pie m-2"></i>{{ __('Dashboard') }}
                                @if (request()->routeIs($lang .'front.panel.user.dashboard.index'))
                                    <i class="far fa-chevron-{{ $chevronSide }}"></i>
                                @endif
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route($lang .'front.panel.user.ad.index') }}"
                                class="{{ !request()->routeIs($lang .'front.panel.user.ad.index') ?: 'active-link' }}">
                                <i class="fas fa-bullhorn m-2"></i>{{ __('My Ads') }}
                                @if (request()->routeIs($lang .'front.panel.user.ad.index'))
                                    <i class="far fa-chevron-{{ $chevronSide }}"></i>
                                @endif
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route($lang .'front.panel.user.favorite.index') }}"
                                class="{{ !request()->routeIs($lang .'front.panel.user.favorite.index') ?: 'active-link' }}"><i
                                    class="fa fa-bookmark m-2"></i>{{ __('Favorites') }}
                                @if (request()->routeIs($lang .'front.panel.user.favorite.index'))
                                    <i class="far fa-chevron-{{ $chevronSide }}"></i>
                                @endif
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route($lang .'front.panel.user.ad-orders.index') }}"
                                class="{{ !request()->routeIs($lang .'front.panel.user.ad-orders.*') ?: 'active-link' }}"><i
                                    class="far fa-calendar-star m-2"></i> {{ __('My Advertisements') }}
                                @if (request()->routeIs($lang .'front.panel.user.ad-orders.*'))
                                    <i class="far fa-chevron-{{ $chevronSide }}"></i>
                                @endif
                            </a>
                        </li>
                        {{-- <li class="list-group-item">
                            <a href="{{ route($lang .'front.panel.user.plans.index') }}"
                                class="{{ !request()->routeIs($lang .'front.panel.user.plans.index') ?: 'active-link' }}"><i
                                    class="far fa-calendar-star m-2"></i> {{ __('Plans') }}
                                @if (request()->routeIs($lang .'front.panel.user.plans.index'))
                                    <i class="far fa-chevron-{{ $chevronSide }}"></i>
                                @endif
                            </a>
                        </li> --}}
                        <li class="list-group-item">
                            <a href="{{ route($lang .'front.panel.user.payment.index') }}"
                                class="{{ !request()->routeIs($lang .'front.panel.user.payment.index') ?: 'active-link' }}"><i
                                    class="far fa-credit-card m-2"></i>{{ __('My Payments') }}
                                @if (request()->routeIs($lang .'front.panel.user.payment.index'))
                                    <i class="far fa-chevron-{{ $chevronSide }}"></i>
                                @endif
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route($lang .'front.panel.user.tickets.index') }}"
                                class="{{ !request()->routeIs($lang .'front.panel.user.tickets.index') ?: 'active-link' }}"><i
                                    class="far fa-ticket-alt m-2"></i>{{ __('Tickets') }}
                                @if (request()->routeIs($lang .'front.panel.user.tickets.*'))
                                    <i class="far fa-chevron-{{ $chevronSide }}"></i>
                                @endif
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route($lang .'front.chat') }}"
                                class="{{ !request()->routeIs($lang .'front.chat') ?: 'active-link' }}"><i
                                    class="far fa-comment-alt m-2"></i>{{ __('messages.messages') }}
                                    @if ($unreadMessageCount)
                                        <span class="ms-2 badge bg-info">{{ $unreadMessageCount }}</span>
                                    @endif
                                @if (request()->routeIs($lang .'front.chat.*'))
                                    <i class="far fa-chevron-{{ $chevronSide }}"></i>
                                @endif
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route($lang .'front.panel.user.profile.edit') }}"
                                class="{{ !request()->routeIs($lang .'front.panel.user.profile.edit') ?: 'active-link' }}"><i
                                    class="fas fa-edit m-2"></i>{{ __('My Account') }}
                                @if (request()->routeIs($lang .'front.panel.user.profile.edit'))
                                    <i class="far fa-chevron-{{ $chevronSide }}"></i>
                                @endif
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route($lang .'front.panel.user.profile.show') }}"
                                class="{{ !request()->routeIs($lang .'front.panel.user.profile.show') ?: 'active-link' }}"><i
                                    class="fas fa-user m-2"></i>{{ __('Profile') }}
                                @if (request()->routeIs($lang .'front.panel.user.profile.show'))
                                    <i class="far fa-chevron-{{ $chevronSide }}"></i>
                                @endif
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route($lang .'front.panel.user.upgrade.index') }}"
                                class="font-weight-bold text-primary {{ !request()->routeIs($lang .'front.panel.user.upgrade.index') ?: 'active-link' }}"><i
                                    class="fas fa-arrow-alt-from-bottom m-2"></i>{{ __('Upgrade Level') }}
                                @if (request()->routeIs($lang .'front.panel.user.upgrade.index'))
                                    <i class="far fa-chevron-{{ $chevronSide }}"></i>
                                @endif
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route($lang .'front.panel.user.scores.index') }}"
                                class="{{ !request()->routeIs($lang .'front.panel.user.scores.index') ?: 'active-link' }}"><i
                                    class="fas fa-star m-2"></i>{{ __('Scores') }}
                                @if (request()->routeIs($lang .'front.panel.user.scores.index'))
                                    <i class="far fa-chevron-{{ $chevronSide }}"></i>
                                @endif
                            </a>
                        </li>
                        {{-- <li class="list-group-item">
                            <a href="{{ route($lang .'front.panel.user.videos.index') }}"
                                class="{{ !request()->routeIs($lang .'front.panel.user.videos.index') ?: 'active-link' }}"><i
                                    class="fas fa-video m-2"></i>{{ __('Videos') }}
                                @if (request()->routeIs($lang .'front.panel.user.videos.index'))
                                    <i class="far fa-chevron-{{ $chevronSide }}"></i>
                                @endif
                            </a>
                        </li> --}}
                        @livewire('front.panel.user.panel-logout')
                        {{--      <li class="list-group-item"><i class="fa fa-bookmark m-2"></i>علاقه‌مندی ها</li> --}}
                        {{--      <li class="list-group-item"><i class="far fa-credit-card m-2"></i>پرداخت‌های --}}
                        {{--       من<i class="far fa-chevron-{{ $chevronSide }}"></i></li> --}}
                        {{--      <li class="list-group-item"><i class="fas fa-edit m-2"></i>اطلاعات کاربری</li> --}}
                        {{--      <li class="list-group-item"><i class="fa fa-sign-in m-2"></i> خروج</li> --}}
                    </ul>
                </div>
                <div class="col-12 col-md-9 ps-md-5">
                    @yield('user_panel_content')
                </div>
            </section>
        </div>
    </section>
@endsection
