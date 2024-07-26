<?php
use Akaunting\Money\Money;
?>
<section class=" blog-block m-0">
    <div class="container pt-5">
        <div>
            <div class="container-step">
                {{-- @dump($step) --}}
                <div class="stepper-wrapper">
                    <div class="progress"></div>
                    <div class="screen-indicator @if ($step === 'category') completed @endif">1
                    </div>
                    <div class="screen-indicator @if ($step === 'form' || $step === 'realEstateForm') completed @endif ">2
                    </div>
                    <div class="screen-indicator @if ($step === 'review' || $step === 'buy' || $step === 'realEstateDetails') completed @endif">3
                    </div>
                    @if($categoryType == 'real_estate')
                        <div class="screen-indicator @if ($step === 'facilities') completed @endif">4
                        </div>
                        <div class="screen-indicator @if ($step === 'realEstateReview') completed @endif">5
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @if ($step === 'category')
            @include('livewire.front.ad.create.category')
        @endif

        @if ($step === 'realEstateForm')
            @include('livewire.front.ad.create.real_estate_form')
        @endif
        @if ($step === 'form')
            @include('livewire.front.ad.create.form')
        @endif

        @if ($step === 'realEstateDetails')
            @include('livewire.front.ad.create.real_estate_details')
        @endif

        @if ($step === 'facilities')
            @include('livewire.front.ad.create.facilities')
        @endif

        @if ($step === 'review')
            @include('livewire.front.ad.create.review')
        @endif

        @if ($step === 'realEstateReview')
            @include('livewire.front.ad.create.real_estate_review')
        @endif

        @if ($step === 'buy')
            @include('livewire.front.ad.create.buy')
        @endif
        <div wire:loading wire:target="step">
            <script>
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth',
                });
            </script>
        </div>
    </div>
</section>
