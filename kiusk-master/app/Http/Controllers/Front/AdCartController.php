<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AdCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdCartController extends Controller
{
    /**
     * Dispalys the list of the user's cart page
     *
     * @return View
     */
    public function index()
    {
        $cart = AdCart::whereBelongsTo(Auth::user())->with(['advertisementOrder', 'advertisementType'])->first();
        return view('front.pages.home.ad-cart', compact('cart'));
    }
}
