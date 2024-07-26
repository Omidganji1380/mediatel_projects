<div id="upgrade-access-level">
    <div class="section-title clearfix p-3">
        <h2>{{ __('Upgrade Access Level') }}</h2>
        <P>{{ __('messages.profile.upgrade_role_description') }}</P>
    </div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <form wire:submit.prevent="submit">
        <div class="row g-3">
            <div class="col-12 mb-3">
                <select class="form-select @error('role') is-invalid @enderror" wire:model="role"
                    aria-label="Default select example">
                    @foreach ($roles as $key => $value)
                        <option value="{{ $key }}">{{ __('messages.roles.' . $key) }}</option>
                    @endforeach
                </select>
                @error('role')
                    <span class=" text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-12 mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" wire:model.defer="acceptRules" name="acceptRules"
                    id="flexCheckCheckedDisabled">
                    <label class="form-check-label" for="flexCheckCheckedDisabled">
                        {!! __('messages.accept_rules') !!}
                    </label>
                </div>
                @error('acceptRules')
                    <span class="error text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">{{ __('Upgrade') }}</button>
            </div>
        </div>
    </form>
</div>
