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
        $this->publishConfig();
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

    private function publishConfig()
    {
        $configPath = $this->packagePath('config/tado.php');

        $this->publishes([
            $configPath => config_path('tado.php'),
        ], 'config');

        $this->mergeConfigFrom($configPath, 'tado');
    }

    private function packagePath($path)
    {
        return __DIR__."/$path";
    }
}
