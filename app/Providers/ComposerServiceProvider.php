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
        View::composer('*', 'ReactivosUPS\Http\ViewComposers\OptionsComposer');
        View::composer('reagent.reagents.create', 'ReactivosUPS\Http\ViewComposers\FormatComposer');
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
