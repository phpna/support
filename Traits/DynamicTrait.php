<?php
namespace Phpna\Support\Traits;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Filesystem\Filesystem;
trait DynamicTrait
{
    protected $dynamics = [];
    protected function getYamlConfig($file,$key)
    {
        if(file_exists($this->pathDynamics($key))){
            return Yaml::parse(file_get_contents($this->pathDynamics($key)));
        }
        return [];
    }

    protected function pathDynamics($key)
    {
        $path = str_replace('.','/',$key).'.yml';
        return storage_path('phpna/'.$path);
    }

    protected function copyDynamics($file,$key)
    {
        if(file_exists($file) && !file_exists($this->pathDynamics($key))){
            $fs = new Filesystem();
            $fs->copy($file,$this->pathDynamics($key));
        }
    }

    protected function formatDynamics($yaml)
    {
        return trim(implode("\n", array_map(function($str){
            return trim($str);
        },explode("\n", trim($yaml,'-')))));
    }

    public function setDynamics($dynamic,$value = array())
    {
        foreach ($value as $k => $v) {
            app('config')->set('phpna.dynamics.'.$dynamic.'.'.$k,$v);
        }
        $config = app('config')->get('phpna.dynamics.'.$dynamic);
        $yaml = Yaml::dump($config,1);
        file_put_contents($this->pathDynamics($dynamic),$yaml);
        $this->ressetConfigKey($key);
    }

    public function getDynamics($dynamic,$key = null)
    {
        $key = ($key == null) ? '' : '.'.$key;
        return config('phpna.dynamics.'.$dynamic.$key);
    }

    public function publishDynamics($file,$key)
    {
        $phpnaKey = 'phpna.dynamics.'.$key;
        $oldConfig = config($phpnaKey,[]);
        $this->copyDynamics($file,$key);
        $yamlConfig = $this->getYamlConfig($file,$key);
        config([$phpnaKey => array_merge($oldConfig, $yamlConfig)]);
        config(['phpna.'.$key => array_merge(config('phpna.'.$key ,[]),$yamlConfig)]);
        $this->ressetConfigKey($key);
    }

    protected function ressetConfigKey($key)
    {
        $phpnaKey = 'phpna.'.$key;
        app('config')->set($key,app('config')->get($phpnaKey));
    }
}
