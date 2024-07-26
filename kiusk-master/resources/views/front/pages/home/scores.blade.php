@extends('front.base')
@section('seo')
@endsection
@push('styles')
    <style>
        figure{
            text-align: center;
        }
        @media only screen and (max-width: 600px) {
            figure img{
                width: 100%;
                height: auto;
            }
        }
    </style>
@endpush
@section('content')
    <section class="blog-block m-0">
        <div class="container pt-5">
            <div class="row justify-content-md-center">
                <div class="col-md-8">
                    {!! s()->pageScores !!}
                </div>
            </div>
        </div>
    </section>
@endsection
