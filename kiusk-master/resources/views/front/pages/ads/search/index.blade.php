@extends('front.base')
@section('seo')
@endsection
@section('content')
    <section class=" blog-block m-0 p-4">
        <div class="container border-0 border-bottom">
            @isset($category)
                {{-- <div class="row mb-4">
                    <div class="col-md-4 col-sm-4 col-12 d-flex">
                        <div class="align-self-center d-md-block d-none">
                            <h2 class="fs-3">{{ $category->locale_name }}</h2>
                            <p class="font-weight-bold">{{ $category->locale_tag_line }}</p>
                            <a href="#ads" class="animated-button">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                {{ $category->locale_name }}
                            </a>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-8 col-12">
                        @if($category->getFirstMediaUrl('SpecialImage'))
                            <img src="{{ $category->getFirstMediaUrl('SpecialImage') }}" class="w-100" alt="{{ $category->locale_name }}">
                        @endif
                    </div>
                </div> --}}
                <div class="mb-5">
                    {!! $category->locale_description  !!}
                </div>
            @endisset
            <livewire:front.ad.advance-search />
            <livewire:front.ad.search.list-search :ads="$ads" :urls="$urls" />
            @isset($category)
                <div>
                    {!! $category->locale_full_description  !!}
                </div>
            @endisset
        </div>
    </section>
@endsection
@section('script')
<script>
    window.addEventListener('state-name-updated', event => {
        $("#textBeforeState").text("{{__('in')}}");
        $("#stateName").text(event.detail.stateName)
    })
    window.addEventListener('city-name-updated', event => {
        $("#textBeforeState").text("{{__('in')}}");
        $("#cityName").text(event.detail.cityName)
    })
</script>
@endsection
