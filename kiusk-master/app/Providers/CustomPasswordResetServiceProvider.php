<?php

namespace App\Providers;

use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\ServiceProvider;

class CustomPasswordResetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('auth.password', function ($app) {
            return new PasswordBrokerManager($app, function () use ($app) {
                return $app->make('auth.password.tokens');
            });
        });

        $this->app->bind('auth.password.tokens', function ($app) {
            $config = $app['config']['auth.passwords.'.config('auth.defaults.passwords').'.provider'];

            return new DatabaseTokenRepository(
                $app['db']->connection($config['connection'] ?? null),
                $app['hash'],
                $config['table'],
                $config['expire']
            );
        });

        Password::defaults(function () {
            return [
                'length' => 5,
                'ttl' => 60,
                'chars' => '0123456789',
                'input' => 'numeric',
            ];
        });

        $this->app->bind('auth.password.broker', function ($app) {
            return new PasswordBroker(
                $this->app->make('auth.password'),
                $this->app->make('auth.password.tokens'),
                $app['mailer'],
                $this->app->make('view'),
                $app['config']['app.name']
            );
        });
    }
}
