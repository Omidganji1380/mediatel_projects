<div class="card border-0">
    <div id="spinner" wire:loading wire:loading wire:target="goToActivity">
        <img src="{{ asset('images/ajax-loader.gif') }}" />
    </div>
    <div class="card-body pt-0">
        <div class="row mt-3">
            <div class="col-md-6 mb-3">
                <div class="card" wire:click="goToActivity('rate')">
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-center">
                            <div class="icon mb-3 text-center">
                                <i class="fa fa-star fa-5x text-warning"></i>
                            </div>
                            <div class="text-center">
                                <h5>{{ s()->scoresText['rate']['tilte'] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card" wire:click="goToActivity('comment')">
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-center">
                            <div class="icon mb-3 text-center">
                                <i class="{{ s()->scoresText['comment']['icon'] }}"></i>
                            </div>
                            <div class="text-center">
                                <h5>{{ s()->scoresText['comment']['tilte'] }}</h5>
                                {{-- <p>{{ s()->scoresText['comment']['subtilte'] }}</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card" wire:click="goToActivity('review')">
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-center">
                            <div class="icon mb-3 text-center">
                                <i class="{{ s()->scoresText['review']['icon'] }}"></i>
                            </div>
                            <div class="text-center">
                                <h5>{{ s()->scoresText['review']['tilte'] }}</h5>
                                {{-- <p>{{ s()->scoresText['review']['subtilte'] }}</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card" wire:click="goToActivity('referral')">
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-center">
                            <div class="icon mb-3 text-center">
                                <i class="{{ s()->scoresText['referral']['icon'] }}"></i>
                            </div>
                            <div class="text-center">
                                <h5>{{ s()->scoresText['referral']['tilte'] }}</h5>
                                {{-- <p>{{ s()->scoresText['referral']['subtilte'] }}</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card" wire:click="goToActivity('complete_registration')">
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-center">
                            <div class="icon mb-3 text-center">
                                <i class="{{ s()->scoresText['complete_registration']['icon'] }}"></i>
                            </div>
                            <div class="text-center">
                                <h5>{{ s()->scoresText['complete_registration']['tilte'] }}</h5>
                                {{-- <p>{{ s()->scoresText['complete_registration']['subtilte'] }}</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card" wire:click="goToActivity('google_review')">
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-center">
                            <div class="icon mb-3 text-center">
                                <i class="{{ s()->scoresText['google_review']['icon'] }}"></i>
                            </div>
                            <div class="text-center">
                                <h5>{{ s()->scoresText['google_review']['tilte'] }}</h5>
                                {{-- <p>{{ s()->scoresText['google_review']['subtilte'] }}</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card" wire:click="goToActivity('send_video')">
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-center">
                            <div class="icon mb-3 text-center">
                                <i class="{{ s()->scoresText['send_video']['icon'] }}"></i>
                            </div>
                            <div class="text-center">
                                <h5>{{ s()->scoresText['send_video']['tilte'] }}</h5>
                                {{-- <p>{{ s()->scoresText['send_video']['subtilte'] }}</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card" wire:click="goToActivity('service_usage')">
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-center">
                            <div class="icon mb-3 text-center">
                                <i class="{{ s()->scoresText['service_usage']['icon'] }}"></i>
                            </div>
                            <div class="text-center">
                                <h5>{{ s()->scoresText['service_usage']['tilte'] }}</h5>
                                {{-- <p>{{ s()->scoresText['service_usage']['subtilte'] }}</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
