<div>
    @if($promotions->count())
    <div class="row mb-4">
            @if($promotions->count() > 1)
            <button class="dashboard-carousel-control-prev carousel-control-prev prev d-none d-md-block" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="dashboard-carousel-control-next carousel-control-next next d-none d-md-block" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            @endif
            <div id="carouselExampleControls" class="carousel slide " data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($promotions as $key => $group)
                        <div class="carousel-item @if ($loop->first) active @endif">
                            <div class="row row-cols-1 row-cols-md-4 g-3 flex-nowrap flex-md-wrap">
                                @foreach ($group as $key => $promotion)
                                    <div class="col-xl-3 col-md-6 mb-4">
                                        <a href="{{ $promotion->url ?: "#" }}" class="text-{{ $promotion->text_color ?: "primary"}}">
                                            <div class="card border-left-primary shadow h-100 py-2 {{ $promotion->background_color ? "bg bg-" . $promotion->background_color : "" }}"
                                                @if ($promotion->getFirstMediaUrl('SpecialImage'))
                                                    style="
                                                        background-image: url('{!! str_replace('\\', '/', $promotion->getFirstMediaUrl('SpecialImage')) !!}');
                                                        background-size: cover; /* The image will cover the entire div */
                                                        background-repeat: no-repeat; /* Prevent the image from repeating */
                                                        background-position: center; /* Center the background image */"

                                                @endif
                                                    >
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div
                                                                class="text-xs font-weight-bold text-{{ $promotion->text_color ?: "text-primary"}} text-uppercase mb-1">
                                                                {{ $promotion->locale_name }}
                                                            </div>
                                                            {{-- <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                {{ $data['totalAdsView'] ?? 0 }}
                                                            </div> --}}
                                                        </div>
                                                        @if($promotion->icon)
                                                            <div class="col-auto">
                                                                <i class="{{ $promotion->icon }} {{ $promotion->text_color ?: "text-primary"}}"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    @endif
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{ __('Total Ads View') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['totalAdsView'] ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-eye fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                {{ __('Total Comments') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['totalAdsComments'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comment-alt-dots fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                {{ __('Total Scores') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['totalClaimedScores'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-star fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                {{ __('Total Service Used') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['serviceUsagesConfirmed'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            {!! $chart->container() !!}
        </div>
        <div class="col-md-6">
            {!! $reportSummery->container() !!}
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    {!! $chart->script() !!}
    {!! $reportSummery->script() !!}
    <script>
        // new Splide( '.splide', {
        //     // autoWidth: true,
        //     // omitEnd  : true,
        //     perPage: 4,
        //     gap: "2em",
        //     drag : 'free',
        //     // rewind: true,
        //     // pagination: false,
        //     arrows: false,
        //     breakpoints: {
        //         600: {
        //             perPage: 1
        //         },
        //     },
        // } ).mount();
    </script>
@endpush
