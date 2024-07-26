@php
    $categories = \App\Models\Ad\Category::with(['children' => function($query){
        $query->where('is_visible', true);
    }])
    ->where('parent_id', null)
    ->where('is_visible', true)
    ->get()->sortBy('position');
        // ->sortBy('name');
    // $businesses = $all
    //         ->where('slug', 'iranian-businesses-in-canada')
    //         ->where('is_visible', true)
    //         ->sortBy('position')->first();
    // $bussinessSubs = [];
    // if($businesses){
    //     $bussinessSubs = $all
    //             ->where('parent_id', $businesses->id)
    //             ->where('is_visible', true)
    //             ->sortBy('position');
    // }
    // $property = $all
    //         ->where('slug', 'property')
    //         ->where('is_visible', true)
    //         ->sortBy('position')->first();
    // $propertySubs = [];
    // if($property){
    //     $propertySubs = $all
    //             ->where('parent_id', $property->id)
    //             ->where('is_visible', true)
    //             ->sortBy('position');
    // }

    // $slug = request()->routeIs('front.ad.category.index*') ? Str::afterLast(request()->url(), '/') : null;
    // $parentSlug = false;
    // $businessSlug = false;
    // $propertySlug = false;

    $lang = App::isLocale('fa') ? "" : "en.";

@endphp

<li class="nav-item dropdown mobile-dropdown">
    <a class="nav-link
        {{ (
                request()->routeIs('front.ad.category.index*') ||
                request()->routeIs('en.front.ad.category.index*')
            ) ? "active-link-primary" : ""
        }}"
        href="#"
        data-bs-toggle="dropdown"
        aria-expanded="false"
        data-bs-auto-close="outside">{{ __('Ad Branches') }}</a>
    <ul class="dropdown-menu border-0 py-0" style="0.25rem 0.1rem 1rem rgba(0, 0, 0, 0.15) !important">
        @foreach ($categories as $value)
            <li class="nav-link dropdown p-0">
                <a class="dropdown-item p-3" data-bs-toggle="dropdown"
                    href="#" data-bs-auto-close="outside">
                    <i class="fa fa-{{ \App\Models\Ad\Category::NAV_ICONS[$value->slug] ?? \App\Models\Ad\Category::NAV_ICONS['default'] }} px-lg-2"></i>

                    {{ $value->locale_name }}</a>
                <ul class="dropdown-menu border-0 shadow">
                    @php
                        $subMenus = $value->children();
                    @endphp
                    @foreach ($subMenus as $subMenu)
                        <li class="">
                            <a href="{{ route($lang . 'front.ad.category.index.first.page', $subMenu->slug) }}"
                                class="dropdown-item d-block text-decoration-none text-black mt-2 lh-1 p-3 {{ $loop->last ? "" : "border-bottom" }}">{{ $subMenu->locale_name }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</li>
<li class="nav-item dropdown menu-area position-static desktop-dropdown">
    <a class="nav-link px-2 mega-link {{ (
            request()->routeIs('front.ad.category.index*') ||
            request()->routeIs('en.front.ad.category.index*')
        ) ? "active-link-primary" : "" }}"
        id="navbarDropdown"
        href="#" role="button" data-bs-toggle="dropdown"
        aria-expanded="false">{{ __('Ad Branches') }}</a>
    <div class="dropdown-menu mega-area position-absolute shadow border-0 start-0 end-0 py-0 m-0"
        aria-labelledby="navbarDropdown">
        <div class="row gx-0">
            <div class="col-md-3 px-0">
                <div class="flex-column d-flex pb-3">
                    @foreach ($categories as $value)
                        <a href="#"
                            class="mega-item-header text-decoration-none font-weight-bold ps-lg-3"
                            data-target="{{ $value->slug }}" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa fa-{{ \App\Models\Ad\Category::NAV_ICONS[$value->slug] ?? \App\Models\Ad\Category::NAV_ICONS['default'] }} px-lg-2"></i>
                            {{ $value->locale_name }}
                        </a>
                    @endforeach
                </div>
            </div>
            @foreach ($categories as $value)
                <div class="col-md-9 border-start px-0 d-none mega-submenu"
                    id="{{ $value->slug }}">
                    <div class="gx-0 px-3 py-1 row">
                        @php
                            $children = $value->children;
                            $childrenCount = $children->count();
                            $numColumns = $childrenCount < 4 ? 4 : 3;
                            $children = $children->chunk(ceil($childrenCount / $numColumns));
                        @endphp
                        @foreach ($children as $subMenus)
                            <div class="col-{{ 12 / $numColumns }}">
                            {{-- <div class="col-{{ $children?->count() <= 2 ? "6" : "4"}}"> --}}
                                @foreach ($subMenus as $subMenu)
                                    <a href="{{ route($lang . 'front.ad.category.index.first.page', $subMenu->slug) }}"
                                        class="d-block text-decoration-none text-secondary mt-2 p-2">{{ $subMenu->locale_name }}</a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</li>
@push('scripts')
  <script>
    $(".menu-area").hover(function() {
        $(this).find('.mega-link').attr("aria-expanded","true");
        $(this).find('.mega-link').addClass("show");
        $(this).find('.mega-area').addClass("show");
        $(this).find('.mega-area').attr("data-bs-popper", "none");
    }, function() {
        $(this).find('.mega-link').attr("aria-expanded","false");
        $(this).find('.mega-link').removeClass("show");
        $(this).find('.mega-area').removeClass("show");
        $(this).find('.mega-area').removeAttr("data-bs-popper");
    });

    $('#selector').click(function() {
        if (parseInt($(window).width()) < 600) {
            $(".menu-area").click(function() {
                $(this).find('.mega-link').attr("aria-expanded","true");
                $(this).find('.mega-link').addClass("show");
                $(this).find('.mega-area').addClass("show");
                $(this).find('.mega-area').attr("data-bs-popper", "none");
            }, function() {
                $(this).find('.mega-link').attr("aria-expanded","false");
                $(this).find('.mega-link').removeClass("show");
                $(this).find('.mega-area').removeClass("show");
                $(this).find('.mega-area').removeAttr("data-bs-popper");
            });

            $(".mega-item-header").toggle(function() {
                let target = $(this).data('target')
                $('#' + target).toggle("d-none");
                // $('#' + target).click(function() {
                //     $(this).removeClass("d-none");
                // });
                // $('#' + target).mouseleave(function() {
                //     $(this).addClass("d-none");
                // });
            });
            // $(".mega-item-header").mouseleave(function() {
            //     let target = $(this).data('target')
            //     $('#' + target).addClass("d-none");
            // });
        }
    });

    $(".mega-item-header").mouseenter(function() {
        let target = $(this).data('target')
        $('#' + target).removeClass("d-none");
        $('#' + target).mouseenter(function() {
            $(this).removeClass("d-none");
        });
        $('#' + target).mouseleave(function() {
            $(this).addClass("d-none");
        });
    });
    $(".mega-item-header").mouseleave(function() {
        let target = $(this).data('target')
        $('#' + target).addClass("d-none");
    });
  </script>
@endpush
