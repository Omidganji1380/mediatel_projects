@extends('front.pages.panel.user.base')

@section('user_panel_content')
    <section class=" blog-block m-0">
        <div class="container p-4">
            <section class="row justify-content-between">
                <div class="col-12 col-md-5">
                    <div class="shadow">
                        <div class="top-nav-head">
                            @php
                                $lang = App::isLocale('fa') ? "" : "en.";
                            @endphp
                            <div class="flip-card" id="card">
                                <div class="front d-flex justify-content-center align-items-center">
                                    <img class="d-flex justify-content-center align-items-center"
                                        src="{{ $user?->getFirstMedia('profile')?->getUrl('avatar') }}"
                                        alt="{{ $user->name }}">
                                </div>
                                <div class="back flip-card-back d-flex justify-content-center align-items-center"
                                    style="height: 20vh; width: 100%">
                                    <span
                                        class="text-black d-flex justify-content-center align-items-center">{{ __('Points') }}:
                                        <p class="fw-bold mb-0">{{ $user->scores_sum_score ?? 0 }}</p></span>
                                </div>
                            </div>

                            <h3>{{ Str::mask($user->phone, '*', 3, 4) }}</h3>
                        </div>

                        <ul class="profile mt-3">
                            <li><strong><i class="fa fa-user" aria-hidden="true"></i> {{ __('User Role') }}: </strong>
                                <div class="d-flex">
                                    <p class="me-4">{{ __('messages.roles.' . $user->getRoleNames()->first()) }}</p>
                                    @if($user->getRoleNames()->first() !== 'vip')
                                        <a href="{{ route($lang . 'front.panel.user.upgrade.index') }}"
                                            class="bg-light blink_me font-weight-bold text-success">
                                            {{ __('Upgrade Level') }} <i class="fa fa-arrow-alt-from-bottom"></i>
                                        </a>
                                    @endif
                                </div>
                            </li>
                            <li><strong><i class="fa fa-phone" aria-hidden="true"></i> {{ __('Phone Number') }}: </strong>
                                <p><a href="tel:{{ $user->phone }}">{{ $user->phone }}</a></p>
                            </li>
                            <li><strong><i class="fa fa-envelope-open" aria-hidden="true"></i> {{ __('Email') }}:
                                </strong>
                                <p><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/flip-master/dist/jquery.flip.min.js') }}"></script>

    <script>
        let mode = 'hover';

        if (parseInt($(window).width()) < 600) {
            mode = 'click';
        }

        $("#card").flip({
            axis: 'x',
            trigger: mode,
            speed: 250
        });

        $('.flip-card-back').removeClass('d-none');
    </script>
@endpush
