@extends('front.pages.panel.user.base')

@section('user_panel_content')
    <livewire:front.panel.user.profile.edit />
    <livewire:front.panel.user.profile.user-referral-code />
    <livewire:front.panel.user.profile.verify-email />
    <livewire:front.panel.user.profile.verify-phone />
@endsection
