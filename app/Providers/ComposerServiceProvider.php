<?php

namespace ReactivosUPS\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('auth.login', function ($view){
            $view;
        });

        View::composer('*', 'ReactivosUPS\Http\ViewComposers\OptionsComposer');

        View::composer('*', 'ReactivosUPS\Http\ViewComposers\NotificationsComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
