<x-forms::field-wrapper :id="$getId()"
                        :label="$getLabel()"
                        :label-sr-only="$isLabelHidden()"
                        :helper-text="$getHelperText()"
                        :hint="$getHint()"
                        :required="$isRequired()"
                        :state-path="$getStatePath()">
 <div wire:ignore
      x-data="{
            color: $wire.entangle('{{ $getStatePath() }}'),
            picker: undefined,
            init() {
                window.addEventListener('filament-color-picker:init', () => {
                    this.picker = window.FilamentColorPicker.make($wire, {
                        parent: document.getElementById('filament-color-picker'),
                        ...{{ Js::from($getPickerOptions()) }},
                    });
                });
            },
        }">
  <div id="filament-color-picker">
   <input type="text"
          x-model="color"
          class="block w-full placeholder-gray-400 focus:placeholder-gray-500 placeholder-opacity-100 rounded-md focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
          style="{{ $isPopupEnabled() ? '' : 'margin-bottom: 0.75rem' }}"
          readonly="{{ $isPopupEnabled() ? '' : 'readonly' }}"
          data-color-picker-field/>
  </div>
 </div>
</x-forms::field-wrapper>
@push('scripts')

 {{-- <script src="https://unpkg.com/vanilla-picker@2"></script>--}}
 <script src="{{asset('js/dist/filament-colorpicker.js')}}"></script>
 {{-- <script src="{{asset('js/colorpicker.js')}}"></script>--}}
@endpush
