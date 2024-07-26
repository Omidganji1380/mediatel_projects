<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Dispalys the Cart Page
     *
     * @return View
     */
    public function index()
    {
        return view('front.pages.home.cart');
    }
}
