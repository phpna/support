<?php
namespace Phpna\Support;
// use Illuminate\Contracts\Foundation\Application;
// use Phpna\Builder\Components\Constracts\Repository;
use Illuminate\Foundation\AliasLoader;
class Support
{
    public $app;
    public $phpna;
    public function __construct($app)
    {
        $this->app = $app;
        $this->phpna = $this->app['phpna'];
    }

    public function registerProviders()
    {
        $providers = [];
        foreach ($this->phpna->getServices() as $package) {
            if(key_exists('providers',$package) && is_array($package['providers'])){
                $providers = array_collapse([$providers,$package['providers']]);
            }
        }
        foreach ($providers as $provider) {
            $this->app->register($provider);
        }
    }
    public function aliasFacades()
    {
        $facades = [];
        foreach ($this->phpna->getServices() as $package) {
            if(key_exists('facades',$package) && is_array($package['facades'])){
                $facades = array_collapse([$facades,$package['facades']]);
            }
        }
        foreach ($facades as $facade) {
            $loader = AliasLoader::getInstance();
            foreach ($facades as $name => $serve) {
                $loader->alias($name, $serve);
            }
        }
    }
}
