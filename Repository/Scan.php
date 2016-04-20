<?php
namespace Phpna\Support\Repository;
class Scan
{
    protected $packages = [];
    protected $services = [];
    public function __construct()
    {
        $this->scanServices();
    }
    protected function scanServices()
    {
        foreach (config('phpna.packages') as $package) {
            $this->services[$package] = $this->getService($package);
        }
    }

    protected function getService($package)
    {
        $service = [];
        $service_file = $this->checkPackageExits($package) . '/package.php';
        if (file_exists($service_file)) {
            $service = require $service_file;
        }
        return array_merge(['providers' => [], 'facades' => []], $service);
    }

    public function checkPackageExits($package)
    {
        $package_path = false;
        foreach (config('phpna.scan') as $path) {
            if(is_dir($path.'/'.$package)
            && file_exists($path.'/'.$package.'/package.php')){
                $package_path = $path.'/'.$package;
            }
        }
        return $package_path;
    }

    public function getServices()
    {
        return $this->services;
    }

}
