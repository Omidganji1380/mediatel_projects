<div class="section-title clearfix">
    <h2>{{ __('My Payments') }}</h2>
</div>
<div class="">
    <div class="container table-responsive  p-0 p-lg-4 pt-lg-0">
        <table class="table table-bordered">
            <thead class="">
                <tr>
                    <th scope="col">{{ __('Payment ID') }}</th>
                    <th scope="col">{{ __('Date') }}</th>
                    <th scope="col">{{ __('Expire') }}</th>
                    <th scope="col">{{ __('Status') }}</th>
                    <th scope="col">{{ __('Total') }}</th>
                    <th scope="col">{{ __('Plan') }}</th>
                    <th scope="col">{{ __('Description') }}</th>
                    {{--    <th scope="col">پرداخت</th> --}}
                </tr>
            </thead>
            <?php
            use Akaunting\Money\Money;
            ?>
            @php
                $customer = \App\Models\Shop\Customer::where('email', Auth::user()->email)->first();
            @endphp
            <tbody>
                @if($customer)
                    @php
                        $orders = \App\Models\Shop\Order::where('shop_customer_id', $customer->id)->with(['orderItem.plan', 'orderItem.ad'])->latest()->get();
                    @endphp
                    @foreach ($orders as $payment)
                        <tr class="bg-white">
                            <td class="text-center pt-3">
                                {{ $payment->number }}
                            </td>
                            <td class="text-center pt-3">
                                {{ date('Y-m-d', strtotime($payment->created_at)) }}
                            </td>
                            <td class="text-center pt-3">
                                @php
                                    $planPeriod = $payment->orderItem?->plan->convertDays();
                                    $expireDate = \Carbon\Carbon::parse($payment->created_at)->addDays($planPeriod);
                                @endphp
                                {{ date('Y-m-d', strtotime($expireDate)) }}
                            </td>
                            <td class="text-center pt-3">
                                @switch($payment->order_status)
                                    @case('COMPLETED')
                                        {{ __('messages.payments.statuses.COMPLETED') }}
                                    @break
                                    @case('CREATED')
                                        {{ __('messages.payments.statuses.CREATED') }}
                                    @break
                                @endswitch
                            </td>
                            <td class="text-center pt-3">
                                {{--         {{$price}} --}}
                                {!! Money::USD($payment->total_price, true) !!}
                            </td>
                            <td class="text-center pt3">
                                {{ $payment->orderItem?->plan?->name }} @if($payment->orderItem?->ad) - {{ $payment->orderItem?->ad->locale_title }} @endif
                            </td>
                            <td class="text-center pt-3">
                                {{-- @if ($payment->payable instanceof App\Models\Ad\Ad)
                                    @switch($payment?->extra?->ad?->name)
                                        @case('آگهی ویژه')
                                            <i class="fas fa-star"></i>
                                        @break

                                        @case('نردبان')
                                            <i class="fas fa-rocket"></i>
                                        @break

                                        @case('آگهی ویژه و نردبان')
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-rocket"></i>
                                        @break
                                    @endswitch
                                    {{ $payment?->extra?->ad?->name ?? '' }}

                                    <br>


                                    <a
                                        href="{{ route('front.ad.show', $payment->payable->slug) }}">{{ $payment->payable->title }}</a>
                                          در تاریخ
                                          {{jdate($payment->created_at)}}
                                @endif --}}
                            </td>
                            {{--    <td><button class="btn btn-success">پرداخت</button></td> --}}
                        </tr>
                    @endforeach
                @endif

                {{--   <tr class="bg-white"> --}}

                {{--    <td colspan="4"> --}}
                {{--     <form action="" class="d-flex align-items-center justify-content-end"> --}}
                {{--      <label for="" class="me-3">کد تخفیف</label> --}}
                {{--      <input type="text" class="form-control m-0"> --}}
                {{--      <button class="btn btn-primary m-0">اعمال</button> --}}
                {{--     </form> --}}
                {{--    </td> --}}
                {{--   </tr> --}}
            </tbody>
        </table>
    </div>
</div>
