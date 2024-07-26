@extends('front.base')
@section('seo')
@endsection
@section('content')
    <section class=" blog-block m-0">
        <livewire:front.advertisement.ad-cart  :cart="$cart" />
    </section>
@endsection
