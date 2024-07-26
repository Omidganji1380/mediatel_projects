@php
    $positionBackground =  App::isLocale('fa') ? "background-position: left 0.75rem center;" :  "background-position: right 0.75rem center;"
@endphp

<form action="" @class([
    'mt-2 mb-5 p-md-0 pb-md-5 p-4' => $isOpen,
    'form-floating p-0 ps-1' => !$isOpen,
])>
    <div class="container">
        <div class="row row-cols-3 align-items-center">
            <div class="col-12 col-lg-5 {{ App::isLocale('fa') ? "pe-3 ps-1" : "ps-3" }}">
                <input type="text" class="form-control" wire:model="text" placeholder="{{ __('Search in all ads') }}">
            </div>
            <div class="row ps-2 g-2 col-12 col-lg-5 ps-2 ps-lg-0">
                <div class="col-lg-5">
                    <div class="form-floating p-0 {{ App::isLocale('fa') ? "pe-2" : "ps-2" }}">
                        <select class="form-select" wire:model="state_id" style="{{ $positionBackground }}">
                            <option value="0" selected>{{ __('All States') }}
                            </option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="form-floating p-0 {{ App::isLocale('fa') ? "pe-2" : "ps-2" }}">
                        <select class="form-select" style="{{ $positionBackground }}" id="floatingSelectGrid" aria-label="Floating label select example"
                            wire:model="category_id">
                            <option value="0" selected>{{ __('All Categories') }}
                            </option>
                            @foreach ($categories->where('parent_id', null) as $category)
                                <option value="{{ $category->id }}">{{ $category->locale_name }}</option>

                                @include('livewire.front.ad.sub-category', [
                                    'children' => $categories->where('parent_id', $category->id),
                                    'categories' => $categories,
                                ])
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-2 mt-3">
                <button type="submit" class="btn btn-primary w-100 hover-shadow" wire:click="startSearch()">{{ __('Search') }}
                </button>
            </div>
        </div>
    </div>
</form>
