<div class="container mt-5">
    <h2 class="text-center text-secondary p-3 m-2">{{ __('Invoice') }} <i class="fa-solid fa-cart-shopping text-info"></i>
    </h2>

    <section class="listing-cards">
        <div class="row justify-content-center">

            @if ($cart)
                <div class="align-content-center g-0 justify-content-center row">
                    <div class="card mb-3 p-3 shadow col-md-8">
                        <div class="card-body">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('Service Description') }}</th>
                                        <th scope="col-1" style="width: 25%">{{ __('Plan') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $cart->ad?->locale_title }}</td>
                                        <td>
                                            {{ $cart->plan->name }}
                                            {{ trans_choice('messages.plans.intervals.' . $cart->plan->invoice_interval, $cart->plan->invoice_period, ['count' => $cart->plan->invoice_period]) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        {{-- <td>{!! $cart->plan?->locale_description !!}</td> --}}
                                        <td>
                                            <ol>
                                                @if ($cart->plan->show_in_main_page)
                                                    <li
                                                        class="list-group-item bg-transparent border-0 mb-2 fs-small {{ $cart->plan->show_in_main_page ? '' : 'text-danger' }}">
                                                        <i
                                                            class="fa fa-{{ $cart->plan->show_in_main_page ? 'check' : 'times-circle' }}"></i>
                                                        {{ $cart->plan->vip ? __('messages.plans.vip_show_in_main_page', ['count' => $cart->plan->featured_limit]) : __('messages.plans.show_in_main_page') }}
                                                    </li>
                                                @endif
                                                @if ($cart->plan->show_in_sidebar)
                                                    <li
                                                        class="list-group-item bg-transparent border-0 mb-2 fs-small {{ $cart->plan->show_in_sidebar ? '' : 'text-danger' }}">
                                                        <i
                                                            class="fa fa-{{ $cart->plan->show_in_sidebar ? 'check' : 'times-circle' }}"></i>
                                                        {{ __('messages.plans.show_in_sidebar') }}
                                                    </li>
                                                @endif
                                                @if ($cart->plan->show_in_suggestion)
                                                    <li
                                                        class="list-group-item bg-transparent border-0 mb-2 fs-small {{ $cart->plan->show_in_suggestion ? '' : 'text-danger' }}">
                                                        <i
                                                            class="fa fa-{{ $cart->plan->show_in_suggestion ? 'check' : 'times-circle' }}"></i>
                                                        {{ __('messages.plans.show_in_suggestion') }}
                                                    </li>
                                                @endif
                                                @if ($cart->plan->pin_ad)
                                                    <li
                                                        class="list-group-item bg-transparent border-0 mb-2 fs-small {{ $cart->plan->pin_ad ? '' : 'text-danger' }}">
                                                        <i
                                                            class="fa fa-{{ $cart->plan->pin_ad ? 'check' : 'times-circle' }}"></i>
                                                        {{ __('messages.plans.pin_ad') }}
                                                    </li>
                                                    <li
                                                        class="list-group-item bg-transparent border-0 mb-2 fs-small {{ $cart->plan->pin_ad ? '' : 'text-danger' }}">
                                                        <i
                                                            class="fa fa-{{ $cart->plan->pin_ad ? 'check' : 'times-circle' }}"></i>
                                                        {{ __('messages.plans.story') }}
                                                    </li>
                                                    <li
                                                        class="list-group-item bg-transparent border-0 mb-2 fs-small {{ $cart->plan->pin_ad ? '' : 'text-danger' }}">
                                                        <i
                                                            class="fa fa-{{ $cart->plan->pin_ad ? 'check' : 'times-circle' }}"></i>
                                                        {{ __('messages.plans.motion_story') }}
                                                    </li>
                                                @endif
                                                @if ($cart->plan->telegram_channel)
                                                    <li
                                                        class="list-group-item bg-transparent border-0 mb-2 fs-small {{ $cart->plan->telegram_channel ? '' : 'text-danger' }}">
                                                        <i
                                                            class="fa fa-{{ $cart->plan->telegram_channel ? 'check' : 'times-circle' }}"></i>
                                                        {{ __('messages.plans.telegram_channel') }}
                                                    </li>
                                                @endif
                                                @if ($cart->plan->free_blog_ad)
                                                    <li
                                                        class="list-group-item bg-transparent border-0 mb-2 fs-small {{ $cart->plan->free_blog_ad ? '' : 'text-danger' }}">
                                                        <i
                                                            class="fa fa-{{ $cart->plan->free_blog_ad ? 'check' : 'times-circle' }}"></i>
                                                        {{ __('messages.plans.free_blog_ad') }}
                                                    </li>
                                                @endif
                                                @if ($cart->plan->narration)
                                                    <li
                                                        class="list-group-item bg-transparent border-0 mb-2 fs-small {{ $cart->plan->narration ? '' : 'text-danger' }}">
                                                        <i
                                                            class="fa fa-{{ $cart->plan->narration ? 'check' : 'times-circle' }}"></i>
                                                        {!! __('messages.plans.narration') !!}
                                                    </li>
                                                @endif
                                                @if ($cart->plan->email_notification)
                                                    <li class="list-group-item bg-transparent border-0 mb-2 fs-small">
                                                        <i class="fa fa-check"></i>
                                                        {{ __('Notification of ads through promotional email') }}
                                                    </li>
                                                @endif
                                                @if ($cart->plan->sms_notification)
                                                    <li class="list-group-item bg-transparent border-0 mb-2 fs-small">
                                                        <i class="fa fa-check"></i>
                                                        {{ __('Notification of ads through promotional SMS') }} <span
                                                            class="badge bg-danger">{{ __('New') }}</span>
                                                    </li>
                                                @endif
                                            </ol>
                                        </td>
                                        <td>
                                            {{ __('Price') }} : <span dir="ltr">${{ $cart->price }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            {{ __('HST') }} : {{ $cart->tax ?? '13' }}%
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <td></td>
                                    <td>{{ __('Total Price') }} : <span class="font-weight-bold"
                                            dir="ltr">${{ $cart->total_price }}</span></td>
                                </tfoot>
                            </table>
                            <div class="d-flex justify-content-end row">
                                <div
                                    class="align-items-center col-md-1 col-2 d-flex flex-column justify-content-center">
                                    <button class="btn btn-sm btn-danger w-100 p-2"
                                        wire:click="deleteItem({{ $cart->id }})">
                                        <i class="fa fa-trash fa-1x"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="paypal-button-container" class="text-center col-md-8 p-3 p-md-0"></div>
                </div>
                {{-- <div class="card mb-3 p-3 shadow col-md-8">
                    <div class="row g-0">
                        <div class="align-items-center col-md-2 col-2 d-flex flex-column justify-content-center">
                            <p>{{ $cart->ad->locale_title }}</p>

                        </div>
                        <div class="align-items-center col d-flex justify-content-center">
                            <p class="card-text fs-6 p-2">{{ $cart->plan->description }}</p>
                        </div>
                        <div class="align-items-center col-md-2 col-2 d-flex flex-column justify-content-center p-2 p-md-4">
                            <p class="text-black">{{ $cart->plan->name }}</p>
                            <h5 class="card-title">${{ $cart->price }}</h5>
                            <div class="text-secondary text-120">
                                {{ trans_choice('messages.plans.intervals.' . $cart->plan->invoice_interval, $cart->plan->invoice_period) }}
                            </div>
                        </div>

                    </div> --}}
            @else
                <div class="text-center m-5">
                    <i class="fa fa-shopping-cart text-info fa-3x p-4"></i>
                    <h5 class="text-secondary p-3">{{ __('Your cart is empty!') }}</h5>
                    <a href="{{ route('front.panel.user.ad.index') }}"
                        class="btn btn-info text-white">{{ __('Back to ads') }}</a>
                </div>
            @endif
        </div>
    </section>
</div>
@if ($cart)
    @php
        $clientId = env('PAYPAL_SANDBOX_CLIENT_ID', s()->PAYPAL_CLIENT_ID);
        $currency = 'USD';
        $telegramAdId = $cart->model_type === 'App\Models\TelegramAd' ? $cart->model_id : null;
        $adId = $cart->model_type === 'App\Models\Ad\Ad' ? $cart->ad_id : $cart->model_id;
    @endphp

    {{-- <script src="https://www.paypal.com/sdk/js?client-id={{ $clientId }}&currency={{ $currency }}&intent=capture" data-sdk-integration-source="integrationbuilder"></script>
</script> --}}

    <script
        src="https://www.paypal.com/sdk/js?client-id={{ $clientId }}&currency={{ $currency }}&intent=capture&enable-funding=venmo"
        data-sdk-integration-source="integrationbuilder"></script>

    <script>
        // Render the PayPal button into #paypal-button-container
        paypal.Buttons({
            // Call your server to set up the transaction
            createOrder: function(data, actions) {
                return fetch("{{ route('create.order') }}", {
                    method: 'POST',
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        cart_id: "{{ $cart->id }}",
                        plan_id: "{{ $cart->plan_id }}",
                        ad_id: "{{ $adId }}",
                        telegram_ad_id: "{{ $telegramAdId }}",
                        price: "{{ $cart->total_price }}"
                    })
                }).then(function(res) {
                    //res.json();
                    return res.json();
                }).then(function(orderData) {
                    console.log(orderData);
                    return orderData.id;
                });
            },

            // Call your server to finalize the transaction
            onApprove: function(data, actions) {
                return fetch("{{ route('payment.success') }}", {
                    method: 'POST',
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        orderId: data.orderID,
                        user_id: "{{ auth()->user()->id }}",
                    })
                }).then(function(res) {
                    // console.log(res.json());
                    return res.json();
                }).then(function(orderData) {

                    if (orderData.lang && orderData.lang !== null) {
                        setTimeout(function(){document.location.href = orderData.lang + "/my-account/orders";},250);
                    }else{
                        setTimeout(function(){document.location.href = "/my-account/orders";},250);
                    }
                });
            }

        }).render('#paypal-button-container');
    </script>
@endif
@if (false)
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return fetch("{{ route('create.order') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        cart_id: "{{ $cart->id }}",
                        plan_id: "{{ $cart->plan_id }}",
                        ad_id: "{{ $cart->ad_id }}",
                        price: "{{ $cart->total_price }}"
                    })
                }).then(function(response) {
                    return response.json();
                }).then(function(order) {
                    return order.id;
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Handle successful payment approval
                    setTimeout(function(){document.location.href = "{{ route('payment.success') }}?orderID=" + data.orderID;},250);
                });
            },
            onCancel: function(data) {
                // Handle payment cancellation
                setTimeout(function(){document.location.href = "{{ route('payment.cancel') }}";},250);
            }
        }).render('#paypal-button-container');
    </script>
    <!-- Sample PayPal credentials (client-id) are included -->
    {{-- <script src="https://www.paypal.com/sdk/js?client-id=AWrdrr8jOjGEO-UAgcV2IY1X-CLOXPjr3Dj13SNg9xrKEOTn9CtG_yVZE7zfU0hZOf7krdAkcyW8diCC&currency=USD&intent=capture&enable-funding=venmo"
        data-sdk-integration-source="integrationbuilder"></script> --}}
    <script>
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
                return fetch('/pay', {
                    method: 'POST',
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        "plan_id": "{{ $cart->plan_id }}",
                        "ad_id": "{{ $cart->ad_id }}",
                        "current_role": "{{ auth()->user()?->getRoleNames()?->first() }}"
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
                return fetch('/capture', {
                    method: 'post',
                    headers: {
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        orderID: data.orderID,
                        planId: "{{ $cart->plan_id }}",
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
                    setTimeout(function(){document.location.href = "{{ route('front.panel.user.payment.index') }}";},250);
                    // return orderData.id;
                });
            },
            // onApprove: (data, actions) => {
            //     const captureOrderHandler = (details) => {
            //         // const payerName = details.payer.name.given_name;
            //         // console.log('Transaction completed');
            //         const responsePromise = fetch('/paypal/order/capture', {
            //             method: 'post',
            //             headers: {
            //                 Accept: 'application/json',
            //                 'X-CSRF-TOKEN': "{{ csrf_token() }}"
            //             },
            //             body: JSON.stringify({
            //                 orderID: data.orderID,
            //                 planId: "{{ $cart->plan_id }}",
            //             })
            //         });
            //         responsePromise.then(function (responseFromServer) {
            //             console.log(responseFromServer);
            //             // if(responseFromServer.status === 200) {
            //             //     location.href = 'success_page';
            //             // } else {
            //             //     alert('smth went wrong');
            //             //     location.href = '/something-wrong';
            //             // }
            //         });
            //     };

            //     return actions.order.capture().then(captureOrderHandler);
            // },

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
