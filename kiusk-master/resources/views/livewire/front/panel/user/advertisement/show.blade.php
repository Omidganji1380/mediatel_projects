<div>
    <div class="section-title clearfix">
        <h2>{{ $advertisementOrder->advertisementType?->name }}</h2>
    </div>
    @php
        use Akaunting\Money\Money;
    @endphp
    {{-- <button class="btn btn-primary p-2" wire:click="payment({{ $advertisementOrder->id }})">{{ __('Pay') }}</button> --}}

    <div class="container">
        {{-- <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-12 p-5">
                        <img src="{{ $advertisementOrder->advertisementType?->getFirstMediaUrl('image') }}" alt="" class="w-100">
                    </div>
                    <div class="col-md-6 col-12 p-5">
                        <div class="mb-3">
                            {{ __('Advertisement Type Price') }} :  <span dir="ltr">{{ Money::USD($advertisementOrder->advertisementType->price, true) }}</span>
                        </div>
                        <div>
                            {{ __('Description') }}:
                            <p>
                                {!! $advertisementOrder->advertisementType->description !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="card mt-4">
            <div class="card-body">
                <div class="p-5">
                    <div class="mb-3">
                        <span style="font-weight: bold">{{ __('Status') }} :</span>
                        <span
                            class="badge bg-{{ $advertisementOrder->status === 'payment_complete' ? 'success' : 'danger' }}">{{ __('messages.statuses.' . $advertisementOrder->status) }}</span>
                    </div>
                    <div class="mb-3"><span style="font-weight: bold">{{ __('First Name') }} :</span>
                        {{ $advertisementOrder->first_name }}</span></div>
                    <div class="mb-3"><span style="font-weight: bold">{{ __('Last Name') }} :</span>
                        {{ $advertisementOrder->last_name }}</div>
                    <div class="mb-3"><span style="font-weight: bold">{{ __('Email') }} :</span>
                        {{ $advertisementOrder->email }}</div>
                    <div class="mb-3"><span style="font-weight: bold">{{ __('Phone Number') }} :</span>
                        {{ $advertisementOrder->phone_with_code }}</div>
                    <div class="mb-3"><span style="font-weight: bold">{{ __('Phone Number') }} 2 :</span>
                        {{ $advertisementOrder->phone_2 ? '+1' . $advertisementOrder->phone_2 : '-' }}</div>
                    <div class="mb-3"><span style="font-weight: bold">{{ __('State') }}/ {{ __('City') }}
                            :</span> {{ $advertisementOrder->state->name }}/{{ $advertisementOrder->city->name }}
                    </div>
                    <div class="mb-3"><span style="font-weight: bold">{{ __('Days Count') }} :</span>
                        {{ $advertisementOrder->days }} {{ __('Days') }}</div>
                    <div class="mb-3"><span style="font-weight: bold">{{ __('Registered Date') }} :</span>
                        {{ $advertisementOrder->created_at }}</div>
                    <div class="mb-3"><span style="font-weight: bold">{{ __('Persian Title') }} :</span>
                        {{ $advertisementOrder->title }}</div>
                    <div class="mb-3"><span style="font-weight: bold">{{ __('English Title') }} :</span>
                        {{ $advertisementOrder->title_en }}</div>
                    <div class="mb-3"><span style="font-weight: bold">{{ __('Persian Description') }} :</span>
                        {{ $advertisementOrder->description_fa }}</div>
                    <div class="mb-3"><span style="font-weight: bold">{{ __('English Description') }} :</span>
                        {{ $advertisementOrder->description_en }}</div>
                    <hr>
                    <div class="mb-3"><span style="font-weight: bold">{{ __('Design') }}:</span> </div>
                    <div class="row">
                        <div class="col-md-12 d-flex flex-column">
                            <h4 class="text-center border bg-info mb-0 p-1">{{ __('Preview Images') }}</h4>
                            <div class="">
                                <div class="row">
                                    <div class="col-12 text-center mt-3 mb-2 text-capitalize">
                                        <h5>{{ __('Homepage preview image') }}</h5>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <img class="shadow p-2 w-100"
                                            src="{{ $advertisementOrder->getFirstMediaUrl('HomeBGLargeFa') ?: asset('images/kiusk-placeholder.jpg') }}">
                                    </div>
                                    <div class="col-12 mb-2">
                                        <img class="shadow p-2 w-100"
                                            src="{{ $advertisementOrder->getFirstMediaUrl('HomeBGLargeEn') ?: asset('images/kiusk-placeholder.jpg') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center mt-3 mb-2 text-capitalize">
                                        <h5>{{ __('Between counter content preview image') }}</h5>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <img class="shadow p-2 w-100"
                                            src="{{ $advertisementOrder->getFirstMediaUrl('BlogTextFa') ?: asset('images/kiusk-placeholder.jpg') }}">
                                    </div>
                                    <div class="col-12 mb-2">
                                        <img class="shadow p-2 w-100"
                                            src="{{ $advertisementOrder->getFirstMediaUrl('BlogTextEn') ?: asset('images/kiusk-placeholder.jpg') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center mt-3 mb-2 text-capitalize">
                                        <h5>{{ __('Counter sidebar preview image') }}</h5>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <img class="shadow p-2 w-100"
                                            src="{{ $advertisementOrder->getFirstMediaUrl('BlogSidebarFa') ?: asset('images/kiusk-placeholder.jpg') }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <img class="shadow p-2 w-100"
                                            src="{{ $advertisementOrder->getFirstMediaUrl('BlogSidebarEn') ?: asset('images/kiusk-placeholder.jpg') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center mt-3 mb-2 text-capitalize">
                                        <h5>{{ __('Counter bottom preview image') }}</h5>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <img class="shadow p-2 w-100"
                                            src="{{ $advertisementOrder->getFirstMediaUrl('BlogBottomFa') ?: asset('images/kiusk-placeholder.jpg') }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <img class="shadow p-2 w-100"
                                            src="{{ $advertisementOrder->getFirstMediaUrl('BlogBottomEn') ?: asset('images/kiusk-placeholder.jpg') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($advertisementOrder->status == 'pending_payment')
                <div class="card-footer bg-transparent">
                    <div>
                        <button class="btn btn-primary p-2" wire:click="pay()">{{ __('Pay') }}</button>
                    </div>
                </div>
            @endif
        </div>

    </div>

</div>
