{{--<x-forms::field-wrapper :id="$getId()"--}}{{--                        :label="$getLabel()"--}}{{--                        :label-sr-only="$isLabelHidden()"--}}{{--                        :helper-text="$getHelperText()"--}}{{--                        :hint="$getHint()"--}}{{--                        :required="$isRequired()"--}}{{--                        :state-path="$getStatePath()">--}}{{-- <div wire:ignore--}}{{--      x-data="{--}}{{--     state: $wire.entangle('{{ $getStatePath() }}') ,--}}{{--                }">--}}{{--<span x-text="state">ddd</span>--}}{{--<span >ddd</span>--}}{{-- </div>--}}{{--</x-forms::field-wrapper>--}}

@push('scripts')

 {{-- <script !src="">--}}
 {{--   function copyKeyword(id) {--}}
 {{--     /* Get the text field */--}}
 {{--     var copyText = document.getElementById(id);--}}

 {{--     /* Select the text field */--}}
 {{--     copyText.select();--}}
 {{--     copyText.setSelectionRange(0, 99999); /* For mobile devices */--}}

 {{--     /* Copy the text inside the text field */--}}
 {{--     navigator.clipboard.writeText(copyText.value);--}}

 {{--     /* Alert the copied text */--}}
 {{--     alert("Copied the text: " + copyText.value);--}}
 {{--   }--}}

 {{-- </script>--}}
@endpush
