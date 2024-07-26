@php
    $lang = $lang = App::isLocale('fa') ? "" : "en.";
@endphp
<ul class="inner-ul text-start p-0 {{ App::isLocale('en') ? "right-ul" : "left-ul" }}">
    @foreach ($children as $child)
        <li class="nav-item"><a
                href="{{ route($lang . 'front.ad.category.index.first.page', [$child->slug]) }}">{{ $child->locale_name }}</a>
            @php
                $children = $all
                    ->where('parent_id', $child->id)
                    ->sortBy('position')
                    ->sortBy('name');
            @endphp

            @includeWhen($children->count(), 'front.layouts.header.category-menu.sub-category-menu', [
                'children' => $children,
                'all' => $all,
            ])
        </li>
    @endforeach
</ul>
