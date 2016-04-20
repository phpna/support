<?php
namespace Phpna\Support\Repository;
use Phpna\Support\Traits\DynamicTrait;
class Config
{
    use DynamicTrait;
    public function mergeConfigFrom($path,$key)
    {
        $phpnaKey = 'phpna.'.$key;
        $config = app('config')->get($phpnaKey, []);
        app('config')->set($phpnaKey, array_replace_recursive(require $path, $config));
        $this->ressetConfigKey($key);
    }

    public function __call($method, $arguments = [])
    {
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $arguments);
        }

        return call_user_func_array([app('config'), $method], $arguments);
    }
}
