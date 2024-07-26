@extends('front.pages.panel.user.base')

@section('user_panel_content')
 @livewire('front.panel.user.ad.payment',['ad'=>$ad])
@endsection