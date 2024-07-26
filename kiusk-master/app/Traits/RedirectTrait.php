<?php

namespace App\Traits;

use App\Models\Redirect;

trait RedirectTrait
{
    /**
     * Generate the redirect route
     *
     * @param string $slug
     * @param string|null $type
     * @param integer|null $y
     * @param integer|null $m
     * @param integer|null $d
     * @return Redirect
     */
    public function redirect($slug, $type = null, $y = null, $m = null, $d = null)
    {
        $urlEncodedSlug = urlencode($slug);
        if($y && $m && $d){
            $from = env('APP_URL') . "/$type/$y/$m/$d/$urlEncodedSlug";
        }elseif($type){
            $from = env('APP_URL') . "/$type/$urlEncodedSlug";
        }else{
            $from = env('APP_URL') . "/$urlEncodedSlug";
        }

        $fromWithSlash = $from . "/";
        $redirect = Redirect::
            where('old_slug', $slug)
            ->orWhere('old_slug', $urlEncodedSlug)
            ->orWhere('new_slug', $slug)
            ->orWhere('from' , $from)
            ->orWhere('from' , $fromWithSlash)
            ->firstOrFail();
        return redirect()->to($redirect->to);
    }
}
