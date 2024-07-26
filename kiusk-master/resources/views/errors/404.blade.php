{{-- @extends('errors::minimal')@section('title', __('Not Found'))@section('code', '404')@section('message', __('Not Found')) --}}
@php
    if(Auth::check()){
        App::setLocale( Auth::user()->lang ?: config('app.locale') );
    }else{
        App::setLocale( Cookie::get('lang') ?: config('app.locale') );
    }
@endphp
@extends('front.base')

@section('title', __('Not Found'))

@section('content')
    <div class="d-flex align-items-center justify-content-center">
        <div class="text-center">
            <h1 class="display-1 fw-bold">404</h1>
            <p class="fs-3"> <span class="text-danger">{{ __('Opps!') }}</span> {{ __('Page not found.') }}</p>
            <p class="lead">
                {{ __("The page you're looking for doesn't exist.") }}
            </p>
            <a href="{{ route(App::isLocale('fa') ? 'front.home' : 'en.front.home') }}" class="btn btn-primary">{{ __('Go Home') }}</a>
        </div>
    </div>
@endsection

