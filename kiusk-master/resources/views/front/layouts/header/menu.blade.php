@php
    $lang = App::isLocale('fa') ? '' : 'en.';
@endphp
{{-- @dd(s()->headerMainMenu) --}}
<a class="navbar-brand {{ App::isLocale('fa') ? 'me-3' : 'ms-3' }}" href="{{ route($lang . 'front.home') }}"
    style="width: 70px;">
    {{-- <img src="{{ asset('storage/' . s()->logo) }}"> --}}
    <img src="{{ asset(App::isLocale('fa') ? 'images/kiusk logo-fa.png' : 'images/kiusk logo-en.png') }}" class="w-100">
</a>
<button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
    aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon bg-white"></span>
</button><!-- navigation -->
<div class="navbar navbar-expand-lg navbar-light navigation collapse navbar-collapse main-menu shadow" id="navbar">
    <ul class="navbar-nav">
        <?php
        $path = urldecode('/' . request()->path());
        if (request()->routeIs('front.home') && $path === '//') {
            $path = '/';
        }
        $showedCategory = false;
        ?>
        @foreach (s()->headerMainMenu as $item)
            @if ($loop->iteration == s()->sequenceCategoryMenu)
                {{-- @include('front.layouts.header.category-menu.category-menu') --}}
                @include('front.layouts.header.category-menu.mega-menu')
                <?php
                $showedCategory = true;
                ?>
            @endif
            @if (count($item['submenu'] ?? []))
            <?php
                $activeLink = collect($item['submenu'])->contains(function ($value, $key) use($path) {
                            return urldecode($value['url']) == $path;
                        });
            ?>
                <li class="nav-item">
                    <a href="{{ $item['url'] }}"
                        class="nav-link {{ $loop->last ? 'border-0' : '' }}  {{   $activeLink ? 'active-link-primary' : '' }}">{!! $item['text'] !!}</a>
                    <ul class="inner-ul p-0">
                        @foreach ($item['submenu'] as $submenu)
                            <li class="nav-item">
                                <a href="{{ $submenu['url'] }}"
                                    class="nav-link text-start {{ $loop->last ? 'border-0' : '' }} {{ $path == urldecode($submenu['url']) ? 'active-link-primary' : '' }}">{!! $submenu['text'] !!}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @else
                <li class="nav-item">
                    <a href="{{ $item['url'] }}"
                        class="nav-link {{ $loop->last ? 'border-0' : '' }} {{ $path == urldecode($item['url']) ? 'active-link-primary' : '' }}">{!! $item['text'] !!}</a>
                </li>
            @endif
        @endforeach
        @includeWhen(!$showedCategory, 'front.layouts.header.category-menu.category-menu')
    </ul>
</div><!-- buttons -->
<ol class="ad-create-ol" id="ad-create-ol-menu">
    {{-- <li class="top-category-btn">
        <button type="button" class="btn btn-primary text-caps btn-rounded btn-framed" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" style="width: 130px">
            <i class="fa fa-align-justify mx-1" aria-hidden="true"></i>
            {{ __('Categories') }}
        </button>
        <!--  -->
    </li> --}}
    <li class="nav-item submit_ad w-100 positions-absolute">
        <a href="{{ route($lang . 'front.ad.create') }}"
            class="btn btn-primary text-caps btn-rounded btn-framed nav-btn">
            <i class="fa fa-plus mb-1 mx-1" aria-hidden="true"></i> {{ __('Create Ad') }} </a>
    </li>
</ol>


@push('scripts')
    <script>
        $(document).ready(function() {
            $(".navbar-toggler").on("click", function() {
                $("#ad-create-ol-menu").toggleClass("ad-create-ol ad-create-ol-nav-open");
            });
        });
    </script>
@endpush
