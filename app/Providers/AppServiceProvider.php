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

        // we can hook into it when any view is loaded
        // let's listen for when the sidebar is loaded,  and then register callback function
        view()->composer('admin.nav', function ($view) {
            // add a variable 'adminID' and give user id to it
            $view->with('adminID', auth()->user()->id);
            $view->with('adminName', auth()->user()->name);

        }); 
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind(AuthenticateUser::class, AuthenticateUser::class);
        $this->app->bind('App\Libraries\AuthenticateUser', \App\Libraries\AuthenticateUser::class);


        // App::bind('App\Billing\Stripe', function(){
        //     return new \App\Billing\Stripe('asfdasdfasf');
        // });
    }
}
