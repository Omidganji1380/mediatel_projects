<div>
    <div class="section-title clearfix p-3 mt-4">
        <h2>{{ __('Google Review') }}</h2>
    </div>

    <div class="card">
        <div class="card-body">
            @foreach ($links as $link)
                <div>
                    <label for="">{{ $link->title }}</label>
                    <a href="{{ $link->url }}">{{ __('Click') }}</a>
                </div>
            @endforeach
        </div>
    </div>

    {{-- <div>
        <form wire:submit.prevent="save">
            <div class="row">
                <div class="col-12 mb-3">
                    <label for="google_review" class="form-label">{{ __('Send Google Review Url') }}</label>
                    <input type="text" wire:model="google_review_url" id="google_review" placeholder="{{ __('Enter the google review url') }}"
                            class="form-control @error('google_review_url') is-invalid @enderror">
                    @error('google_review_url') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-ads btn-primary p-1">{{ __('Submit') }}</button>
        </form>

    </div> --}}
</div>
