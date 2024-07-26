@extends('front.pages.panel.user.base')

@section('user_panel_content')
    <section class=" blog-block m-0">
        <div class="container p-4">
            @livewire('front.panel.user.plans.plans', ['ad' => $ad])
        </div>
    </section>
@endsection
