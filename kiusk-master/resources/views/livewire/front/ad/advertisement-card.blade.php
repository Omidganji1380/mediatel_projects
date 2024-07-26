<a href="{{ route($lang . 'front.ad.create') }}">
    <div class="cards col pe-3 ps-2 pt-2 h-100">
        <div class="h-100">
            <div class="ad-top-head border border-bottom font-weight-bold py-4 text-center" style="border-radius: 2em 2em 0 0;">
                {{ __('Your Ads Place') }}
            </div>
            <div class="ad-main-body border-bottom border-end border-start font-weight-bold fs-2 p-5 text-center text-danger">
                {{ __('Special Ad') }}
            </div>
            <div class="ad-footer bg-warning font-weight-bold fs-5 p-2 h-25 text-center d-grid align-items-center" style="border-radius: 0 0 2em 2em;">
                {{ $category->locale_name }}
            </div>
        </div>
    </div>
</a>
