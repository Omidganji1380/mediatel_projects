@extends('front.layouts.email')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-center">
            <h1 class="text-danger">{{ __('emails.greeting', ['name' => trim($user->full_name) ?: __('User')]) }}</h1>
        </div>
        <div class="" style="text-align: center !important;">
            {!! __('emails.messages.welcome') !!}
        </div>
        <div class="d-flex justify-content-center pt-3" style="text-align: center !important;">
            <p class="font-weight-bold">{{ __('emails.regards') }}</p>
        </div>
    </div>
@endsection
