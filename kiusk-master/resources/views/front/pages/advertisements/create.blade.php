@extends('front.base')
@section('seo')
@endsection
@section('content')
    <livewire:front.advertisement.create :advertisement="$advertisement" :weeks="$weeks" />
@endsection

