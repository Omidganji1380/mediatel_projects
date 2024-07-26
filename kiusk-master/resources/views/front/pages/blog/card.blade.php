<div class="col">
    <div class="card">
        <a href="{{ $post->link }}">
            <img src="{{ $post->getFirstMedia('SpecialImage')?->getUrl('thumb') ?: asset('images/kiusk-placeholder.jpg') }}" class="card-img-top" alt="...">
        </a>
        <span class="bookmark  favorite_7636" data-toggle="tooltip" data-placement="top" wire:click="favorite"
            title=""><i
                class="@if ($isFavorite) fas

        @else() far @endif  fa-bookmark text-white fs-6"></i></span>
        <p class="blog-detail">
            <span>
                <i class="far fa-calendar-o"></i> {{ $post->created_at->diffForHumans() }}</span>
            <span>
                <i class="far fa-bookmark"></i> {{ $post?->category?->name }} </span>
              {{-- <span><i class="fas fa-pie-chart"
                       aria-hidden="true"></i> {{$post->views}} بازدید</span> --}}
        </p>
        <div class="card-body bg-white  p-1 pt-2">
            <a href="{{ $post->link }}" class="card-title">
                <h4 class="blog-item">{!! strip_tags(Str::padRight($post->title, 100)) !!}</h4>
            </a>
            <p class=" blog-meta">{!! $post->limit_content !!}</p>
            <div class="d-flex justify-content-between p-3">
                <small><i class="fa fa-eye"></i> {{ $post->views }}</small>
                <small><i class="fa fa-heart"></i> {{ $post->favorites_count ?? 0 }}</small>
            </div>
        </div>
    </div>
</div>
