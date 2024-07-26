<div class="col-11 m-auto">
    <div class="mb-4 mt-4">
        <h2>{{ __('Please select your ad category') }}</h2>
    </div>
    <div class="position-relative">
        <div class="loading " wire:loading.class="loading_show">
            <div class="loader-show"></div>
        </div>
        <ul class="list-group col-12 ">
            @if ($backToCategory)
                <div class="list-group-item back">
                    <a wire:click.prevent="getChildrenBack()">
                        <span class="back-icon {{ $isEn ? 'ms-2' : '' }}"><i
                                class="far fa-chevron-{{ $isEn ? 'left' : 'right' }} text-secondary"></i></span>
                        {{ __('Return') }}
                    </a>
                </div>
            @endif
            @foreach ($categories as $category)
                @if ($category['children_count'])
                    <li class="list-group-item p-3 newads-list"
                        wire:click="getChildren({{ $category['id'] }})">{{ $category['locale_name'] }}</i>
                    </li>
                @else
                    <li class="list-group-item p-3 newads-list"
                        wire:click="selectCategory({{ $category['id'] }})">
                        {{ $category['locale_name'] }}</i>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
