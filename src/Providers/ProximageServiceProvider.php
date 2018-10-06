<?php

namespace Coderello\Proximage\Providers;

use Coderello\Proximage\ImageProxy;
use Illuminate\Support\ServiceProvider;

class ProximageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('proximage', ImageProxy::class);
    }
}
