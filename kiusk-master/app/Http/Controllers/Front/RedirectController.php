<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\MainLink;
use App\Traits\RedirectTrait;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    use RedirectTrait;

    /**
     * Redirects routes to specified routes in the database
     *
     * @param string $slug
     * @return Redirect
     */
    public function index($slug)
    {
        return $this->redirect($slug);
    }
}
