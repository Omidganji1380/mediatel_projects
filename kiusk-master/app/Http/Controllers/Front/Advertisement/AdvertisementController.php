<?php

namespace App\Http\Controllers\Front\Advertisement;

use App\Http\Controllers\Controller;
use App\Models\AdvertisementType;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function index()
    {
        $advertisement = AdvertisementType::with('media')->where('is_visible', true)->first();
        // $advertisementTypes = AdvertisementType::with('media')->get()->chunk(4);
        return view('front.pages.advertisements.index', compact('advertisement'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'weeks' => 'required|integer|min:1|max:4',
            'advertisement_slug' => 'required|string|exists:advertisement_types,slug'
        ]);
        $advertisement = AdvertisementType::whereSlug($request->advertisement_slug)->firstOrFail();
        $weeks = $request->weeks;
        return view('front.pages.advertisements.create', compact('advertisement', 'weeks'));
    }
}
