@extends('front.pages.panel.user.base')

@section('user_panel_content')
@php
$lang = App::isLocale('fa') ? "" : "en.";
@endphp
    <section class=" blog-block m-0">
        <div class="container p-4">
            <div class="row">
                <div class="col">
                    <a class="rounded-pill p-1 ps-2 pe-2 btn btn-ads me-3 me-md-0
                        position-absolute end-0"
                        href="{{ route($lang . 'front.panel.user.tickets.create') }}" style="width:110px">
                        {{ __('New Ticket') }} <i class="fa fa-plus mx-2"></i>
                    </a>
                </div>
            </div>
            @livewire('front.panel.user.tickets.ticket')
        </div>
    </section>
@endsection
