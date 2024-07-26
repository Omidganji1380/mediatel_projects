<x-stats-overview-widget.index :columns="$this->getColumns()"
                               class="col-span-full">
 {{--  <input type="hidden"--}}
 {{--         wire:model="count">--}}
 @foreach ($this->getCards() as $card)
  {{ $card }}
 @endforeach
</x-stats-overview-widget.index>
