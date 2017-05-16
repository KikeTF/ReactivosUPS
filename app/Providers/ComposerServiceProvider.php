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
        View::composer('*', function ($view){
            $viewNameStart = substr(strtolower($view->getName()), 0, 4);
            $isTestView = ($viewNameStart === 'test') ? true : false;

            if ($isTestView === false)
                View::composer('*', 'ReactivosUPS\Http\ViewComposers\OptionsComposer');
        });
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
