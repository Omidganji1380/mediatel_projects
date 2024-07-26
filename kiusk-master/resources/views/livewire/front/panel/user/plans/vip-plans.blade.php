<div>
    <div class="section-title clearfix p-3">
        <h2>{{ __('VIP Plans') }}</h2>

        <div class="text-center d-flex justify-content-center ">
            <p>{{ __('Monthly') }}</p>
            <div class="form-check form-switch mx-3">
                <input class="form-check-input custom-switch" type="checkbox" wire:model="yearly" role="switch"
                    id="flexSwitchCheckDefault">
            </div>
            <p>{{ __('Yearly') }}</p>
        </div>
    </div>
    <section class="row px-md-5">
        @php
            $numbers = range(1, 7); // Create an array with numbers 1 to 7
            // shuffle($numbers); // Shuffle the array randomly
        @endphp

        @if ($yearly)
            @each('livewire.front.panel.user.plans.plan', $yearlyPlans, 'plan')
        @else
            @each('livewire.front.panel.user.plans.plan', $monthlyPlans, 'plan')
        @endif
    </section>
</div>
