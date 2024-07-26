<div>
    <div class="section-title clearfix p-3 mt-4">
        <h2>{{ __('Upload Video') }}</h2>
    </div>
    <form wire:submit.prevent="upload">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3"
                {{-- x-data="{ isUploading: false, progress: 0 }"
                x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false"
                x-on:livewire-upload-error="isUploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress" --}}
                >
                    <input type="file" wire:model="video" id="upload_custom" placeholder="{{ __('Upload video') }}"
                        class="upload_hide form-control">
                    {{-- class="form-control @error('video') is-invalid @enderror"> --}}
                    <label for="upload_custom" class="upload_label">
                        {{-- <div class="video">
                            <video src=""></video>
                        </div> --}}
                        {{-- <i class="fa fa-cloud-upload-alt"></i>
                        <p class="drag-text">Drag & Drop to Upload File</p>
                        <button class="choose_file">Choose a File</button> --}}
                    </label>
                    {{-- <button class="delete_file"> Delete File</button> --}}
                </div>
                <div class="">
                    {{-- <div x-show="isUploading">
                        <progress max="100" x-bind:value="progress"></progress>
                    </div> --}}

                    {{-- <div class="progress-bar rounded" role="progressbar" aria-label="Example with label" :style="width: `${progress}`%;"
                        aria-valuenow="`${progress}`" aria-valuemin="0" aria-valuemax="100">0%</div> --}}
                </div>
                @error('video')
                    <span class="error">{{ $message }}</span>
                @enderror
                <div id="spinner" wire:loading>
                    <img src="{{ asset('images/ajax-loader.gif') }}"/>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-ads btn-primary p-1">{{ __('Upload Video') }}</button>
        </div>
    </form>


    @if ($videos)
        <div class="card mt-3">
            <div class="row">
                @foreach ($videos as $video)
                    <div class="col-md-4 col-12 p-3 position-relative text-center">
                        <video width="220" height="220" class="user-video px-3 p-md-0" controls>
                            <source src="{{ $video->getFirstMediaUrl('video') }}" type="video/mp4">
                        </video>

                        <i class="video-status-icon fa
                            fa-{{ $video->is_confirmed ? "check-circle text-success" : "times-circle text-danger" }}
                            fa-2x"
                            title="{{ $video->is_confirmed ? __("messages.confirmed") : __("messages.not_confirmed") }}">
                        </i>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // $('#upload_custom').change(function() {
            //     let tmppath = URL.createObjectURL(event.target.files[0])
            //     $('.video > video').fadeIn('fast').attr('src', tmppath)
            // $('.delete_file').show();
            // $('.choose_file').hide();

            // $('.delete_file').click(function() {
            //     $('.image > img').fadeIn('fast').attr('src', '')
            //     $('.delete_file').hide();
            // })
            // });
        });
    </script>
@endpush
