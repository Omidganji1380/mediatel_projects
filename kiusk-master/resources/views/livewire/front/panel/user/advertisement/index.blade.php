<div>
    <div class="section-title clearfix">
        <h2>{{ __('My Advertisements') }}</h2>
    </div>
    @php
        use Akaunting\Money\Money;
    @endphp
    <div class="container table-responsive  p-0 p-lg-4 pt-lg-0">
        <table class="table table-bordered">
            <thead class="">
                <tr>
                    {{-- <th scope="col">{{ __('Advertisement Type') }}</th> --}}
                    <th scope="col">{{ __('Date') }}</th>
                    <th scope="col">{{ __('Days') }}</th>
                    <th scope="col">{{ __('Status') }}</th>
                    <th scope="col">{{ __('Price') }}</th>
                    <th scope="col">{{ __('Description') }}</th>
                    <th scope="col">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach (App\Models\AdvertisementOrder::whereBelongsTo(Auth::user())->latest()->get() as $ad)
                    <tr class="bg-white">
                        {{-- <td class="text-center pt-4">{{ $ad->advertisementType?->name }}</td> --}}
                        <td class="text-center pt-4">
                            {{ date('Y-m-d', strtotime($ad->created_at)) }}
                        </td>
                        <td class="text-center pt-4">{{ $ad->days }} {{ __('Days') }}</td>
                        <td class="text-center pt-4">{{ __('messages.statuses.' . $ad->status) }}</td>
                        <td class="text-center pt-4">{!! Money::USD($ad->total_price, true) !!}</td>
                        <td class="text-center pt-4">{!! $ad->description !!}</td>
                        <td class="text-center pt-4">
                            <a href="{{ route('front.panel.user.ad-orders.show', $ad->id) }}" class="btn btn-ads">
                                {{ __('View') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
