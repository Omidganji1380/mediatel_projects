<div class="col-md-6 d-flex align-items-stretch gx-5 mb-4 plans">
    {{-- <img src="{{ $plan->getFirstMediaUrl('BackgroundImage') }}" alt=""> --}}
    <div class="card br-x-25 pt-4 w-100 vip-plan-card {{ $plan->best_offer == 2 ? 'card-active shadow' : '' }}"
        style="
        background-image: url('{!! $plan->getFirstMediaUrl('BackgroundImage')
            ? str_replace('\\', '/', $plan->getFirstMediaUrl('BackgroundImage'))
            : asset('img/0'. rand(1,7) .'.png') !!}');
        background-size: cover; /* The image will cover the entire div */
        background-repeat: no-repeat; /* Prevent the image from repeating */
        background-position: center; /* Center the background image */
        height:44em;
        ">
        <div class="card-body p-3">
            <div class="align-items-center card-head d-flex flex-column justify-content-center text-center text-white mb-5 p-3"
                style="height: 40%;">
                <h3 class="align-self-center fs-5 text-black w-75 mb-0">{{ $plan->name }}</h3>
                <p class="align-self-center fs-5 text-black-50 w-75 mb-0">
                    {{ trans_choice('messages.plans.intervals.' . $plan->invoice_interval, $plan->invoice_period, ['count' => $plan->invoice_period]) }}</p>
                <h4 class="fs-2 text-black pt-2">${{ $plan->price }}</h4>
            </div>
            <ul class="list-group list-group-flush p-2 pt-5 pt-md-0">
                <li
                    class="list-group-item bg-transparent text-white border-0 mb-2 fs-small {{ $plan->show_in_main_page ? '' : 'text-danger' }}">
                    <i class="fa fa-{{ $plan->show_in_main_page ? 'check' : 'times-circle' }}"></i>
                    {{ $plan->vip ? __('messages.plans.vip_show_in_main_page', ['count' => $plan->featured_limit]) : __('messages.plans.show_in_main_page') }}
                </li>
                <li
                    class="list-group-item bg-transparent text-white border-0 mb-2 fs-small {{ $plan->show_in_sidebar ? '' : 'text-danger' }}">
                    <i class="fa fa-{{ $plan->show_in_sidebar ? 'check' : 'times-circle' }}"></i>
                    {{ __('messages.plans.show_in_sidebar') }}
                </li>
                <li
                    class="list-group-item bg-transparent text-white border-0 mb-2 fs-small {{ $plan->show_in_suggestion ? '' : 'text-danger' }}">
                    <i class="fa fa-{{ $plan->show_in_suggestion ? 'check' : 'times-circle' }}"></i>
                    {{ __('messages.plans.show_in_suggestion') }}
                </li>
                @if ($plan->pin_ad)
                    <li
                        class="list-group-item bg-transparent text-white border-0 mb-2 fs-small {{ $plan->pin_ad ? '' : 'text-danger' }}">
                        <i class="fa fa-{{ $plan->pin_ad ? 'check' : 'times-circle' }}"></i>
                        {{ __('messages.plans.pin_ad') }}
                    </li>
                    <li
                        class="list-group-item bg-transparent text-white border-0 mb-2 fs-small {{ $plan->pin_ad ? '' : 'text-danger' }}">
                        <i class="fa fa-{{ $plan->pin_ad ? 'check' : 'times-circle' }}"></i>
                        {{ __('messages.plans.story') }}
                    </li>
                    <li
                        class="list-group-item bg-transparent text-white border-0 mb-2 fs-small {{ $plan->pin_ad ? '' : 'text-danger' }}">
                        <i class="fa fa-{{ $plan->pin_ad ? 'check' : 'times-circle' }}"></i>
                        {{ __('messages.plans.motion_story') }}
                    </li>
                @endif
                @if ($plan->telegram_channel)
                    <li
                        class="list-group-item bg-transparent text-white border-0 mb-2 fs-small {{ $plan->telegram_channel ? '' : 'text-danger' }}">
                        <i class="fa fa-{{ $plan->telegram_channel ? 'check' : 'times-circle' }}"></i>
                        {{ __('messages.plans.telegram_channel') }}
                    </li>
                @endif
                @if ($plan->telegram_bot)
                    <li
                        class="list-group-item bg-transparent text-white border-0 mb-2 fs-small {{ $plan->telegram_bot ? '' : 'text-danger' }}">
                        <i class="fa fa-{{ $plan->telegram_bot ? 'check' : 'times-circle' }}"></i>
                        {{ __('messages.plans.telegram_bot') }}
                    </li>
                @endif
                @if ($plan->free_blog_ad)
                    <li
                        class="list-group-item bg-transparent text-white border-0 mb-2 fs-small {{ $plan->free_blog_ad ? '' : 'text-danger' }}">
                        <i class="fa fa-{{ $plan->free_blog_ad ? 'check' : 'times-circle' }}"></i>
                        {{ __('messages.plans.free_blog_ad') }}
                    </li>
                @endif
                @if ($plan->narration)
                    <li
                        class="list-group-item bg-transparent text-white border-0 mb-2 fs-small {{ $plan->narration ? '' : 'text-danger' }}">
                        <i class="fa fa-{{ $plan->narration ? 'check' : 'times-circle' }}"></i>
                        {!! __('messages.plans.narration') !!}
                    </li>
                @endif
                @if ($plan->email_notification)
                    <li class="list-group-item bg-transparent text-white border-0 mb-2 fs-small"><i
                            class="fa fa-check"></i>
                        {{ __('Notification of ads through promotional email') }}</li>
                @endif
                @if ($plan->sms_notification)
                    <li class="list-group-item bg-transparent text-white border-0 mb-2 fs-small"><i
                            class="fa fa-check"></i>
                        {{ __('Notification of ads through promotional SMS') }} <span
                            class="badge bg-danger">{{ __('New') }}</span></li>
                @endif
            </ul>
        </div>
        <div class="card-footer bg-transparent border-0 text-center">
            <button class="btn btn-{{ $plan->best_offer ? 'secondary' : 'primary' }} m-3"
                wire:click="addToCart('{{ $plan->slug }}')">{{ __('Continue') }}</button>
        </div>
    </div>
</div>
