<div>
    <div class="section-title clearfix">
        <h2>{{ __('Verify and publish') }}</h2>
    </div>
    <form class="row g-3 position-relative">
        <div class="loading " wire:loading.class="loading_show" wire:target="goTo">
            <div class="loader-show"></div>
        </div>
        <div class="col-md-12">
            <label for="title" class="form-label">{{ __('Ad Persian Title') }}</label>
            <input type="text" disabled wire:model="ad.title" class="form-control" id="title">
        </div>
        <div class="col-md-12">
            <label for="title_en" class="form-label">{{ __('Ad English Title') }}</label>
            <input type="text" disabled wire:model="ad.title_en" class="form-control" id="title_en">
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="email" disabled value="{{ auth()->user()->email }}" class="form-control"
                id="email" placeholder="{{ __('Email') }}">
        </div>
        <div class="col-md-6">
            <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
            <input type="text" disabled value="{{ auth()->user()->phone }}" class="form-control"
                id="phone" placeholder="{{ __('Phone Number') }}">
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" disabled id="gridCheck">
                <label class="form-check-label" for="gridCheck">
                    {{ __('Do not display the email in the ad') }}
                </label>
            </div>
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" disabled id="gridCheck">
                <label class="form-check-label" for="gridCheck">
                    {{ __('Do not display the phone number in the ad') }}
                </label>
            </div>
        </div>
        <div class="form-floating">
            <textarea class="form-control" wire:model="content" placeholder="{{ __('Ad Persian Description') }}" disabled
                id="content" style="height: 200px !important"></textarea>
            <label for="content">{{ __('Ad Persian Description') }}</label>
        </div>
        <div class="form-floating">
            <textarea class="form-control @error('content_en') is-invalid @enderror" disabled wire:model="content_en"
                placeholder="{{ __('Ad English Description') }}" id="content_en" style="height: 200px !important"></textarea>
            <label for="content_en">{{ __('Ad English Description') }}</label>
        </div>
        <div class="row g-3">
            @include('front.pages.ads.create.review-attributes', [
                'formAttributes' => $formAttributes,
            ])
        </div>
        <div class="row g-3">
            <div class="col">
                <select class="form-select" disabled wire:model="ad.state_id"
                    aria-label="Default select example"
                    style="{{ $isEn ? 'background-position: right 0.75rem center;' : 'background-position: left 0.75rem center;' }}">
                    <option selected>{{ __('State') }}</option>
                    @foreach (\App\Models\Address\State::all() as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <select class="form-select" wire:model="ad.city_id" disabled
                    aria-label="Default select example"
                    style="{{ $isEn ? 'background-position: right 0.75rem center;' : 'background-position: left 0.75rem center;' }}">
                    <option selected>{{ __('City') }}</option>
                    @foreach (\App\Models\Address\City::whereStateId($ad->state_id)->get() as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="section-title clearfix is-invalid">
                <h2>{{ __('Ad Images') }}</h2>
            </div>
            <div class="container-file">
                <div class="dropzone" style="height: auto ;min-height: 200px">
                    {{--        <label for="files" --}}
                    {{--               class="dropzone-container"> --}}
                    {{--         <div class="file-icon">+</div> --}}
                    {{--         <div class="dropzone-title"> --}}
                    {{--          جهت بارگذاری تصویر کلیک کنید --}}
                    {{--         </div> --}}
                    {{--        </label> --}}
                    <div class="d-flex flex-wrap justify-content-around">
                        @foreach ($previewPhotos as $photo)
                            <div class="position-relative ">
                                <img class="img-thumbnail m-1" height="200" width="200"
                                    src="{{ $photo->original_url }}">
                            </div>
                        @endforeach
                    </div>
                    <input id="files" {{--               name="files[]" --}}type="file" class="file-input" multiple
                        wire:model="photos" />
                </div>
            </div>
            @error('photos')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div>
    </form>
</div>
<div class="col-12 mt-5 d-flex justify-content-between">
    <button type="submit" class="btn btn-primary" wire:click="goTo('form')">{{ __('Previous Stage') }}
    </button>
    <button type="submit" class="btn btn-success" wire:click="store">{{ __('Verify and publish') }}
    </button>
</div>
