<div>
    <div class="card border-0">
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-center">
                    <h4 class="card-title">{{ __('Scores') }}</h4>
                    <p class="card-text">{{ __('messages.scores.description') }}</p>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="" class="col-12 col-md-3 text-start">{{ __('Total Scores') }}:</label>
                            <div class="col-12 col-md-9 text-start">
                                <div class="font-weight-bold">{{ $user->total_claimed_scores_sum_score ?? 0 }}</div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for=""
                                class="col-12 col-md-3 text-start">{{ __('Total Used Scores') }}:</label>
                            <div class="col-12 col-md-9 text-start">
                                <div class="font-weight-bold">{{ $user->total_spent_scores_sum_score ?? 0 }}</div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for=""
                                class="col-12 col-md-3 text-start">{{ __('Total Pending Scores') }}: <i class="fa fa-question text-info" title="{{ __("messages.scores.unclaimed_scores_description") }}"></i></label>
                            <div class="col-12 col-md-9 text-start">
                                <div class="font-weight-bold">{{ $user->total_not_claimed_scores_sum_score ?? 0 }}</div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for=""
                                class="col-12 col-md-3 text-start">{{ __('Complete Profile') }}:</label>
                            <div class="col-12 col-md-9 text-start">
                                @if($user->registration_scores_sum_score)
                                    <div class="progress-bar bg-success rounded" role="progressbar"
                                        style="width: {{ $user->registration_scores_sum_score ? 100 : 0 }}%; height:1em;"
                                        aria-valuenow="{{ $user->registration_scores_sum_score ?? 0 }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ $user->registration_scores_sum_score ?? 0 }}</div>
                                @else
                                    <span class="">0</span>
                                @endif
                            </div>
                            {{-- <div class="col-12 col-md-9">
                                <div class="progress-bar bg-success rounded" role="progressbar"
                                    style="width: {{ $registrationProgress }}%; height:1em;"
                                    aria-valuenow="{{ $registrationProgress }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $registrationProgress }}%</div>
                            </div> --}}
                        </div>
                        <div class="mb-3 row">
                            <label for=""
                                class="col-12 col-md-3 text-start">{{ __('Blog/Ad Review') }}:</label>
                            <div class="col-12 col-md-9 text-start">
                                @if($user->comment_review_scores_sum_score)
                                <div class="progress-bar rounded" role="progressbar"
                                    style="width: {{ scorePercentageCalculate($user->comment_review_scores_sum_score, 'comment_review') }}%; height:1em;"
                                    aria-valuenow="{{ scorePercentageCalculate($user->comment_review_scores_sum_score, 'comment_review') }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                    {{ $user->comment_review_scores_sum_score ?? 0 }}</div>
                                    @else
                                        <span>0</span>
                                    @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-12 col-md-3 text-start">{{ __('Ad Rating') }}:</label>
                            <div class="col-12 col-md-9 text-start">
                                @if($user->rate_scores_sum_score)
                                <div class="progress-bar bg-info rounded" role="progressbar"
                                    style="width: {{ scorePercentageCalculate($user->rate_scores_sum_score, 'rate') }}%; height:1em;"
                                    aria-valuenow="{{ scorePercentageCalculate($user->rate_scores_sum_score, 'rate') }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                    {{ $user->rate_scores_sum_score ?? 0 }}</div>
                                    @else
                                        <span>0</span>
                                    @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-12 col-md-3 text-start">{{ __('Google Review') }}:</label>
                            <div class="col-12 col-md-9 text-start">
                                @if($user->google_review_scores_sum_score)
                                <div class="progress-bar bg-warning rounded" role="progressbar"
                                    style="width: {{ scorePercentageCalculate($user->google_review_scores_sum_score, 'google_review') }}%; height:1em;"
                                    aria-valuenow="{{ scorePercentageCalculate($user->google_review_scores_sum_score, 'google_review') }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                    {{ $user->google_review_scores_sum_score ?? 0 }}</div>
                                    @else
                                        <span>0</span>
                                    @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-12 col-md-3 text-start">{{ __('Upload Video') }}:</label>
                            <div class="col-12 col-md-9 text-start">
                                @if($user->send_video_scores_sum_score)
                                <div class="progress-bar bg-danger rounded" role="progressbar"
                                    style="width: {{ scorePercentageCalculate($user->send_video_scores_sum_score, 'send_video') }}%; height:1em;"
                                    aria-valuenow="{{ scorePercentageCalculate($user->send_video_scores_sum_score, 'send_video') }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                    {{ $user->send_video_scores_sum_score ?? 0 }}</div>
                                    @else
                                        <span>0</span>
                                    @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-12 col-md-3 text-start">{{ __('Use Services') }}:</label>
                            <div class="col-12 col-md-9 text-start">
                                @if($user->service_usage_scores_sum_score)
                                <div class="progress-bar bg-success rounded" role="progressbar"
                                    style="width: {{ scorePercentageCalculate($user->service_usage_scores_sum_score, 'service_usage') }}%; height:1em;"
                                    aria-valuenow="{{ scorePercentageCalculate($user->service_usage_scores_sum_score, 'service_usage') }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                    {{ $user->service_usage_scores_sum_score ?? 0 }}</div>
                                    @else
                                        <span>0</span>
                                    @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="" class="col-12 col-md-3 text-start">{{ __('Referral User') }}:</label>
                            <div class="col-12 col-md-9 text-start">
                                @if($user->referral_scores_sum_score)
                                <div class="progress-bar rounded" role="progressbar"
                                    style="width: {{ scorePercentageCalculate($user->referral_scores_sum_score, 'referral') }}%; height:1em;"
                                    aria-valuenow="{{ scorePercentageCalculate($user->referral_scores_sum_score, 'referral') }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                    {{ $user->referral_scores_sum_score ?? 0 }}</div>
                                    @else
                                        <span>0</span>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                {!! $chart->container() !!}
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-center">
                    <h4 class="card-title">{{ __('Use Scores') }}</h4>
                    <p class="card-text">{{ __('messages.scores.usage_description') }}</p>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="usage">
                        <div id="spinner" wire:loading wire:loading wire:target="usage">
                            <img src="{{ asset('images/ajax-loader.gif') }}" />
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <select class="form-select @error('type') is-invalid @enderror"
                                    wire:model.defer="type" aria-label="Default select example" required>
                                    <option value="">{{ __('Choose a discount plan') }}</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->locale_name }} -
                                            {{ $type->require_score }} {{ __('Points') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <span class=" text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- <div class="col-md-6">
                                <label for="score" class="form-label">{{ __('Score') }}</label>
                                <input type="number" class="form-control @error('score') is-invalid @enderror"
                                    wire:model="score" id="score">
                                @error('score')
                                    <span class=" text-danger">{{ $message }}</span>
                                @enderror
                            </div> --}}
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">{{ __('Get Code') }}</button>
                            </div>
                        </div>
                    </form>

                    @if ($discountCode)
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p>{{ __('Code') }} : </p>
                                <h3>{{ $discountCode }}</h3>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-center">
                    <h4 class="card-title">{{ __('Generated Codes') }}</h4>
                </div>
                <div>
                    @forelse ($discounts as $discount)
                        <div class="mb-3 row {{ !$loop->last ? "border-bottom" : "" }}">
                            <div class="col-md-10 position-relative">
                                <h5 class="copy-to-clipboard" data-link="{{ $discount->code }}">{{ $discount->code }}</h5>
                                <div class="flash-message"></div>
                                <div class="mb-2">{{ $discount->scoreCategory?->locale_name }} - {{ $discount->scoreCategory?->require_score }}</div>
                            </div>
                            <div class="col-md-2">
                                <span class="text-muted fs-small">{{ $discount->created_at?->diffForHumans() }}</span>
                                <a href="{{ $link ?? "http://mediatel.ca/selectTemplate/" }}" class="link-primary">{{ __('Go To Page') }}</a>
                            </div>
                        </div>
                    @empty
                        <div>
                            <p>{{ __('You have no generated code.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    {!! $chart->script() !!}
    <script>
        $(document).ready(function() {
            $('.copy-to-clipboard').click(function() {
                var copyText = $(this).attr('data-link');
                var tempInput = document.createElement("input");
                tempInput.value = copyText;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);

                $(this).next('.flash-message').text('Copied').fadeIn(500).delay(1000).fadeOut(500);
            });
        });
    </script>
@endpush
