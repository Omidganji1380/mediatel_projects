<?php

namespace App\Providers;

use App\Models\Ad\Ad;
use App\Models\Ad\Category;
use App\Models\Address\City;
use App\Models\Address\State;
use App\Models\AdminReferral;
use App\Models\Advertisement;
use App\Models\AdvertisementOrder;
use App\Models\AdvertisementType;
use App\Models\Blog\Comment;
use App\Models\Blog\Post;
use App\Models\MainLink;
use App\Models\Plan;
use App\Models\Promotion;
use App\Models\RegisteredReferral;
use App\Models\ServiceUsage;
use App\Models\TelegramAd;
use App\Models\User;
use App\Models\UserMessage;
use App\Models\UserVideo;
use App\Observers\CommentObserver;
use App\Repositories\CustomTokenRepository;
use Filament\Facades\Filament;
use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use SEO;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        $this->app->bind(DatabaseTokenRepository::class, CustomTokenRepository::class);
    }

    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {
        Filament::registerNavigationGroups([
            'Ads',
            'Blog',
            'Payment'
        ]);
        Filament::registerStyles([
            asset('css/admin/style.css'),
        ]);
        Filament::registerScripts([
            asset('js/jquery.min.js'),
            asset('js/admin/app.js'),
        ]);
        Relation::enforceMorphMap([
            'post' => Post::class,
            'postCategory' => \App\Models\Blog\Category::class,
            'ad' => Ad::class,
            'telegramAd' => TelegramAd::class,
            'adCategory' => Category::class,
            'user' => User::class,
            'state' => State::class,
            'city' => City::class,
            'advertisementType' => AdvertisementType::class,
            'advertisementOrder' => AdvertisementOrder::class,
            'advertisement' => Advertisement::class,
            'mainLink' => MainLink::class,
            'userVideo' => UserVideo::class,
            'serviceUsage' => ServiceUsage::class,
            'promotion' => Promotion::class,
            'plan' => Plan::class,
            'adminReferral' => AdminReferral::class,
            'userMessage' => UserMessage::class
        ]);
        Password::defaults(function () {
            return $rule = Password::min(st()->profileKeyboard[2]['keyRule'])
                //    ->letters()
                //    ->mixedCase()
                //    ->numbers()
                //    ->symbols()
                //    ->uncompromised()
            ;
            //   return $this->app->isProduction()
            //    ? $rule->mixedCase()->uncompromised()
            //    : $rule;
        });

        // $this->registerObservers();
        // $lang = App::isLocale('fa') ? '' : 'en.';
        // $lang = Session::get('locale') === 'fa' ? '' : 'en.';
        // View::share('prefixRoute', $lang);
    }

    public function registerObservers()
    {
        Comment::observe(CommentObserver::class);
    }
}
