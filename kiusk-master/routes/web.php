<?php

use App\Http\Controllers\Admin\CkeditorController;
use App\Http\Controllers\Front\AdCartController;
use App\Http\Controllers\Front\Ad\AdsController;
use App\Http\Controllers\Front\Advertisement\AdvertisementController;
use App\Http\Controllers\Front\Blog\BlogController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\Chat\ChatController;
use App\Http\Controllers\Front\Home\HomeController;
use App\Http\Controllers\Front\LanguageController;
use App\Http\Controllers\Front\Panel\User\UserPanelController;
use App\Http\Controllers\Front\RedirectController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Payment\PaypalController;
use App\Http\Controllers\SeedController;
use App\Http\Controllers\SeedPostController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\v2\TelegramController;
// use App\Http\Controllers\TelegramController;
use App\Models\Ad\Ad;
use App\Models\Ad\Category;
use App\Models\Blog\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
//use Corcel\Model\Post;
use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('/logs', function () {
    $date = Carbon::now()->format('Y-m-d');
    $path = 'logs/laravel-' . $date . '.log';
    $path = storage_path($path);
    $mainLog = storage_path('logs/laravel.log');
    if (File::exists($path)) {
        $log = File::get($path);
        return '<pre>' . $log . '</pre>';
    } elseif(File::exists($mainLog)) {
        $log = File::get($mainLog);
        return '<pre>' . $log . '</pre>';
    } else {
        return 'Log file not found.';
    }
});
Route::get('/logs/{date}', function ($date) {
    $path = 'logs/laravel-' . $date . '.log';
    $path = storage_path($path);
    $mainLog = storage_path('logs/laravel.log');
    if (File::exists($path)) {
        $log = File::get($path);
        return '<pre>' . $log . '</pre>';
    } elseif(File::exists($mainLog)) {
        $log = File::get($mainLog);
        return '<pre>' . $log . '</pre>';
    } else {
        return 'Log file not found.';
    }
});

Route::get('/logs/clear', function () {
    $date = Carbon::now()->format('Y-m-d');
    $path = 'logs/laravel-' . $date . '.log';
    $path = storage_path($path);
    if (File::exists($path)) {
        $log = File::delete($path);
        return 'log deleted';
    } else {
        return 'Log file not found.';
    }
});

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";
});

Route::get('/user/reset/{phone}', function ($phone) {
    $user = \App\Models\User::where('phone', $phone)->first();
    if ($user) {
        $user->update([
            'telegram_id' => null,
            'telegram_last_message_id' => null,
            'telegram_last_request_id' => null,
            'telegram_last_message' => null,
            'telegram_last_method' => null,
        ]);
        return 'User updated';
    } else {
        return 'User not found.';
    }
});


Route::get('set-locale', [LanguageController::class, 'setLanguage'])->name('set.locale')->middleware('doNotCacheResponse');

/**
 * @param $post
 * @return Closure
 */
//seed
Route::group(['as' => ''], function () {
    Route::get('seed/all', function () {
        ini_set('max_execution_time', 0);
        (new SeedController())->adAll();
        (new SeedPostController())->postAll();

        return 'seed all successful';
    });
    Route::get('seed/ad/all', [
        SeedController::class,
        'adAll',
    ]);
    Route::get('seed/ads', [
        SeedController::class,
        'ads',
    ]);
    Route::get('seed/tags', [
        SeedController::class,
        'tags',
    ]);
    Route::get('seed/categories', [
        SeedController::class,
        'categories',
    ]);
    Route::get('seed/post/all', [
        SeedPostController::class,
        'postAll',
    ]);
    Route::get('seed/posts', [
        SeedPostController::class,
        'posts',
    ]);
    Route::get('seed/posts/tags', [
        SeedPostController::class,
        'tags',
    ]);
    Route::get('seed/posts/categories', [
        SeedPostController::class,
        'categories',
    ]);
});
//old Front
/*Route::group(['prefix' => ''], function () {
 //home
 Route::view('/', 'base')
      ->name('home');
 Route::get('product-category/{slug}/page/{page?}', [
  PageController::class,
  'adCategory'
 ])

  //ads
      ->name('ads-category');
 Route::get('product-category/{slug}', [
  PageController::class,
  'adCategory'
 ])
      ->name('index-ads-category');
 Route::get('product-tag/{slug}/page/{page?}', [
  PageController::class,
  'adTag'
 ])
      ->name('ads-tag');
 Route::get('product-tag/{slug}', [
  PageController::class,
  'adTag'
 ])
      ->name('index-ads-tag');
 Route::get('ads/{slug}', [
  PageController::class,
  'ad'
 ])
      ->name('ad');
//blog
 Route::get('weblog-2/{page?}', [
  BlogController::class,
  'index'
 ])
      ->name('blog-index');
 Route::get('blog/{year}/{month}/{day}/{slug}', [
  BlogController::class,
  'post'
 ])
      ->name('blog-post');
 Route::get('tags/{slug}', [
  BlogController::class,
  'tags'
 ])
      ->name('post-tags');
});*/
// Admin
Route::group([
    'as' => 'admin.',
    'middleware' => 'throttle',
], function () {
    Route::post('ckeditor/upload', [
        CkeditorController::class,
        'upload',
    ])
        ->name('ckeditor.upload');
});
//new Front
Route::group([
    'as' => 'front.',
    'middleware' => ['faLang'],
], function () {
    Route::get('', [
        HomeController::class,
        'frontHome',
    ])
        // ->middleware('cacheResponse')
        ->name('home');
    Route::get('login-register', [
        HomeController::class,
        'frontLoginRegister',
    ])
        // ->withoutMiddleware('cacheResponse')
        ->name('login-register');
    Route::get('signup-phone', [
        HomeController::class,
        'signupPhone'
    ])->name('signup-phone');
    Route::get('site-rules', [
        HomeController::class,
        'frontRules',
    ])
        ->name('rules');
    Route::get('contact', [
        HomeController::class,
        'frontContactUs',
    ])
        ->name('contact-us');
    Route::get('about', [
        HomeController::class,
        'frontAboutUs',
    ])
        ->name('about-us');
    Route::get('kiusk-users', [
        HomeController::class,
        'frontKiuskUsers',
    ])
        ->name('kiusk-users');
    Route::get('scores', [
        HomeController::class,
        'frontScores',
    ])
        ->name('scores.index');
    Route::get('advertisement', [
        AdvertisementController::class,
        'index',
    ])
        ->name('advertisement.index')->middleware('ad-auth');
    Route::get('advertisement/create', [
        AdvertisementController::class,
        'create',
    ])
        ->name('advertisement.create');
    Route::group(['as' => 'ad.'], function () {
        //  Route::get('', [
        //   AdsController::class,
        //   'frontAdSearch'
        //  ])
        // ->name('search');
        Route::get('listing', [
            AdsController::class,
            'frontAdIndex',
        ])
            ->name('index.first.page');
        Route::get('listing/page/{page?}', [
            AdsController::class,
            'frontAdIndex',
        ])
            ->name('index');
        Route::get('newad', [
            AdsController::class,
            'frontAdCreate',
        ])
            ->name('create')
            ->middleware(['auth', 'verify.mobile']);
            // ->middleware(['auth', 'verified:front.panel.user.profile.edit', 'verify.mobile']);
        Route::get('ads/{slug:slug}', [
            AdsController::class,
            'frontAdShow',
        ])
            ->name('show');
        Route::group(['as' => 'category.city.'], function () {
            Route::get('blog/city_categories/{slug}/page/{page?}', [
                AdsController::class,
                'frontAdCategoryCityIndex',
            ])
                ->name('index');
            Route::get('blog/city_categories/{slug}', [
                AdsController::class,
                'frontAdCategoryCityIndex',
            ])
                ->name('index.first.page');
        });
        Route::group(['as' => 'category.'], function () {
            Route::get('product-category/{slug}/page/{page?}', [
                AdsController::class,
                'frontAdCategoryIndex',
            ])
                ->name('index');
            Route::get('product-category/{slug}', [
                AdsController::class,
                'frontAdCategoryIndex',
            ])
                ->name('index.first.page');
        });
        Route::group(['as' => 'tag.'], function () {
            Route::redirect(
                'product-tag/{slug}/page/{page?}',
                config('app.url')
                //    , [
                //    AdsController::class,
                //    'frontAdTagIndex'
                //   ]
            );
            //        ->name('index');
            Route::redirect(
                'product-tag/{slug}',
                config('app.url')
                //    , [
                //    AdsController::class,
                //    'frontAdTagIndex'
                //   ]
            );
            //        ->name('index.first.page');
        });
    });
    Route::group(['as' => 'blog.'], function () {
        Route::get('blog/{year}/{month}/{day}/{slug}', [
            BlogController::class,
            'oldFrontBlogShow',
        ])
            ->name('old.show');
        Route::get('blog/{year}/{month}/{day}/{slug}/{id}', [
            BlogController::class,
            'oldFrontBlogShowWithPage',
        ])
            ->name('old.show.withId');
        Route::get('blog/{slug}', [
            BlogController::class,
            'frontBlogShow',
        ])
            ->name('show');
        Route::group(['as' => 'category.'], function () {
            // Route::get('blog/{page?}', [
            //     BlogController::class,
            //     'frontBlogCategoryIndexBlog',
            // ])
            //     ->name('blog.index');
            Route::get('blog', [
                BlogController::class,
                'frontBlogCategoryIndexBlog',
            ])
                ->name('blog.index.first.page');
            Route::get('news/{page}', [
                BlogController::class,
                'frontBlogCategoryIndexNews',
            ])
                ->name('news.index');
            Route::get('news', [
                BlogController::class,
                'frontBlogCategoryIndexNews',
            ])
                ->name('news.index.first.page');
        });
        Route::group(['as' => 'tag.'], function () {
            Route::redirect(
                'tags/{slug}/page/{page}',
                config('app.url')
                //    , [
                //    BlogController::class,
                //    'frontBlogTagIndex'
                //   ]
            );
            //        ->name('index');
            Route::redirect(
                'tags/{slug}',
                config('app.url')
                //              [
                //    BlogController::class,
                //    'frontBlogTagIndex'
                //   ]
            );
            //        ->name('index.first.page');
        });
    });
    Route::group([
        'as' => 'panel.user.',
        'middleware' => 'auth',
    ], function () {
        Route::get('profile/{user?}', [
            // Route::get('profile/?user={user?}', [
            UserPanelController::class,
            'frontPanelUserProfileShow',
        ])
            ->name('profile.show');
        Route::group([
            'prefix' => 'my-account',
        ], function () {
            Route::get('dashboard', [
                UserPanelController::class,
                'frontPanelUserDashboard',
            ])
                ->name('dashboard.index');
            Route::get('', [
                UserPanelController::class,
                'frontPanelUserAdIndex',
            ])
                ->name('ad.index');
            Route::get('edit-ad/{id}', [
                UserPanelController::class,
                'frontPanelUserAdEdit',
            ])
                ->name('ad.edit');
            Route::get('edit-ad/{id}/payment', [
                UserPanelController::class,
                'frontPanelUserAdPayment',
            ])
                ->name('ad.payment');
            Route::get('user-bookmark', [
                UserPanelController::class,
                'frontPanelUserFavoriteIndex',
            ])
                ->name('favorite.index')
                ->withoutMiddleware('auth');
            Route::get('orders', [
                UserPanelController::class,
                'frontPanelUserPaymentIndex',
            ])
                ->name('payment.index');
            Route::get('scores', [
                UserPanelController::class,
                'frontPanelUserScores',
            ])
                ->name('scores.index');
            Route::get('upgrade', [
                UserPanelController::class,
                'frontPanelUserUpgrade',
            ])
                ->name('upgrade.index');
            Route::get('google-review', [
                UserPanelController::class,
                'frontPanelUserGoogleReview',
            ])
                ->name('google-review.index');
            Route::get('edit-account', [
                UserPanelController::class,
                'frontPanelUserProfileEdit',
            ])
                ->name('profile.edit');
            Route::get('user-videos', [
                UserPanelController::class,
                'frontPanelUserVideos',
            ])
                ->name('videos.index');
            Route::get('service-usage', [
                UserPanelController::class,
                'frontPanelServiceUsage',
            ])
                ->name('service-usage.index');
            Route::get('plans/vip', [
                UserPanelController::class,
                'frontPanelVipPlans',
            ])
                ->name('plans.vip');
            Route::get('plans/telegram-ads/{telegramAd}', [
                UserPanelController::class,
                'frontPanelTelegramAdPlans',
            ])
                ->name('plans.telegram-ads');
            Route::get('plans/pin-ads', [
                UserPanelController::class,
                'frontPanelPinAdPlans',
            ])
                ->name('plans.pin-ads');
            Route::get('plans/{ad:slug}', [
                UserPanelController::class,
                'frontPanelPlans',
            ])
                ->name('plans.index');
            Route::get('tickets', [
                UserPanelController::class,
                'frontPanelTicketsIndex',
            ])
                ->name('tickets.index');
            Route::get('tickets/create', [
                UserPanelController::class,
                'frontPanelTicketsCreate',
            ])
                ->name('tickets.create');
            Route::get('tickets/{ticket_id}', [
                UserPanelController::class,
                'frontPanelTicketsShow',
            ])
                ->name('tickets.show');
            Route::get('chat', [
                UserPanelController::class,
                'chat',
            ])
                ->name('chat.show');
            Route::get('ad-orders', [UserPanelController::class, 'adOrders'])
                ->name('ad-orders.index');
            Route::get('ad-orders/{adOrder}', [UserPanelController::class, 'adOrdersShow'])
                ->name('ad-orders.show');
        });
    });

    Route::group([
        'as' => 'user.',
        'middleware' => ['auth', 'doNotCacheResponse'],
    ], function () {
        Route::get('cart', [
            CartController::class,
            'index',
        ])
            ->name('cart.index');
        Route::get('ad-cart', [
            AdCartController::class,
            'index',
        ])
            ->name('ad-cart.index');
    });
});
//telegram
Route::group(['prefix' => 'v2'], function(){
    // Route::get('setwebhook/{token}', [TelegramController::class, 'setWebhook']);
    // Route::get('getwebhook', [TelegramController::class, 'getWebhook']);
    // Route::get('deletewebhook/{token}', [TelegramController::class, 'deleteWebhook']);
    // Route::get('resetwebhook/{token}', [TelegramController::class, 'resetWebhook']);
    // Route::get('getUpdates/{token}', [TelegramController::class, 'getUpdates']);
    // Route::get('newStart', [TelegramController::class, 'index']);
});

Route::group(['as' => '', 'middleware' => 'set.locale'], function () {
    /**
     * todo un comment
     */
    // Route::post(st()->botApiToken, [
    Route::post(st()->botApiToken, [
        TelegramController::class,
        'index',
    ]);
    Route::get('/setwebhook', function () {
        $token = st()->botApiToken;
        return $response = Telegram::setWebhook(['url' => 'https://kiusk.webteamwork.ca/' . $token]);
    });
    Route::get('/deletewebhook', function () {
        $t = new Api(st()->botApiToken);

        return $t->deleteWebhook();
    });
    Route::get('/resetwebhook', function () {
        $token = st()->botApiToken;
        $t = new Api($token);
        $t->deleteWebhook();
        $all = $t->getUpdates(['offset' => 423501055]);
        $response = Telegram::getWebhookInfo();
        $response2 = Telegram::setWebhook(['url' => 'https://kiusk.webteamwork.ca/' . $token]);

        return [
            $t,
            $all,
            $response,
            $response2,
        ];
    });
    Route::get('/getwebhook', function () {
        return $response = Telegram::getWebhookInfo();
    });
    Route::get('/getUpdates', function () {
        $t = new Api('5900652188:AAHpEWGV8p97Wg5a3woJ9opg_cBc1rjR6oo');

        return $t->getUpdates(['offset' => 423501055]);
    });
    Route::get('/t', function () {
        $r = new App\Http\Controllers\TelegramController();
        $r->adsList();
    });
});
//payment form
Route::post('/pay', [
    PaymentController::class,
    'create',
]);
Route::post('/capture', [
    PaymentController::class,
    'capture',
]);
// Advertisement Payment
Route::post('/pay/advertisement', [
    PaymentController::class,
    'createAdvertisement',
]);
Route::post('/capture/advertisement', [
    PaymentController::class,
    'captureAdvertisement',
]);
// route for processing payment
Route::post('paypal', [
    PaymentController::class,
    'payWithpaypal',
]);
// route for check status of the payment
Route::get('status', [
    PaymentController::class,
    'getPaymentStatus',
])
    ->name('payment');
Route::get('/test', function () {
    return
        //        DB::table('telescope_entries')->count();
        //    $this->table('telescope_monitoring')->delete();
        //    return now()->toDateTimeString();
        //return
        //    Laravel\Telescope\Storage\EntryModel::oldest()->first()->created_at->ago();
        //
        //    return
        //    User::whereEmail('farhad.3.rohani@gmail.com')->update([
        //        'password' => bcrypt('farhad.3.rohani@gmail.com'),
        //        'rule'=>'admin'
        //]);

        // a=\Spatie\LaravelSettings\Models\SettingsProperty::create([
        //        'group' => 'general',
        //        'name' => 'allowViewTelescopeUsers',
        //        'locked' => '0',
        //        'payload' => json_encode([
        //            [
        //                'email'=>'farhad.3.rohani@gmial.com',
        //                'name'=>'farhad rohani moghaddas'
        //            ]
        //        ])
        //    ]);
        \Spatie\LaravelSettings\Models\SettingsProperty::create([
            'group' => 'general',
            'name' => 'telescopeRecordAll',
            'locked' => '0',
            'payload' => 'false',
        ]);
    //    \Spatie\LaravelSettings\Models\SettingsProperty::find(67)->update([
    //        'payload' => "\"[{\\\"email\\\":\\\"farhad.3.rohani@gmail.com\\\",\\\"name\\\":\\\"farhadrohanimoghaddas\\\"}]\""
    //    ]);
    //    return
    //    \Spatie\LaravelSettings\Models\SettingsProperty::whereIn('name', ['telescopeNightMode', 'allowViewTelescopeUsers'])->get();
});
Route::get('/artisan', function () {
    Artisan::call("optimize:clear");
    // Artisan::call("view:clear");
});


Route::get('send-sms', function () {
    app(\App\Services\Sms\SmsService::class)->send();
});


Route::group(['prefix' => 'paypal', 'middleware' => 'auth'], function(){
    Route::post('create-order', [PaypalController::class, 'createOrder'])->name('create.order');
    Route::post('payment-success', [PaypalController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('payment-cancel', [PaypalController::class, 'paymentCancel'])->name('payment.cancel');
});


/********************* English Routes  *********************/

Route::group([
    'as' => 'en.front.',
    'middleware' => ['enLang', 'cacheResponse',
    // 'firstVisit'
],
    'prefix' => 'en'
], function () {
    Route::get('', [
        HomeController::class,
        'frontHome',
    ])
        // ->middleware('cacheResponse')
        ->name('home');
    Route::get('login-register', [
        HomeController::class,
        'frontLoginRegister',
    ])
        // ->withoutMiddleware('cacheResponse')
        ->name('login-register');
    Route::get('signup-phone', [
        HomeController::class,
        'signupPhone'
    ])->name('signup-phone');
    Route::get('site-rules', [
        HomeController::class,
        'frontRules',
    ])
        ->name('rules');
    Route::get('contact', [
        HomeController::class,
        'frontContactUs',
    ])
        ->name('contact-us');
    Route::get('about', [
        HomeController::class,
        'frontAboutUs',
    ])
        ->name('about-us');
    Route::get('kiusk-users', [
        HomeController::class,
        'frontKiuskUsers',
    ])
        ->name('kiusk-users');
    Route::get('scores', [
        HomeController::class,
        'frontScores',
    ])
        ->name('scores.index');
    Route::get('advertisement', [
        AdvertisementController::class,
        'index',
    ])
        ->name('advertisement.index')->middleware('ad-auth');
    Route::get('advertisement/create', [
        AdvertisementController::class,
        'create',
    ])
        ->name('advertisement.create');
    Route::group(['as' => 'ad.'], function () {
        //  Route::get('', [
        //   AdsController::class,
        //   'frontAdSearch'
        //  ])
        // ->name('search');
        Route::get('listing', [
            AdsController::class,
            'frontAdIndex',
        ])
            ->name('index.first.page');
        Route::get('listing/page/{page?}', [
            AdsController::class,
            'frontAdIndex',
        ])
            ->name('index');
        Route::get('newad', [
            AdsController::class,
            'frontAdCreate',
        ])
            ->name('create')
            ->middleware(['auth', 'verify.mobile']);
            // ->middleware(['auth', 'verified:front.panel.user.profile.edit', 'verify.mobile']);
        Route::get('ads/{slug:slug}', [
            AdsController::class,
            'frontAdShow',
        ])
            ->name('show');
        Route::group(['as' => 'category.city.'], function () {
            Route::get('blog/city_categories/{slug}/page/{page?}', [
                AdsController::class,
                'frontAdCategoryCityIndex',
            ])
                ->name('index');
            Route::get('blog/city_categories/{slug}', [
                AdsController::class,
                'frontAdCategoryCityIndex',
            ])
                ->name('index.first.page');
        });
        Route::group(['as' => 'category.'], function () {
            Route::get('product-category/{slug}/page/{page?}', [
                AdsController::class,
                'frontAdCategoryIndex',
            ])
                ->name('index');
            Route::get('product-category/{slug}', [
                AdsController::class,
                'frontAdCategoryIndex',
            ])
                ->name('index.first.page');
        });
        Route::group(['as' => 'tag.'], function () {
            Route::redirect(
                'product-tag/{slug}/page/{page?}',
                config('app.url')
                //    , [
                //    AdsController::class,
                //    'frontAdTagIndex'
                //   ]
            );
            //        ->name('index');
            Route::redirect(
                'product-tag/{slug}',
                config('app.url')
                //    , [
                //    AdsController::class,
                //    'frontAdTagIndex'
                //   ]
            );
            //        ->name('index.first.page');
        });
    });
    Route::group(['as' => 'blog.'], function () {
        Route::get('blog/{year}/{month}/{day}/{slug}', [
            BlogController::class,
            'oldFrontBlogShow',
        ])
            ->name('old.show');
        Route::get('blog/{year}/{month}/{day}/{slug}/{id}', [
            BlogController::class,
            'oldFrontBlogShowWithPage',
        ])
            ->name('old.show.withId');
        Route::get('blog/{slug}', [
            BlogController::class,
            'frontBlogShow',
        ])
            ->name('show');
        Route::group(['as' => 'category.'], function () {
            Route::get('blog/{page?}', [
                BlogController::class,
                'frontBlogCategoryIndexBlog',
            ])
                ->name('blog.index');
            Route::get('blog', [
                BlogController::class,
                'frontBlogCategoryIndexBlog',
            ])
                ->name('blog.index.first.page');
            Route::get('news/{page}', [
                BlogController::class,
                'frontBlogCategoryIndexNews',
            ])
                ->name('news.index');
            Route::get('news', [
                BlogController::class,
                'frontBlogCategoryIndexNews',
            ])
                ->name('news.index.first.page');
        });
        Route::group(['as' => 'tag.'], function () {
            Route::redirect(
                'tags/{slug}/page/{page}',
                config('app.url')
                //    , [
                //    BlogController::class,
                //    'frontBlogTagIndex'
                //   ]
            );
            //        ->name('index');
            Route::redirect(
                'tags/{slug}',
                config('app.url')
                //              [
                //    BlogController::class,
                //    'frontBlogTagIndex'
                //   ]
            );
            //        ->name('index.first.page');
        });
    });
    Route::group([
        'as' => 'panel.user.',
        'middleware' => 'auth',
    ], function () {
        Route::get('profile/{user?}', [
            // Route::get('profile/?user={user?}', [
            UserPanelController::class,
            'frontPanelUserProfileShow',
        ])
            ->name('profile.show');
        Route::group([
            'prefix' => 'my-account',
        ], function () {
            Route::get('dashboard', [
                UserPanelController::class,
                'frontPanelUserDashboard',
            ])
                ->name('dashboard.index');
            Route::get('', [
                UserPanelController::class,
                'frontPanelUserAdIndex',
            ])
                ->name('ad.index');
            Route::get('edit-ad/{id}', [
                UserPanelController::class,
                'frontPanelUserAdEdit',
            ])
                ->name('ad.edit');
            Route::get('edit-ad/{id}/payment', [
                UserPanelController::class,
                'frontPanelUserAdPayment',
            ])
                ->name('ad.payment');
            Route::get('user-bookmark', [
                UserPanelController::class,
                'frontPanelUserFavoriteIndex',
            ])
                ->name('favorite.index')
                ->withoutMiddleware('auth');
            Route::get('orders', [
                UserPanelController::class,
                'frontPanelUserPaymentIndex',
            ])
                ->name('payment.index');
            Route::get('edit-account', [
                UserPanelController::class,
                'frontPanelUserProfileEdit',
            ])
                ->name('profile.edit');
            Route::get('scores', [
                UserPanelController::class,
                'frontPanelUserScores',
            ])
                ->name('scores.index');
            Route::get('upgrade', [
                UserPanelController::class,
                'frontPanelUserUpgrade',
            ])
                ->name('upgrade.index');
            Route::get('google-review', [
                UserPanelController::class,
                'frontPanelUserGoogleReview',
            ])
                ->name('google-review.index');
            Route::get('user-videos', [
                UserPanelController::class,
                'frontPanelUserVideos',
            ])
                ->name('videos.index');
            Route::get('service-usage', [
                UserPanelController::class,
                'frontPanelServiceUsage',
            ])
                ->name('service-usage.index');
            Route::get('plans/vip', [
                UserPanelController::class,
                'frontPanelVipPlans',
            ])
                ->name('plans.vip');
            Route::get('plans/telegram-ads/{telegramAd}', [
                UserPanelController::class,
                'frontPanelTelegramAdPlans',
            ])
                ->name('plans.telegram-ads');
            Route::get('plans/pin-ads', [
                UserPanelController::class,
                'frontPanelPinAdPlans',
            ])
                ->name('plans.pin-ads');
            Route::get('plans/{ad:slug}', [
                UserPanelController::class,
                'frontPanelPlans',
            ])
                ->name('plans.index');
            Route::get('tickets', [
                UserPanelController::class,
                'frontPanelTicketsIndex',
            ])
                ->name('tickets.index');
            Route::get('tickets/create', [
                UserPanelController::class,
                'frontPanelTicketsCreate',
            ])
                ->name('tickets.create');
            Route::get('tickets/{ticket_id}', [
                UserPanelController::class,
                'frontPanelTicketsShow',
            ])
                ->name('tickets.show');
            Route::get('ad-orders', [UserPanelController::class, 'adOrders'])
                ->name('ad-orders.index');
            Route::get('ad-orders/{adOrder}', [UserPanelController::class, 'adOrdersShow'])
                ->name('ad-orders.show');
        });
    });

    Route::group([
        'as' => 'user.',
        'middleware' => 'auth',
    ], function () {
        Route::get('cart', [
            CartController::class,
            'index',
        ])
            ->name('cart.index');
        Route::get('ad-cart', [
            AdCartController::class,
            'index',
        ])
            ->name('ad-cart.index');
    });
});



Route::get('/sitemap', [SitemapController::class, 'index']);

Route::get('/{slug}', [RedirectController::class, 'index'])->name('redirects.index');
// Route::redirect('/{slug}', '/blog', 301)->where('slug', 'weblog-2');
// Route::get('/{slug}', function($slug){
//     if($slug == 'weblog-2'){
//         return redirect()->to('/blog');
//     }
//     if($slug == 'قوانین-و-مقررات'){
//         return redirect()->to('/site-rules');
//     }
//     abort(404);
// });
Route::get('/chat', [ChatController::class, 'index'])->middleware(['auth', 'set.locale'])->name('front.chat');
Route::get('/chat/{id}', [ChatController::class, 'index'])->middleware(['auth', 'set.locale', 'fetchUserData'])->name('front.chat.message');
Route::get('en/chat', [ChatController::class, 'index'])->middleware(['auth', 'set.locale'])->name('en.front.chat');
Route::get('en/chat/{id}', [ChatController::class, 'index'])->middleware(['auth', 'set.locale', 'fetchUserData'])->name('en.front.chat.message');

Route::post('/shared', [ChatController::class, 'sharedPhotos'])->name('shared');
Route::post('en/shared', [ChatController::class, 'sharedPhotos'])->name('en.shared');

Route::post('/fetchMessages', [ChatController::class, 'fetch'])->name('fetch.messages');
// Route::get('/en/chat', [ChatController::class, 'index'])->middleware('enLang');
// Route::get('/en/chat/{id}', [ChatController::class, 'index'])->middleware('enLang');
// Route::post('/chat/send-message', [ChatController::class, 'sendMessage']);

Route::get('test-mail', [HomeController::class, 'testMail']);
Route::get('get-code/{phone}', function($phone){
    $user = \App\Models\VerifyCode::where('phone', $phone)->first();
    return $user?->code;
});

