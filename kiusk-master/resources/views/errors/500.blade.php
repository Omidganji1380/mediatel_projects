{{-- @extends('errors::minimal')@section('title', __('Server Error'))@section('code', '500')@section('message', __('Server Error')) --}}
@php
    if(Auth::check()){
        App::setLocale( Auth::user()->lang ?: config('app.locale') );
    }else{
        App::setLocale( Cookie::get('lang') ?: config('app.locale') );
    }
@endphp
@extends('front.base')

@section('title', __('Something Went Wrong.'))

@section('content')
    <div class="d-flex align-items-center justify-content-center" dir="{{ App::isLocale('fa') ? "rtl" : "ltr" }}">
        <div class="text-center">
            <h1 class="display-1 fw-bold">500</h1>
            <p class="fs-3"> <span class="text-danger">{{ __('Opps!') }}</span> {{ __('Something Went Wrong.') }} :(</p>
            <p class="lead w-50 m-auto mb-4" style="line-height: 1.5">
                {{ __("messages.errors.500") }}
            </p>
            <ul>
                <li><b>{{ __('Email') }}:</b> info@kiusk.ca</li>
                <li><b>{{ __('Support ticket system') }}:</b> <a href="{{ route(App::isLocale('fa') ? 'front.panel.user.tickets.create' : 'en.front.panel.user.tickets.create') }}">{{ __('Ticket') }}</a></li>
            </ul>

            <a href="{{ route(App::isLocale('fa') ? 'front.home' : 'en.front.home') }}" class="btn btn-primary">{{ __('Go Home') }}</a>
        </div>
    </div>
@endsection
