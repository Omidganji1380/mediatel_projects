<?php

namespace App\Http\Controllers\Front\Home;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Front\Ad\AdsController;
use App\Mail\WelcomeEmail;
use App\Models\Ad\Ad;
use App\Models\Ad\Category;
use App\Models\Advertisement;
use App\Models\ChMessage as Message;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use SEO;
// use Chatify\Facades\Chatify;

class HomeController extends Controller
{
    public function frontHome()
    {
        if (request()->query('s') || request()->query('state_categories') || request()->query('category')) {
            return (new AdsController())->frontAdSearch();
        } elseif (request()->query('p')) {
            $adWordpressId = Ad::where('extra->wordpressId', request()->query('p'))->first();

            if ($adWordpressId) {
                $slug = $adWordpressId->slug;
            } else {
                $slug = Ad::findOrFail(request()->query('p'))->slug;
            }

            return (new AdsController())->frontAdShow($slug);
        }

        $ids = Arr::flatten(s()->mainPageCategories);
        $categories = Category::with(['ads'])
            ->whereIn('id', $ids)
            ->orderByRaw("FIELD(id, " . implode(',', $ids) . ")")
            ->get();

        $banners = Advertisement::active()
            ->whereHas('advertisementType', function ($query) {
                $query->where('position', 'main_page');
            })
            ->get()->chunk(2);
        $advertisements = Advertisement::active()->whereHas('adOrder')->latest()->get()->chunk(2);

        $selectedAds = [];

        foreach ($categories as $category) {
            $ad = Advertisement::whereHas('adOrder', function ($query) use ($category) {
                    $query->where('category_id', $category->id);
                })
                ->active()
                ->inRandomOrder()
                ->first();

            if ($ad) {
                $selectedAds[$category->id] = $ad;
            }
        }

        $lang = config('app.locale') === 'fa' ? '' : 'en.';

        return view('front.pages.home.home.home', compact('categories', 'banners', 'advertisements', 'lang', 'selectedAds'));
    }

    public function frontLoginRegister()
    {
        if (auth()->check()) {
            return redirect()->route('front.home');
        }

        return view('front.pages.home.login&register');
    }

    public function frontRules()
    {
        return view('front.pages.home.rules');
    }

    public function frontContactUs()
    {
        return view('front.pages.home.contact_us');
    }

    public function frontAboutUs()
    {
        return view('front.pages.home.about_us');
    }


    public function frontScores()
    {
        return view('front.pages.home.scores');
    }

    public function frontKiuskUsers()
    {
        return view('front.pages.home.kiusk-users');
    }

    public function signupPhone()
    {
        return view('front.pages.home.signup-phone');
    }

    public function testMail()
    {
        $user = auth()->user();
        if ($user?->email)
            Mail::to($user->email)->send(new WelcomeEmail($user));
    }
}
