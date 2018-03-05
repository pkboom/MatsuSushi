<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

// use App\Libraries\AuthenticateUser;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Libraries\AuthenticateUser', \App\Libraries\AuthenticateUser::class);

        // App::bind('App\Billing\Stripe', function(){
        //     return new \App\Billing\Stripe('asfdasdfasf');
        // });
    }
}
