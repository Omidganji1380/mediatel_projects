<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\ResponseCache\Facades\ResponseCache;

class LanguageController extends Controller
{
    /**
     * Switch language based on the current language or default language
     * and over write the locale from the config and updates the user lang in database
     *
     * @param Request $request
     * @return Redirect
     */
    public function setLanguage(Request $request)
    {
        $request->validate([
            'lang' => 'in:fa,en',
            'current_url' => 'required|url',
            'current_lang' => 'in:fa,en',
        ]);
        $locale = $request->lang;
        $durata= 24 * 60 * 60;
        Cookie::queue('lang', $locale, $durata);
        if(Auth::check()){
            Auth::user()->update(['lang' => $locale]);
        }
        session(['currentLanguage' => $locale]);
        App::setLocale($locale);
        $baseUrl = url('/');
        if($locale == 'en' && $request->current_lang == 'fa'){
            $replaced = Str::replace($baseUrl, $baseUrl . '/en' , $request->current_url);
        }elseif($locale == 'fa' && $request->current_lang == 'en'){
            $replaced = Str::replace($baseUrl . '/en', $baseUrl , $request->current_url);
        }else{
            return back();
        }
        return redirect()->to($replaced);
    }
}
