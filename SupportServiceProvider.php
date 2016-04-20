<?php

/**
 * Created by PhpStorm.
 * User: lichnow
 * Date: 16/4/6
 * Time: 下午12:24
 */
namespace  Phpna\Support;
use Illuminate\Support\ServiceProvider;
use Phpna\Support\Support;
class SupportServiceProvider extends ServiceProvider
{
    protected $support;
    protected $config;

    public function register()
    {
        $this->phpna = new Bootstrap;
        $this->app->singleton('phpna',function($app){
            return new Bootstrap;
        });
        $this->config = $this->app['phpna']->config;
    }

    public function boot()
    {
        $this->registerConfig();
        $this->app['phpna']->handle();
        $this->support = new Support($this->app);
        $this->support->registerProviders();
        $this->support->aliasFacades();
    }
    /**
     * Register configuration file.
     */
    protected function registerConfig()
    {
        $configFile = __DIR__ . '/config/phpna.php';

        $this->publishes([$configFile => config_path('phpna.php')]);

        $this->mergeConfigFrom($configFile, 'phpna');
    }
}
