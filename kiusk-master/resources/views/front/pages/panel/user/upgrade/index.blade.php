@extends('front.pages.panel.user.base')

@section('user_panel_content')
    <div>
        @if (auth()->user()->getRoleNames()->first() !== 'vip')
            <ul class="d-flex justify-content-around px-1 border-bottom-0 nav nav-tabs" id="blog_posts_sidebar">
                <li class="border-bottom-0 nav-item">
                    <a class="nav-link p-2 fs-6 active" data-bs-toggle="tab" aria-current="true"
                        href="#plans">{{ __('Plans') }}</a>
                </li>
                <li class="border-bottom-0 nav-item">
                    <a class="nav-link p-2 fs-6" data-bs-toggle="tab" href="#upgrade">{{ __('Upgrade Access Level') }}</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="plans">
                    <div class="card-body pt-0">
                        <livewire:front.panel.user.plans.vip-plans />
                    </div>
                </div>

                <div class="tab-pane" id="upgrade">
                    <div class="card-body pt-0">
                        <livewire:front.panel.user.profile.upgrade-access-level />
                    </div>
                </div>
            </div>
        @else
            <div class="card-body pt-0">
                <livewire:front.panel.user.plans.vip-plans />
            </div>
        @endif
    </div>
@endsection
