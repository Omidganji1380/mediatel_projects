<div class="container pt-5">
    <div id="spinner" wire:loading>
        <img src="{{ asset('images/ajax-loader.gif') }}"/>
    </div>
    <form wire:submit.prevent="store">
        <div class="card mb-3">
            <div class="card-header border-bottom-1 bg-transparent text-center">
                <h5 class="text-secondary">{{ __('Personal Information') }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="">{{ __('First Name') }}</label>
                        <input type="text" class="form-control" wire:model.defer="first_name" name="first_name">
                        @error('first_name')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="">{{ __('Last Name') }}</label>
                        <input type="text" class="form-control" wire:model.defer="last_name" name="last_name">
                        @error('last_name')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="">{{ __('E-Mail Address') }}</label>
                        <input type="text" class="form-control" wire:model.defer="email" name="email">
                        @error('email')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="">{{ __('Business Name') }}</label>
                        <input type="text" class="form-control" wire:model.defer="business_name" name="business_name">
                         @error('business_name')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="">{{ __('Phone 1') }}</label>
                        <input type="text" class="form-control" wire:model.defer="phone" name="phone" placeholder="{{ __('Enter Canada phone number without +1') }}">
                        @error('phone')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="">{{ __('Phone 2') }}</label>
                        <input type="text" class="form-control" wire:model.defer="phone_2" name="phone_2" placeholder="{{ __('Enter Canada phone number without +1') }}">
                         @error('phone_2')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="">{{ __('Website') }}</label>
                        <input type="text" class="form-control" wire:model.defer="website" name="website" placeholder="{{ __('Enter Your Website') }}">
                        @error('website')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="">{{ __('Url Address') }}</label>
                        <input type="text" class="form-control" wire:model.defer="url" name="url" placeholder="{{ __('Enter your url') }}">
                         @error('url')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="">{{ __('State') }}</label>
                        <select wire:model="state_id" name="state_id" id="state_id" class="form-control">
                            <option value="">{{ __('Select a state') }}</option>
                            @foreach ($states as $state)
                                <option
                                    value="{{ $state->id }}"
                                    {{ $state->id == $state_id ? "selected" : "" }}
                                    >
                                    {{ $state->name }}
                                </option>
                            @endforeach
                        </select>
                         @error('state_id')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="">{{ __('City') }}</label>
                        <select wire:model="city_id" name="city_id" id="city_id" class="form-control">
                            <option value="">{{ __('Select a city') }}</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}"
                                     {{ $city->id == $city_id ? "selected" : "" }}
                                     >{{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('city_id')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header border-bottom-1 bg-transparent text-center">
                <h5 class="text-secondary">{{ __('Ad Information') }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="row mb-3">
                        <div class="col-md-12 mx-auto mb-3">
                            <label for="">{{ __('Persian Title') }}</label>
                            <input type="text" class="form-control" wire:model.defer="title" name="title">
                            @error('title')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12 mx-auto mb-3">
                            <label for="">{{ __('English Title') }}</label>
                            <input type="text" class="form-control" wire:model.defer="title_en" name="title_en">
                            @error('title_en')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mx-auto mb-3">
                            <label for="">{{ __('Persian Description') }}</label>
                            <textarea class="form-control"
                                    wire:model.defer="description_fa"
                                    name="description_fa" id="description_fa" cols="30"
                                    rows="10">
                            </textarea>
                            @error('description_fa')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12 mx-auto mb-3">
                            <label for="">{{ __('English Description') }}</label>
                            <textarea class="form-control"
                                    wire:model.defer="description_en"
                                    name="description_en" id="description_en"
                                    cols="30"
                                    rows="10">
                            </textarea>
                            @error('description_en')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="">{{ __('Categories') }}</label>
                            <select wire:model="category_id" name="category_id" id="category_id" class="form-control">
                                <option value="">{{ __('Select a category') }}</option>
                                @foreach ($categories as $category)
                                    <option
                                        value="{{ $category->id }}"
                                        {{ $category->id == $category_id ? "selected" : "" }}
                                        >
                                        {{ $category->locale_name }}
                                    </option>
                                @endforeach
                            </select>
                             @error('category_id')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="">{{ __('Logo') }}</label>
                            <input type="file" wire:model.defer="logo" name="logo" id="logo"
                                class="form-control">
                                @error('logo')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                                @if ($logo)
                                    {{ __('Preview') }}:
                                    <img src="{{ $logo->temporaryUrl() }}" class="w-100">
                                @endif
                        </div>
                    </div> --}}
                    {{-- <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" wire:model.defer="exclusive_design" name="exclusive_design"
                                id="flexCheckCheckedDisabled">
                                <label class="form-check-label" for="flexCheckCheckedDisabled">
                                    {{ __('Exclusive design') }}
                                </label>
                            </div>
                            @error('exclusive_design')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @if($exclusive_design)
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="">{{ __('Upload Design') }}</label>
                                <input type="file" name="design" wire:model.defer="design" class="form-control" id="design">
                            </div>
                            @error('design')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                            @if ($design)
                                {{ __('Preview') }}:
                                <img src="{{ $design->temporaryUrl() }}" class="w-100">
                            @endif
                        </div>
                    @endif --}}
                    {{-- <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" wire:model.defer="acceptRules" name="acceptRules"
                                id="flexCheckCheckedDisabled">
                                <label class="form-check-label" for="flexCheckCheckedDisabled">
                                    {!! __('messages.accept_rules') !!}
                                </label>
                            </div>
                            @error('acceptRules')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">{{ __('Submit and pay') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
{{-- @push('scripts')
<script src="{{ asset('front/vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>

    tinymce.init({
        selector: 'textarea#description_fa',
        forced_root_block: false,
        setup: function (editor) {
            editor.on('init change', function () {
                editor.save();
            });
            editor.on('change', function (e) {
                @this.set('description_fa', editor.getContent());
            });
        }
    });
    tinymce.init({
        selector: 'textarea#description_en',
        forced_root_block: false,
        setup: function (editor) {
            editor.on('init change', function () {
                editor.save();
            });
            editor.on('change', function (e) {
                @this.set('description_en', editor.getContent());
            });
        }
    });
</script>
@endpush --}}
