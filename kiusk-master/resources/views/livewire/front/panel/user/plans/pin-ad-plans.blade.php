<div>
    <div class="section-title clearfix p-3 pt-md-0">
        <h2>{{ __('Plans') }}</h2>
        <button
            class="my-plan-button rounded-pill p-1 ps-2 pe-2 btn btn-ads position-absolute {{ App::isLocale('fa') ? "end-0" : "start-0" }} me-3 me-md-0">
            {{ __('My Plan') }} : {{ Auth::user()->subscription?->plan?->name }}
        </button>
    </div>
    <section class="row">
        @php
            $numbers = range(1, 7); // Create an array with numbers 1 to 7
            shuffle($numbers); // Shuffle the array randomly
        @endphp
        @foreach ($plans as $plan)
            <div class="col-md-6 gx-0 gx-md-5 d-flex align-items-stretch mb-4 plans">
                @php
                    $shifted = array_shift($numbers);
                    if (empty($numbers)) {
                        $numbers = range(1, 7); // Reset the array when it becomes empty
                        shuffle($numbers); // Reshuffle the array
                    }
                @endphp
                <div class="card br-x-25 w-100 {{ $plan->best_offer ? "card-active shadow best-offer border" : "" }}"
                    style="
                        background-image: url({{ asset('img/0'. $shifted . '.png') }});
                        background-size: cover; /* The image will cover the entire div */
                        background-repeat: no-repeat; /* Prevent the image from repeating */
                        background-position: center; /* Center the background image */
                    ">
                    <div class="card-body p-3" style="height: 40em;">
                        <div class="align-items-center card-head d-flex flex-column justify-content-center text-center text-white mb-3 p-3"
                            style="height: 45%;">
                            <h6 class="align-self-center fs-5 text-black w-75 mb-0">{{ $plan->name }}</h6>
                            <h4 class="fs-2 text-black pt-2">${{ $plan->price }}</h4>
                        </div>
                        <ul class="list-group list-group-flush p-2 pt-5 pt-md-3">
                            @if ($plan->vip || $plan->pin_ad)
                                <li
                                    class="list-group-item bg-transparent border-0 mb-2 fs-small text-white {{ $plan->pin_ad ? '' : 'text-danger' }}">
                                    <i class="fa fa-{{ $plan->pin_ad ? 'check' : 'times-circle' }}"></i>
                                    {{ __('Pin your ad in Kiusk telegram channel.') }}
                                </li>
                                <li
                                    class="list-group-item bg-transparent border-0 mb-2 fs-small text-white {{ $plan->pin_ad ? '' : 'text-danger' }}">
                                    <i class="fa fa-{{ $plan->pin_ad ? 'check' : 'times-circle' }}"></i>
                                    {{ __('Pin your ad in Kiusk instagram page.') }}
                                </li>
                                <li
                                    class="list-group-item bg-transparent border-0 mb-2 fs-small text-white {{ $plan->pin_ad ? '' : 'text-danger' }}">
                                    <i class="fa fa-{{ $plan->pin_ad ? 'check' : 'times-circle' }}"></i>
                                    {{ __('Display your ad in Kiusk instagram highlights.') }}
                                </li>
                            @endif
                            @if(!$plan->pin_ad || $plan->vip)
                                <li
                                    class="list-group-item bg-transparent border-0 mb-2 fs-small text-white {{ $plan->show_in_main_page ? '' : 'text-danger' }}">
                                    <i class="fa fa-{{ $plan->show_in_main_page ? 'check' : 'times-circle' }}"></i>
                                    {{ __('Display your ad in main page.') }}
                                </li>
                                <li
                                    class="list-group-item bg-transparent border-0 mb-2 fs-small text-white {{ $plan->show_in_sidebar ? '' : 'text-danger' }}">
                                    <i class="fa fa-{{ $plan->show_in_sidebar ? 'check' : 'times-circle' }}"></i>
                                    {{ __('Display your ad in sidebar in ads.') }}
                                </li>
                                <li
                                    class="list-group-item bg-transparent border-0 mb-2 fs-small text-white {{ $plan->show_in_suggestion ? '' : 'text-danger' }}">
                                    <i class="fa fa-{{ $plan->show_in_suggestion ? 'check' : 'times-circle' }}"></i>
                                    {{ __('Display your ad in suggestion bar in ads.') }}
                                </li>
                                {{-- <li class="list-group-item bg-transparent border-0 mb-2 fs-small text-white"><i class="fa fa-check"></i> {{ __('Send') }} {{ $plan->featured_limit }} {{ __('Special Advertisment') }}</li> --}}
                                @if ($plan->email_notification)
                                    <li class="list-group-item bg-transparent border-0 mb-2 fs-small text-white"><i class="fa fa-check"></i>
                                        {{ __('Notification of ads through promotional email') }}</li>
                                @endif
                                @if ($plan->sms_notification)
                                    <li class="list-group-item bg-transparent border-0 mb-2 fs-small text-white"><i class="fa fa-check"></i>
                                        {{ __('Notification of ads through promotional SMS') }} <span
                                            class="badge bg-danger">{{ __('New') }}</span></li>
                                @endif
                                {{-- <li class="list-group-item bg-transparent border-0 mb-2 fs-small text-white"><i class="fa fa-check"></i> {{ $plan->invoice_period }} {{ \App\Models\Plan::INTERVALS[$plan->invoice_interval] }} {{ __('Expiration') }}</li> --}}
                            @endif
                        </ul>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-center">
                        <button class="btn btn-ads border m-3" wire:click="addToCart('{{ $plan->slug }}')">{{ __('Continue') }}</button>

                        {{-- <form id="cart-form-{{ $plan->slug }}" action="{{ route('fa.carts.store') }}" method="POST" style="display: none">
                            <input type="hidden" name="plan_slug" value="{{ $plan->slug }}">
                            @csrf
                        </form> --}}
                    </div>
                </div>
            </div>
        @endforeach
    </section>
</div>
