<?php

namespace KilroyWeb\Klink;

use Illuminate\Support\ServiceProvider;

class KlinkServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerKlink();
    }

    public function registerKlink(){
        $this->app->bind('klink',function() {
            return new Klink();
        });
    }

    public function provides()
    {
        return array('klink', 'KilroyWeb\Klink');
    }
}
