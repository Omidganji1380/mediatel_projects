<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin mb-4">
                <div class="card">
                    <div class="card-body border-bottom">
                        <h4 class="card-title">{{ $ticket->title }}</h4>
                        <p class="card-description">
                            {{ $ticket->user->full_name }}
                        </p>
                        <p>
                            {!! $ticket->message !!}
                        </p>
                        <small class="d-flex justify-content-end text-secondary">{{ $ticket->created_at->diffForHumans() }}</small>
                    </div>

                    @foreach ($ticket->descendants as $item)
                        <div class="card-body border-bottom">
                            <p class="card-description">
                                {{ $item->user->full_name }}
                            </p>
                            <p>
                                {!! $item->message !!}
                            </p>
                            <small class="d-flex justify-content-end text-secondary">{{ $item->created_at->diffForHumans() }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ __('Reply') }}</h4>
                        <form class="form-sample" wire:submit.prevent="reply" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="message">{{ __('Message') }}</label>
                                <textarea class="form-control"  name="message" id="message" rows="10" wire:model="message" style="height: 200px !important" required>{{ old('message') }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-12 bt-3">
                                    <button class="btn btn-primary ticket-submit" id="ticket-submit" type="submit">{{ __('Reply') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    <!-- partial -->
</div>

