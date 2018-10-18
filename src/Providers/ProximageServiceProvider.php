<?php

namespace Coderello\Proximage\Providers;

use Coderello\Proximage\ImageProxy;
use Illuminate\Support\ServiceProvider;

class ProximageServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('proximage', ImageProxy::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['proximage'];
    }
}
