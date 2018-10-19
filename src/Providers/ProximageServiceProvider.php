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
        $this->publishes([
            __DIR__.'/../../config/proximage.php' => config_path('proximage.php'),
        ], 'proximage-config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('proximage', function () {
            $proximage = new ImageProxy;

            foreach (config('proximage.defaults.templates', []) as $template) {
                $proximage->template($template);
            }

            return $proximage;
        });

        $this->mergeConfigFrom(
            __DIR__.'/../../config/proximage.php',
            'proximage'
        );
    }
}
