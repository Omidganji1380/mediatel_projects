<div>
    <div class="container mt-5">
        <h2 class="text-center text-secondary p-3 m-2">{{ __('Invoice') }} <i
                class="fa-solid fa-cart-shopping text-info"></i></h2>

        <section class="listing-cards">
            <div class="row justify-content-center">

                @if ($cart)
                    @if($preview)
                        <div class="align-content-center g-0 justify-content-center row">
                            <div class="card mb-3 p-3 shadow col-md-8">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <table class="table table-borderless">
                                                {{-- <thead>
                                                    <tr>
                                                        <th scope="col">{{ __('Service Description') }}</th>
                                                        <th scope="col">{{ __('Details') }}</th>
                                                    </tr>
                                                </thead> --}}
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" class="p-3"><span class="font-weight-bold">{{ __("Persian Title") }} :</span> {{ $cart->advertisementOrder->title }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-3"><span class="font-weight-bold">{{ __("English Title") }} :</span> <span dir="ltr">{{ $cart->advertisementOrder->title_en }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-3"><span class="font-weight-bold">{{ __("Persian Description") }} :</span> {{ $cart->advertisementOrder->description_fa }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="p-3"><span class="font-weight-bold">{{ __("English Description") }} :</span> <span dir="ltr">{{ $cart->advertisementOrder->description_en }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-3"><span class="font-weight-bold">{{ __('Phone 1') }}:</span> <span dir="ltr">
                                                            {{ $cart->advertisementOrder->country_code . $cart->advertisementOrder->phone }}</span>
                                                        </td>
                                                        <td class="p-3">
                                                            <span class="font-weight-bold">{{ __('Email') }}:</span> <span dir="ltr">{{ $cart->advertisementOrder->email }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-3"><span class="font-weight-bold">{{ __('Phone 2') }}:</span> <span dir="ltr">
                                                            @if($cart->advertisementOrder->phone_2)
                                                                {{ $cart->advertisementOrder->country_code . $cart->advertisementOrder->phone_2 }}</span>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td class="p-3">
                                                            <span class="font-weight-bold">{{ __('Website') }}:</span> <span dir="ltr">{{ $cart->advertisementOrder->website ?: "-" }}</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3 p-3 shadow col-md-8">
                                <div class="card-body pb-0">
                                    <div class="row">
                                        <div class="col-md-12 d-flex flex-column">
                                            <h4 class="text-center border bg-info mb-0 p-1">{{ __('Preview Images') }}</h4>
                                            <div class="">
                                                <div class="row">
                                                    <div class="col-12 text-center mt-3 mb-2 text-capitalize"><h5>{{ __("Homepage preview image") }}</h5></div>
                                                    <div class="col-12 mb-2">
                                                        <img class="shadow p-2 w-100" src="{{ $cart->advertisementOrder->getFirstMediaUrl('HomeBGLargeFa') ?: asset('images/kiusk-placeholder.jpg') }}">
                                                    </div>
                                                    <div class="col-12 mb-2">
                                                        <img class="shadow p-2 w-100" src="{{ $cart->advertisementOrder->getFirstMediaUrl('HomeBGLargeEn') ?: asset('images/kiusk-placeholder.jpg') }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 text-center mt-3 mb-2 text-capitalize"><h5>{{ __("Between counter content preview image") }}</h5></div>
                                                    <div class="col-12 mb-2">
                                                        <img class="shadow p-2 w-100" src="{{ $cart->advertisementOrder->getFirstMediaUrl('BlogTextFa') ?: asset('images/kiusk-placeholder.jpg') }}">
                                                    </div>
                                                    <div class="col-12 mb-2">
                                                        <img class="shadow p-2 w-100" src="{{ $cart->advertisementOrder->getFirstMediaUrl('BlogTextEn') ?: asset('images/kiusk-placeholder.jpg') }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 text-center mt-3 mb-2 text-capitalize"><h5>{{ __("Counter sidebar preview image") }}</h5></div>
                                                    <div class="col-md-6 mb-2">
                                                        <img class="shadow p-2 w-100" src="{{ $cart->advertisementOrder->getFirstMediaUrl('BlogSidebarFa') ?: asset('images/kiusk-placeholder.jpg') }}">
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <img class="shadow p-2 w-100" src="{{ $cart->advertisementOrder->getFirstMediaUrl('BlogSidebarEn') ?: asset('images/kiusk-placeholder.jpg') }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 text-center mt-3 mb-2 text-capitalize"><h5>{{ __("Counter bottom preview image") }}</h5></div>
                                                    <div class="col-md-6 mb-2">
                                                        <img class="shadow p-2 w-100" src="{{ $cart->advertisementOrder->getFirstMediaUrl('BlogBottomFa') ?: asset('images/kiusk-placeholder.jpg') }}">
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <img class="shadow p-2 w-100" src="{{ $cart->advertisementOrder->getFirstMediaUrl('BlogBottomEn') ?: asset('images/kiusk-placeholder.jpg') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="align-items-center col-md-6 col-2 d-flex justify-content-center mt-2">
                                            <button class="btn btn-sm btn-ads w-100 me-2 p-2" wire:click="deleteItem({{$cart->id}})">
                                                {{ __('Cancel and remove') }}
                                            </button>
                                            <button class="btn btn-sm btn-ads w-100 p-2" wire:click.prevent="backToCart">{{ __('Back') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="paypal-button-container" class="text-center col-md-8 p-3 p-md-0"></div>
                        </div>
                    @else
                        <div class="align-content-center g-0 justify-content-center row">
                            <div class="card mb-3 p-3 shadow col-md-8">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <table class="table table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">{{ __('Service Description') }}</th>
                                                        <th scope="col">{{ __('Details') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="p-3">{{ $cart->title }}</td>
                                                        <td class="text-center p-3">
                                                            {{ trans_choice('messages.plans.intervals.day', $cart->invoice_period, ['count' => $cart->invoice_period]) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-3">{{ __('Price') }}</td>
                                                        <td class="text-center p-3">
                                                            <span dir="ltr">${{ $cart->price }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-3">{{ __('HST') }}</td>
                                                        <td class="text-center p-3">
                                                            {{ $cart->tax ?? "13" }}%
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <td class="p-3"></td>
                                                    <td class="text-center p-3">{{ __('Total Price') }} : <span class="font-weight-bold" dir="ltr">${{ $cart->total_price }}</span></td>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="col-md-4 d-flex flex-column">
                                            <h4 class="bg-light fs-5 mb-0 p-2 text-center">{{ __('Your Advertisement') }}</h4>
                                            <img src="{{ $cart->advertisementOrder->getFirstMediaUrl('BlogSidebarFa') ?: asset('images/kiusk-placeholder.jpg') }}" class="w-100" alt="">
                                            <button class="btn btn-info text-black" wire:click.prevent="preview">{{ __('Preview') }}</button>
                                            <p class="bg-light p-2 text-center">{{ $cart->advertisementOrder?->email }}</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12 mb-3">
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" wire:model="acceptRules" name="acceptRules" wire:change="toggleCheckbox"
                                                        id="flexCheckCheckedDisabled">
                                                        <label class="form-check-label" for="flexCheckCheckedDisabled">
                                                            {!! __('messages.accept_rules') !!}
                                                        </label>
                                                    </div>
                                                    @error('acceptRules')
                                                        <span class="error text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <p><span class="text-danger fs-4">{{ __('Very important') }}:</span>{{ __('The advertisement displayed on this page as well as the website may differ from what will be published on the website in terms of color, size and font.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="align-items-center col-md-4 col-2 d-flex justify-content-center">
                                            <button class="btn btn-sm btn-ads w-100 p-2" wire:click="deleteItem({{$cart->id}})">
                                                {{ __('Cancel and remove') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="paypal-button-container" class="text-center col-md-8 p-3 p-md-0"></div>
                        </div>
                    @endif
                @else
                    <div class="text-center m-5">
                        <i class="fa fa-shopping-cart text-info fa-3x p-4"></i>
                        <h5 class="text-secondary p-3">{{ __('Your cart is empty!') }}</h5>
                        <a href="{{ route('front.advertisement.index') }}"
                            class="btn btn-info text-white">{{ __('Back to plans') }}</a>
                    </div>
                @endif
            </div>
        </section>
    </div>
    @if ($cart)
        <script
            src="https://www.paypal.com/sdk/js?client-id={{ config('paypal.client_id') }}&currency=USD&intent=capture&enable-funding=venmo"
            data-sdk-integration-source="integrationbuilder"></script>
        @if ($acceptRules)
            <!-- Sample PayPal credentials (client-id) are included -->
            <script>
                @if (App::isLocale('fa'))
                    var redirectRoute = "{{ route('front.panel.user.ad-orders.index') }}"
                @else
                    var redirectRoute = "{{ route('en.front.panel.user.ad-orders.index') }}"
                @endif
                const paypalButtonsComponent = paypal.Buttons({
                    // optional styling for buttons
                    // https://developer.paypal.com/docs/checkout/standard/customize/buttons-style-guide/
                    style: {
                        color: "gold",
                        shape: "rect",
                        layout: "vertical"
                    },

                    // set up the transaction
                    createOrder: (data, actions) => {
                        return fetch('/pay/advertisement', {
                            method: 'POST',
                            headers: {
                                'content-type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                "advertisement_type_id": "{{ $cart->advertisement_type_id }}",
                                "advertisement_order_id": "{{ $cart->advertisement_order_id }}"
                            })
                        }).then(function(res) {
                            return res.json();
                        }).then(function(orderData) {
                            return orderData.id;
                        });
                        // pass in any options from the v2 orders create call:
                        // https://developer.paypal.com/api/orders/v2/#orders-create-request-body
                        // const createOrderPayload = {
                        //     purchase_units: [
                        //         {
                        //             amount: {
                        //                 value: "{{ $cart->price }}"
                        //             }
                        //         }
                        //     ]
                        // };

                        // return actions.order.create(createOrderPayload);
                    },

                    // finalize the transaction
                    onApprove: function(data, actions) {
                        return fetch('/capture/advertisement', {
                            method: 'post',
                            headers: {
                                Accept: 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                orderID: data.orderID,
                                advertisementTypeId: "{{ $cart->advertisement_type_id }}",
                            })
                        }).then(function(res) {
                            return res.json();
                        }).then(function(orderData) {
                            var errorDetails = Array.isArray(orderData.details) && orderData.details[0];

                            if (errorDetails && errorDetails.issu == 'INSTRUMENT_DECLINED') {
                                return actions.restart;
                            }

                            if (errorDetails) {
                                var msg = 'Sorry your transaction could not be proceed.';
                                if (errorDetails.description) msg += '\n\n' + errorDetails.description;
                                if (errorDetails.debug_id) msg += '(' + errorDetails.debug_id + ')';

                                return alert(msg);
                            }

                            console.log('Capture result ', orderData, JSON.stringify(orderData, null, 2));
                            var transaction = orderData.purchase_units[0].payments.captures[0];
                            console.log('Transaction ' + transaction.status + ': ' + transaction.id);
                            setTimeout(function(){document.location.href = "{{ route('front.panel.user.ad-orders.index') }}";},250);
                            // return orderData.id;
                        });
                    },

                    // handle unrecoverable errors
                    onError: (err) => {
                        console.error('An error prevented the buyer from checking out with PayPal');
                    }
                });

                paypalButtonsComponent
                    .render("#paypal-button-container")
                    .catch((err) => {
                        console.error('PayPal Buttons failed to render');
                    });
            </script>
        @endif
    @endif

</div>
