<x-forms::field-wrapper :id="$getId()" :label="$getLabel()" :label-sr-only="$isLabelHidden()" :helper-text="$getHelperText()" :hint="$getHint()"
    :required="$isRequired()" :state-path="$getStatePath()">
    {{-- <div wire:ignore x-data="{state: $wire.entangle('{{ $getStatePath() }}'),}"> --}}
        {{-- <input  /> --}}

        {{-- @dd($getStatePath()) --}}
        <textarea wire:ignore id="editor2" x-model.debounce.50000ms="state" wire:model.defer="{{ $getStatePath() }}"></textarea>
    </div>
</x-forms::field-wrapper>
@push('scripts')
    <script src="{{ asset('js/lodash.min.js') }}"></script>
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/translations/fa.js"></script>
    {{-- <script src="{{asset('js/jquery.min.js')}}"></script> --}}
    <script !src="">
        class MyUploadAdapter {
            constructor(loader) {
                // The file loader instance to use during the upload.
                this.loader = loader;
            }

            // Starts the upload process.
            upload() {
                return this.loader.file
                    .then(file => new Promise((resolve, reject) => {
                        this._initRequest();
                        this._initListeners(resolve, reject, file);
                        this._sendRequest(file);
                    }));
            }

            // Aborts the upload process.
            abort() {
                if (this.xhr) {
                    this.xhr.abort();
                }
            }

            // Initializes the XMLHttpRequest object using the URL passed to the constructor.
            _initRequest() {
                const xhr = this.xhr = new XMLHttpRequest();
                // Note that your request may look different. It is up to you and your editor
                // integration to choose the right communication channel. This example uses
                // a POST request with JSON as a data structure but your configuration
                // could be different.
                xhr.open('POST', '{{ route('admin.ckeditor.upload') }}', true);
                xhr.setRequestHeader('x-csrf-token', '{{ csrf_token() }}');
                xhr.responseType = 'json';
            }

            // Initializes XMLHttpRequest listeners.
            _initListeners(resolve, reject, file) {
                const xhr = this.xhr;
                const loader = this.loader;
                const genericErrorText = `Couldn't upload file: ${file.name}.`;
                xhr.addEventListener('error', () => reject(genericErrorText));
                xhr.addEventListener('abort', () => reject());
                xhr.addEventListener('load', () => {
                    const response = xhr.response;
                    // This example assumes the XHR server's "response" object will come with
                    // an "error" which has its own "message" that can be passed to reject()
                    // in the upload promise.
                    //
                    // Your integration may handle upload errors in a different way so make sure
                    // it is done properly. The reject() function must be called when the upload fails.
                    if (!response || response.error) {
                        return reject(response && response.error ?
                            response.error.message :
                            genericErrorText);
                    }
                    // If the upload is successful, resolve the upload promise with an object containing
                    // at least the "default" URL, pointing to the image on the server.
                    // This URL will be used to display the image in the content. Learn more in the
                    // UploadAdapter#upload documentation.
                    resolve({
                        default: response.url,
                    });
                });
                // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
                // properties which are used e.g. to display the upload progress bar in the editor
                // user interface.
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', evt => {
                        if (evt.lengthComputable) {
                            loader.uploadTotal = evt.total;
                            loader.uploaded = evt.loaded;
                        }
                    });
                }
            }

            // Prepares the data and sends the request.
            _sendRequest(file) {
                // Prepare the form data.
                const data = new FormData();
                data.append('upload', file);
                data.append('model_id', @this.get('data.id'));
                data.append('model_type', '{{ addslashes($this->getModel()) }}');
                // Important note: This is the right place to implement security mechanisms
                // like authentication and CSRF protection. For instance, you can use
                // XMLHttpRequest.setRequestHeader() to set the request headers containing
                // the CSRF token generated earlier by your application.
                // Send the request.
                this.xhr.send(data);
            }
        }

        // ...
        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                // Configure the URL to the upload script in your back-end here!
                return new MyUploadAdapter(loader);
            };
        }

        ClassicEditor
            .create(document.querySelector('#editor2'), {
                extraPlugins: [MyCustomUploadAdapterPlugin],
                language: 'fa',
            })
            .then(editor => {
                editor.model.document.on('change:data', _.debounce(() => {
                    @this.
                    set('{{ $getStatePath() }}', editor.getData());
                }, 500, {
                    'maxWait': 5000
                }))
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
