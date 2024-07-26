@extends('front.pages.panel.user.base')

@section('user_panel_content')
    {{-- <livewire:front.panel.user.profile.google-review /> --}}

    <div>
        <div class="section-title clearfix p-3 mt-4">
            <h2>{{ __('Google Review') }}</h2>
        </div>

        <div class="card">
            <div class="card-body">
                @if($links->count())
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('List of Links') }}</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($links as $key => $link)
                        <tr>
                            <th scope="row">{{  ($links->currentpage()-1) * $links->perpage() + $key + 1 }}</th>
                            <td>{{ $link->title }}</td>
                            <td><a href="{{ $link->url }}">{{ __('Click') }}</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $links->links("pagination::bootstrap-4") }}
                @else
                    <div class="text-center">
                        <p>{{ __('There is no link for review.') }}</p>
                    </div>
                @endif
            </div>
        </div>
    @endsection
