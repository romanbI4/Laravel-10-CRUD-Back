<?php

namespace App\Providers;

use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Contracts\Auth\PasswordBrokerFactory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(TokenRepositoryInterface::class, function ($app) {
            $factory = $app->make(PasswordBrokerFactory::class);
            return $factory->broker()->getRepository();
        });
        $this->app->bind(PasswordBrokerFactory::class, function ($app) {
            $factory = $app->make(PasswordBrokerFactory::class);
            return $factory->broker()->getRepository();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
