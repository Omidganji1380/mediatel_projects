@php
    $isFa = App::isLocale('fa');
    $positionBackground =  $isFa ? "background-position: left 0.75rem center;" :  "background-position: right 0.75rem center;"
@endphp
<form wire:submit.prevent="store">
    <div class="col-md-12">
        <label for="title" class="form-label">{{ __('Title') }}</label>
        <input type="text" wire:model="title"
            class="form-control  @error('title') is-invalid @enderror" id="title">
        @error('ad.title')
            <span class=" text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-md-12 mt-3">
        <select class="form-select @error('ticketCategoryId') is-invalid @enderror required"
            wire:model="ticketCategoryId" aria-label="Default select example" style="{{ $positionBackground }}">
            <option selected>{{ __('Categories') }}</option>
            @foreach (\App\Models\TicketCategory::all() as $category)
                <option value="{{ $category->id }}">{{ $category->title }}</option>
            @endforeach
        </select>
        @error('ticketCategoryId')
            <span class=" text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-floating">
        <textarea class="form-control" wire:model="message" placeholder="{{ __('Description') }}" rows="10" cols="3" style="height: 200px !important"></textarea>
        <label for="floatingTextarea2">{{ __('Description') }}</label>
    </div>
    @error('message')
            <span class=" text-danger">{{ $message }}</span>
    @enderror
    <button type="submit" class="btn btn-primary mt-3">{{ __('Submit') }}</button>
</form>
