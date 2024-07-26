<div class="section-title clearfix">
    <h2>{{ __('Tickets') }}</h2>
</div>
<div class="">
    <div class="container table-responsive  p-0 p-lg-4 pt-lg-0">
        <table class="table table-bordered">
            <thead class="">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ __('Date') }}</th>
                    <th scope="col">{{ __('Status') }}</th>
                    <th scope="col">{{ __('Category') }}</th>
                    <th scope="col">{{ __('Show') }}</th>
                    {{--    <th scope="col">پرداخت</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $key => $ticket)
                    <tr class="bg-white">
                        <td class="text-center pt-3">
                            {{ ($tickets->currentpage()-1) * $tickets->perpage() + $key + 1 }}
                        </td>
                        <td class="text-center pt-3">
                            {{ date('Y-m-d', strtotime($ticket->created_at)) }}
                        </td>
                        <td class="text-center pt-3">
                            {{ __('messages.statuses.' . $ticket->status ) }}
                        </td>
                        <td class="text-center pt-3">
                            {{ $ticket->category?->title }}
                        </td>
                        <td class="text-center pt-3">
                            <a href="{{ route($lang . 'front.panel.user.tickets.show', $ticket->id) }}"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>{{ $tickets->links() }}</div>
    </div>
</div>
