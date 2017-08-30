<?php

namespace Robertogallea\Restado;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class RestadoServiceProvider extends ServiceProvider
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
        App::bind('restado', function()
        {
            return new Restado();
        });
    }
}
