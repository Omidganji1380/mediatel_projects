<x-filament::page>
@php
    $isFa = App::isLocale('fa');
    $positionBackground =  $isFa ? "background-position: left 0.75rem center;" :  "background-position: right 0.75rem center;"
@endphp

<section class="parent-section">
    @foreach ($parentTickets as $item)
        <div class="border card flex flex-column mx-10 p-4 rounded-2xl bg-primary-200 mb-3
                    {{ $item->user->rule == 'admin' ? "rtl:flex-row-reverse" : "" }}">
            <div class="card-details">
                <div class="user-block">
                    {{-- <img class="img-circle img-bordered-sm" src="{{ asset($item->user->image->src ?? 'front/assets/images/default-avatar.png') }}" alt="user image"> --}}
                    <span class="font-bold">
                        <a href="#">{{ $item->user->name }}</a>
                    </span>
                    <span class="font-mono text-primary-700">{{ $item->created_at }}</span>
                </div>
                <p class="p-3">{!! $item->message !!}</p>
            </div>
        </div>
    @endforeach
</section>


<form wire:submit.prevent="reply">
    {{ $this->form }}
    <button class="flex items-center justify-center w-full h-8 px-3 text-sm outline-1 outline-sky-800 bg-success-500 rounded mt-4" type="submit">{{ __('Submit') }}</button>
</form>

</x-filament::page>
