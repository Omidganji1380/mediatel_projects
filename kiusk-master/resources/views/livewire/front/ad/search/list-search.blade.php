<section class="pb-5 pt-4" id="ads">
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-3 p-3 p-md-0 cards ads-card-title-blue">
        @forelse ($ads as $ad)
            <livewire:front.ad.search.card-search :ad="$ad" :wire:key="$ad['id']" />
            {{--  <livewire:front.ad.card :ad="$ad" --}}
            {{--                          :wire:key="$ad['id']"/> --}}
            {{-- <br> --}}
        @empty
            <div class="border-blue w-100">
                <p>{{ __('There is no ad!') }}</p>
            </div>
        @endforelse
        @if (count($ads))
            <div class="mt-3 w-100 d-flex justify-content-center overflow-auto">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        @if ($searchType == 'link')

                            @foreach ($urls as $url)
                                <li
                                    class="page-item rounded @if ($url['active']) active @endif  @if ($url['disabled']) disabled @endif">
                                    <a class="page-link  bg-transparent"
                                        href="{{ $url['url'] }}">{!! $url['label'] !!}</a></li>
                            @endforeach
                        @elseif($searchType == 'livewire')
                            @foreach ($urls as $url)
                                <li
                                    class="page-item rounded @if ($url['active']) active @endif  @if ($url['disabled']) disabled @endif">
                                    <a href="" class="page-link  bg-transparent"
                                        wire:click.prevent="$emit('setPage',{{ $url['page'] }})">{!! $url['label'] !!}</a>
                                </li>
                            @endforeach

                        @endif
                    </ul>
                </nav>
            </div>
        @endif
    </div>
</section>
