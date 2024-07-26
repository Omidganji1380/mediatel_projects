<script src="https://js.pusher.com/7.2.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@3.0.3/dist/index.min.js"></script>
<script>
    // Gloabl Chatify variables from PHP to JS
    window.chatify = {
        name: "{{ config('chatify.name') }}",
        sounds: {!! json_encode(config('chatify.sounds')) !!},
        allowedImages: {!! json_encode(config('chatify.attachments.allowed_images')) !!},
        allowedFiles: {!! json_encode(config('chatify.attachments.allowed_files')) !!},
        maxUploadSize: {{ Chatify::getMaxUploadSize() }},
        pusher: {!! json_encode(config('chatify.pusher')) !!},
        pusherAuthEndpoint: '{{ route('pusher.auth') }}'
    };
    window.chatify.allAllowedExtensions = chatify.allowedImages.concat(chatify.allowedFiles);
    // Detect language on input event
    document.getElementById('myTextarea').addEventListener('input', function() {
        var text = this.value;
        var direction = detectTextDirection(text);
        this.style.direction = direction;
    });

    // Function to detect text direction based on language
    function detectTextDirection(text) {
        // Regular expressions to check if the text contains Arabic/Farsi or English characters
        var arabicFarsiRegex = /[\u0600-\u06FF\u0750-\u077F]/;
        var englishRegex = /[A-Za-z]/;

        // Check if the text contains Arabic/Farsi characters
        if (arabicFarsiRegex.test(text)) {
            return 'rtl'; // Set direction to RTL
        }

        // Check if the text contains English characters
        if (englishRegex.test(text)) {
            return 'ltr'; // Set direction to LTR
        }

        // Default to LTR direction if no characters detected
        return 'ltr';
    }
</script>
<script src="{{ asset('js/chatify/utils.js') }}"></script>
<script src="{{ asset('js/chatify/code.js') }}"></script>
