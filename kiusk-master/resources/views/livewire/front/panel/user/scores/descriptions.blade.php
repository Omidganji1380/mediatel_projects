@push('styles')
    <style>
        figcaption {
            display: none;
        }
    </style>
@endpush
<div class="card border-0">
    <div id="spinner" wire:loading wire:loading wire:target="getDescription">
        <img src="{{ asset('images/ajax-loader.gif') }}" />
    </div>
    <div class="card-body pt-0">
        <div class="row mt-3">
            <div class="col-md-6 mb-3">
                <div class="card" wire:click="getDescription('rate')">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="icon me-3">
                                <i class="{{ s()->scoresText['rate']['icon'] }}"></i>
                            </div>
                            <div class="text align-self-center">
                                <h5>{{ s()->scoresText['rate']['tilte'] }}</h5>
                                {{-- <p>{{ s()->scoresText['rate']['subtilte'] }}</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card" wire:click="getDescription('comment')">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="icon me-3">
                                <i class="{{ s()->scoresText['comment']['icon'] }}"></i>
                            </div>
                            <div class="text align-self-center">
                                <h5>{{ s()->scoresText['comment']['tilte'] }}</h5>
                                {{-- <p>{{ s()->scoresText['comment']['subtilte'] }}</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card" wire:click="getDescription('review')">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="icon me-3">
                                <i class="{{ s()->scoresText['review']['icon'] }}"></i>
                            </div>
                            <div class="text align-self-center">
                                <h5>{{ s()->scoresText['review']['tilte'] }}</h5>
                                {{-- <p>{{ s()->scoresText['review']['subtilte'] }}</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card" wire:click="getDescription('referral')">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="icon me-3">
                                <i class="{{ s()->scoresText['referral']['icon'] }}"></i>
                            </div>
                            <div class="text align-self-center">
                                <h5>{{ s()->scoresText['referral']['tilte'] }}</h5>
                                {{-- <p>{{ s()->scoresText['referral']['subtilte'] }}</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card" wire:click="getDescription('complete_registration')">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="icon me-3">
                                <i class="{{ s()->scoresText['complete_registration']['icon'] }}"></i>
                            </div>
                            <div class="text align-self-center">
                                <h5>{{ s()->scoresText['complete_registration']['tilte'] }}</h5>
                                {{-- <p>{{ s()->scoresText['complete_registration']['subtilte'] }}</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card" wire:click="getDescription('google_review')">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="icon me-3">
                                <i class="{{ s()->scoresText['google_review']['icon'] }}"></i>
                            </div>
                            <div class="text align-self-center">
                                <h5>{{ s()->scoresText['google_review']['tilte'] }}</h5>
                                {{-- <p>{{ s()->scoresText['google_review']['subtilte'] }}</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card" wire:click="getDescription('send_video')">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="icon me-3">
                                <i class="{{ s()->scoresText['send_video']['icon'] }}"></i>
                            </div>
                            <div class="text align-self-center">
                                <h5>{{ s()->scoresText['send_video']['tilte'] }}</h5>
                                {{-- <p>{{ s()->scoresText['send_video']['subtilte'] }}</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card" wire:click="getDescription('service_usage')">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="icon me-3">
                                <i class="{{ s()->scoresText['service_usage']['icon'] }}"></i>
                            </div>
                            <div class="text align-self-center">
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

@push('scripts')
    <script>
        $(document).ready(function() {

            window.addEventListener('removeHrefLinkAttr', (e) => {
                console.log(e.detail.item);
                $("figure a").attr("href", "javascript:void(0)");
            });
        });
    </script>
@endpush
