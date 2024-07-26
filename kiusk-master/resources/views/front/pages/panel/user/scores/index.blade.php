@extends('front.pages.panel.user.base')

@section('user_panel_content')
<div class="border-bottom pt-3">
    <ul class="d-flex justify-content-around px-1 border-bottom-0 nav nav-tabs" id="blog_posts_sidebar">
        <li class="border-bottom-0 nav-item">
            <a class="nav-link p-2 fs-6 active" data-bs-toggle="tab" aria-current="true"
                href="#ways_to_earn_points">{{ __('Ways To Earn Points') }}</a>
        </li>
        <li class="border-bottom-0 nav-item">
            <a class="nav-link p-2 fs-6" data-bs-toggle="tab" href="#earn_points">{{ __('Earn Points') }}</a>
        </li>
        <li class="border-bottom-0 nav-item">
            <a class="nav-link p-2 fs-6" data-bs-toggle="tab" href="#my_points">{{ __('My Points') }}</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="ways_to_earn_points">
            <div class="card-body pt-0">
                <livewire:front.panel.user.scores.descriptions />
            </div>
        </div>
        <div class="tab-pane" id="earn_points">
            <div class="card-body pt-0">
                <livewire:front.panel.user.scores.activity />
            </div>
        </div>
        <div class="tab-pane" id="my_points">
            <div class="card-body pt-0 border-top-0">
                <livewire:front.panel.user.scores.index />
            </div>
        </div>
    </div>
</div>

@endsection
