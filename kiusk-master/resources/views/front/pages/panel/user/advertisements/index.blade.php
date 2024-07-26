@extends('front.pages.panel.user.base')

@section('user_panel_content')
    <section class=" blog-block m-0">
        <div class="container p-4">
            <div class="row">
                <div class="col">
                    <a class="rounded-pill p-1 ps-2 pe-2 btn btn-ads me-3 me-md-0
                        position-absolute end-0"
                        href="{{ route('front.advertisement.index') }}" style="width:110px">
                        {{ __('New Ad') }} <i class="fa fa-plus mx-2"></i>
                    </a>
                </div>
            </div>
            <livewire:front.panel.user.advertisement.index />
        </div>
    </section>
@endsection
