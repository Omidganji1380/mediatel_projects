<div class="col-12 col-lg-11 m-auto">
    <div class="alert alert-success" role="alert"><i class="fas fa-check-circle m-1"></i>
        {{ __('messages.publish_ad_message') }}
    </div>
    <?php
    $showGateway = true;
    ?>
    @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">{!! $message !!}</div>
        <?php
        $showGateway = false;
        ?>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger" role="alert">{!! $message !!}</div>
        <?php
        $showGateway = true;
        ?>
    @endif


    @if ($showGateway)
        <div class="table-responsive  pt-3">
            <table class="table table-bordered">
                <thead class="">
                    <tr>
                        <th scope="col">{{ __('Name') }}</th>
                        <th scope="col">{{ __('Price') }}</th>
                        <th scope="col">{{ __('Description') }}</th>
                        <th scope="col">{{ __('Payment') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white">
                        <th scope="row"><i class="fas fa-star"></i>{{ __('Special Ad') }}</th>
                        <td>
                            {{ Money::USD($price, true) }}
                            <br>
                            @if ($discount?->percent)
                                {{ __('with') }}
                                {{ $discount?->percent }}% {{ __('Discount') }}
                            @endif
                            @if ($discount?->amount)
                                <br>{{ __('with') }}
                                <span dir="ltr">{{ Money::USD($discount?->amount, true) }}</span>
                                {{ __('Discount') }}
                                <br>
                            @endif
                            <br>
                            {{ __('Total') }}: <span
                                dir="ltr">{{ Money::USD($totalAmount, true) }}</span> <br>
                        </td>
                        <td>{{ __('This possibility is shown with a special label in addition to creating a distinctive ad.') }}
                        </td>
                        <td>
                            <button class="btn btn-success" wire:click.prevent="pay">پرداخت
                                <div wire:loading wire:target="pay" class="spinner-border text-secondary"
                                    role="status">
                                    <span class="visually-hidden">{{ __('Loading') }}...</span>
                                </div>
                            </button>
                        </td>
                    </tr>
                    <tr class="bg-white">
                        <td colspan="4">
                            <form action="" class="d-flex align-items-center justify-content-end">
                                <label for="" class="me-3">{{ __('Coupon') }}</label>
                                <input wire:model="discountCode" type="text" class="form-control m-0">
                                <button class="btn btn-primary m-0"
                                    wire:click.prevent="checkDiscount">{{ __('Submit') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
</div>
