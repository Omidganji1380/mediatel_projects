{{-- @php
    $all = \App\Models\Ad\Category::all();
    $parents = $all
        ->where('slug', '!=', 'iranian-businesses-in-canada')
        ->where('slug', '!=', 'property')
        ->where('parent_id', null)
        ->where('is_visible', true)
        ->sortBy('position');
        // ->sortBy('name');
    $businesses = $all
            ->where('slug', 'iranian-businesses-in-canada')
            ->where('is_visible', true)
            ->sortBy('position')->first();
    $bussinessSubs = [];
    if($businesses){
        $bussinessSubs = $all
                ->where('parent_id', $businesses->id)
                ->where('is_visible', true)
                ->sortBy('position');
    }
    $property = $all
            ->where('slug', 'property')
            ->where('is_visible', true)
            ->sortBy('position')->first();
    $propertySubs = [];
    if($property){
        $propertySubs = $all
                ->where('parent_id', $property->id)
                ->where('is_visible', true)
                ->sortBy('position');
    }

    $slug = request()->routeIs('front.ad.category.index*') ? Str::afterLast(request()->url(), '/') : null;
    $parentSlug = false;
    $businessSlug = false;
    $propertySlug = false;

    $lang = App::isLocale('fa') ? "" : "en.";

@endphp --}}



{{-- <li class="nav-item dropdown mega-menu">
    <a href="#" class="nav-link child" id="sale-categories" data-bs-toggle="dropdown" aria-expanded="false">
        {{ __('Ads Branches') }} <i class="far fa-chevron-down"></i>
    </a> --}}

    {{-- <x-front.layouts.header.category-menu.mega-menu :categories="" /> --}}
    {{-- <div class="dropdown-menu mega-menu-content" aria-labelledby="sale-categories">
        <div class="row">
            <div class="col-md-6">
                <ul class="list-unstyled">
                    @foreach ($parents as $parent)
                        <li class="mega-menu-item">
                            <a href="{{ route($lang . 'front.ad.category.index.first.page', [$parent->slug]) }}">{{ $parent->locale_name }}</a>
                            @php
                                $children = $all
                                    ->where('parent_id', $parent->id)
                                    ->where('is_visible', true)
                                    ->sortBy('position');
                            @endphp
                            <div class="mega-sub-menu">
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul>
                                            @foreach($children as $child)
                                                <li><a href="{{ route($lang . 'front.ad.category.index.first.page', [$parent->slug]) }}">{{ $parent->locale_name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div> --}}
{{-- </li> --}}


{{-- <li class="nav-item dropdown mega-menu">
    <a href="#" class="nav-link child" id="sale-categories" data-bs-toggle="dropdown" aria-expanded="false">
        {{ __('Ads Branches') }} <i class="far fa-chevron-down"></i>
    </a>
    <div class="dropdown-menu mega-menu-content" aria-labelledby="sale-categories">
        <div class="row">
            <div class="col-6">
                <ul class="list-unstyled">
                    @foreach ($parents as $parent)
                        <li><a href="{{ route($lang . 'front.ad.category.index.first.page', [$parent->slug]) }}">{{ $parent->locale_name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-6">
                @foreach ($parents as $parent)
                    @php
                        $children = $all
                            ->where('parent_id', $parent->id)
                            ->where('is_visible', true)
                            ->sortBy('position');

                        $parentSlug = (
                                $parents->where('slug', $slug)->first() ||
                                $children->where('slug', $slug)->first() ||
                                $parent->slug == $slug
                            ) ? true : false;
                    @endphp

                    @includeWhen($children->count(), 'front.layouts.header.category-menu.sub-category-menu', [
                        'children' => $children,
                        'all' => $all,
                    ])
                @endforeach
            </div>
        </div>
    </div>
</li> --}}


{{-- <li class="nav-item">
    <a href=""
        class="nav-link child" id="sale-categories">
        {{ __('Buying and sell') }} <i class="far fa-chevron-down"></i>
    </a>
    <ul class="p-0 text-start {{ $lang ? "inner-ul-en" : "inner-ul" }}">
        @foreach ($parents as $parent)
            <li class="nav-item"><a
                    href="{{ route($lang . 'front.ad.category.index.first.page', [$parent->slug]) }}">{{ $parent->locale_name }}</a>
                @php
                    $children = $all
                        ->where('parent_id', $parent->id)
                        ->where('is_visible', true)
                        ->sortBy('position');
                        // ->sortBy('name');

                    $parentSlug = (
                            $parents->where('slug', $slug)->first() ||
                            $children->where('slug', $slug)->first() ||
                            $parent->slug == $slug
                        ) ? true : false;
                @endphp

                @includeWhen($children->count(), 'front.layouts.header.category-menu.sub-category-menu', [
                    'children' => $children,
                    'all' => $all,
                ])
            </li>
        @endforeach
    </ul>
</li> --}}
{{-- <li class="nav-item">
    <a href=""
        class="nav-link child " id="business-categories">
        {{ $businesses->locale_name }} <i class="far fa-chevron-down"></i>
    </a>
    <ul class="p-0 text-start {{ $lang ? "inner-ul-en" : "inner-ul" }}">
        @foreach ($bussinessSubs as $parent)
            <li class="nav-item">
                <a
                    href="{{ route( $lang . 'front.ad.category.index.first.page', [$parent->slug]) }}">
                    {{ $parent->locale_name }}
                </a>
                @php
                    $children = $all
                        ->where('parent_id', $parent->id)
                        ->where('is_visible', true)
                        ->sortBy('position');
                        // ->sortBy('name');
                    $businessSlug = (
                            $bussinessSubs->where('slug', $slug)->first() ||
                            $children->where('slug', $slug)->first() ||
                            $parent->slug == $slug
                        )  ? true : false;
                        // dump($parent->slug == $slug);
                @endphp

                @includeWhen($children->count(), 'front.layouts.header.category-menu.sub-category-menu', [
                    'children' => $children,
                    'all' => $all,
                ])
            </li>
        @endforeach
    </ul>
</li>
<li class="nav-item">
    <a href=""
        class="nav-link child " id="property-categories">
        {{ $property?->locale_name }} <i class="far fa-chevron-down"></i>
    </a>
    <ul class="p-0 text-start {{ $lang ? "inner-ul-en" : "inner-ul" }}">
        @foreach ($propertySubs as $parent)
            <li class="nav-item">
                <a
                    href="{{ route( $lang . 'front.ad.category.index.first.page', [$parent->slug]) }}">
                    {{ $parent->locale_name }}
                </a>
                @php
                    $children = $all
                        ->where('parent_id', $parent->id)
                        ->where('is_visible', true)
                        ->sortBy('position');
                        // ->sortBy('name');
                    $propertySlug = (
                            $propertySubs->where('slug', $slug)->first() ||
                            $children->where('slug', $slug)->first() ||
                            $parent->slug == $slug
                        )  ? true : false;
                        // dump($parent->slug == $slug);
                @endphp

                @includeWhen($children->count(), 'front.layouts.header.category-menu.sub-category-menu', [
                    'children' => $children,
                    'all' => $all,
                ])
            </li>
        @endforeach
    </ul>
</li> --}}

{{-- @push('scripts')
    <script>
        @if($parentSlug)
            $("#sale-categories").addClass('active-link-primary');
        @endif
        @if($businessSlug)
            $("#business-categories").addClass('active-link-primary');
        @endif
    </script>
@endpush --}}
