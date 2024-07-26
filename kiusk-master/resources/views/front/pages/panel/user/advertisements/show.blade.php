@extends('front.pages.panel.user.base')

@section('user_panel_content')
    <section class=" blog-block m-0">
        <div class="container p-4">
            <section class="row">
                <livewire:front.panel.user.advertisement.show :advertisementOrder="$advertisementOrder" :wire:key="$advertisementOrder->id" />
            </section>
        </div>
    </section>
@endsection
