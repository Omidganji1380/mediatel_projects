<div id="service_usage">
    <div class="section-title clearfix p-3 mt-4">
        <h2>{{ __('Used Service/Contract/Purchase Proof') }}</h2>
    </div>
    {{-- @dd($ad) --}}
    <form class="row g-3" wire:submit.prevent="upload">
        <div class="col-12" wire:ignore>
            <select class="form-select select2 w-100 @error('ad') is-invalid @enderror" wire:model="ad"
                aria-label="Default select example" id="ad_id">
                <option value="">-- Select an option --</option>
                @foreach ($ads as $ad)
                    <option value="{{ $ad->slug }}">{{ $ad->locale_title }}</option>
                @endforeach
            </select>
            @error('ad')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-floating">
            <textarea class="form-control @error('description') is-invalid @enderror" wire:model="description" placeholder=""
                id="floatingTextarea24" style="height: 200px !important"></textarea>
            @error('description')
                <span class=" text-danger">{{ $message }}</span>
            @enderror
            <label for="floatingTextarea24">{{ __('Description') }}</label>
        </div>
        <label for="floatingTextarea24">{{ __('Used Service/Contract/Purchase Proof') }}</label>
        <div class="input-group mb-3">
            <input type="file" wire:model="images"
                placeholder="{{ __('Send images of Used Service/Contract/Purchase Proof') }}"
                class="form-control @error('images') is-invalid @enderror" multiple>

            @if ($images)
                @foreach ($images as $image)
                    <img class="img-thumbnail" src="{{ $image }}" alt="">
                    @if ($image)
                        <span class="position-absolute top-0 start-100 translate-middle p-2   rounded-circle">
                            <i class="fa fa-trash" aria-hidden="true" wire:click="mediaDelete"></i>
                            <span class="visually-hidden">New alerts</span>
                        </span>
                    @endif
                @endforeach
            @endif
        </div>
        @error('images')
            <span class=" text-danger">{{ $message }}</span>
        @enderror
        <div class="spinner-border text-success" wire:loading wire:target="upload"></div>
        <!--  -->
        <!--  -->
        <div class="col-12">
            <button type="submit" class="btn btn-primary">{{ __('Submit') }}
            </button>
        </div>
    </form>
</div>

@push('scripts')
    <script>
        // document.addEventListener('livewire:load', function () {
        //     $('#ad_id').select2();
        // });
        $('.select2').select2({
            "id": "{{ $ad ?: '' }}"

        });
        $('#ad_id').on('change', function(e) {
            var data = $(this).val();
            @this.set('ad', data);
        });
        // @if ($ad->slug)
        //     $('.select2').val($ad->slug).trigger('change');
        // @endif
    </script>
@endpush
