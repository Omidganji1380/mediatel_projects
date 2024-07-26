<?php

namespace App\Providers;

use App\Models\Ad\Ad;
use App\Models\Ad\Category;
use App\Models\Blog\Category as BlogCategoory;
use App\Models\Address\City;
use App\Models\Address\State;
use App\Models\User;
use App\Policies\Ad\AdPolicy;
use App\Policies\BlogCategoryPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\CityPolicy;
use App\Policies\StatePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
     // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Ad::class => AdPolicy::class,
        User::class => UserPolicy::class,
        Category::class => CategoryPolicy::class,
        BlogCategoory::class => BlogCategoryPolicy::class,
        State::class => StatePolicy::class,
        City::class => CityPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });
    }
}
