<div class="col-11 m-auto">
    <div class="alert alert-primary" role="alert">
        <div class="d-flex justify-content-between">
            <p> {{ __('You are posting an ad in the category') }}
                {{ \App\Models\Ad\Category::find($selectedCategory)->locale_name }} </p>
            <button class="btn-primary p-1" wire:click="goTo('category')">{{ __('Change Category') }}
            </button>
        </div>
    </div>
</div>
<div class="col-11 m-auto ">
    <div class="section-title clearfix">
        <h2>{{ __('Ad Info') }} </h2>
    </div>
    <form class="row g-3 position-relative">
        <div class="loading " wire:loading.class="loading_show" wire:target="goTo">
            <div class="loader-show"></div>
        </div>
        <div class="col-md-12">
            <label for="persian_title" class="form-label">{{ __('Ad Persian Title') }}</label>
            <input type="text" wire:model.defer="ad.title"
                class="form-control  @error('ad.title') is-invalid @enderror" id="persian_title">
            @error('ad.title')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-12">
            <label for="english_title" class="form-label">{{ __('Ad English Title') }}</label>
            <input type="text" wire:model.defer="ad.title_en"
                class="form-control  @error('ad.title_en') is-invalid @enderror" id="english_title">
            @error('ad.title_en')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div>
        {{-- <div class="col-md-4 price-2 position-relative">
            <label for="inputPassword4price" class="form-label">{{ __('Price') }}</label>
            <input type="number" wire:model="ad.price" style="direction: rtl"
                class="form-control  @error('ad.price') is-invalid @enderror" id="inputPassword4price">
            @error('ad.price')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div> --}}
        <div class="col-md-6">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="email" disabled value="{{ auth()->user()->email }}" class="form-control "
                id="email" placeholder="{{ __('Email') }}">
        </div>
        <div class="col-md-6">
            <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
            <input type="text" disabled value="{{ auth()->user()->phone }}" class="form-control "
                id="phone" placeholder="{{ __('Phone Number') }}">
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" wire:model="showEmail" id="show_email">
                <label class="form-check-label" for="show_email">
                    {{ __('Do not display the email in the ad') }}
                </label>
            </div>
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" wire:model="showPhone" id="show_phone">
                <label class="form-check-label" for="show_phone">
                    {{ __('Do not display the phone number in the ad') }}
                </label>
            </div>
        </div>
        {{-- <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" wire:model="isFeatured" id="gridCheck">
                <label class="form-check-label" for="gridCheck">
                    {{ __('Special Ad') }}
                </label>
            </div>
        </div> --}}
        <div class="form-floating">
            <textarea class="form-control @error('content') is-invalid @enderror" wire:model.defer="content"
                placeholder="{{ __('Ad Description') }}" id="floatingTextarea2" style="height: 200px !important"></textarea>
            <label for="floatingTextarea2">{{ __('Ad Persian Description') }}</label>
            @error('content')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-floating">
            <textarea class="form-control @error('content_en') is-invalid @enderror" wire:model.defer="content_en"
                placeholder="{{ __('Ad Description') }}" id="floatingTextarea3" style="height: 200px !important"></textarea>
            <label for="floatingTextarea3">{{ __('Ad English Description') }}</label>
            @error('content_en')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div>
        {{-- <div class="row g-3">
            @include('front.pages.ads.create.attributes', [
                'formAttributes' => $formAttributes,
            ])
        </div> --}}
        <div class="row g-3">
            <div class="col">
                <select class="form-select @error('ad.state_id') is-invalid @enderror"
                    wire:model="ad.state_id" aria-label="Default select example"
                    style="{{ $isEn ? 'background-position: right 0.75rem center;' : 'background-position: left 0.75rem center;' }}">
                    <option selected>{{ __('State') }}</option>
                    @foreach (\App\Models\Address\State::all() as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
                @error('ad.state_id')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col position-relative">
                <div class="loading " wire:loading.class="loading_show" wire:target="ad.state_id">
                    <div class="loader-show-input"></div>
                </div>
                <select class="form-select @error('ad.city_id') is-invalid @enderror"
                    wire:model="ad.city_id" aria-label="Default select example"
                    style="{{ $isEn ? 'background-position: right 0.75rem center;' : 'background-position: left 0.75rem center;' }}">
                    <option selected>{{ __('City') }}</option>
                    @foreach (\App\Models\Address\City::whereStateId($ad->state_id)->get() as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
                @error('ad.city_id')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="section-title clearfix ">
                <h2>{{ __('Ad Images') }}</h2>
            </div>
            <p class="text-center">
                {{ __('Adding a photo will increase your ad views up to three times.') }}</p>
            <div class="container-file ">
                <div class="dropzone">
                    <label for="files" class="dropzone-container">
                        <div class="file-icon">+</div>
                        <div class="dropzone-title">
                            {{ __('Click to load the image') }}
                        </div>
                        <div class="spinner-border" role="status" wire:loading wire:target="photos">
                            <span class="visually-hidden">{{ __('Loading') }}...</span>
                        </div>
                    </label>
                    <div class="d-flex flex-wrap justify-content-around">
                        @foreach ($previewPhotos as $photo)
                            <div class="position-relative mb-1">
                                <img class="img-thumbnail " height="200" width="200"
                                    src="{{ $photo->original_url }}">
                                <span
                                    class="position-absolute top-0 start-100 translate-middle p-2   rounded-circle">
                                    <i class="fa fa-trash" aria-hidden="true"
                                        wire:click="mediaDelete({{ $photo->id }})"></i>
                                    <span class="visually-hidden">New alerts</span>
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <input id="files" type="file" class="file-input" multiple
                        wire:model="photos" />
                </div>
            </div>
            @php
                $message = '';
            @endphp
            @foreach ($errors->getMessageBag()->messages() as $key => $error)
                @if (Str::is('photos*', $key))
                    @foreach ($error as $e)
                        @php
                            $message .= $e;
                        @endphp
                    @endforeach
                @endif
            @endforeach
            @if ($message)
                <span class=" text-danger">{{ $message }}</span>
            @endif
        </div>
    </form>
</div>
<div class="col-12 mt-5 d-flex justify-content-between">
    <button type="submit" class="btn btn-primary"
        wire:click="goTo('category')">{{ __('Previous Stage') }}
    </button>
    <button type="submit" class="btn btn-success" wire:click="goTo('review')">{{ __('Next Stage') }}
    </button>
</div>
