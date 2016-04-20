<?php
namespace Phpna\Support;
use Phpna\Support\Repository\Config;
use Phpna\Support\Repository\Scan;
use Phpna\Support\Repository\Error;
use Phpna\Support\Handle;
class Bootstrap
{
    public $config;
    protected $scan;
    protected $handle;
    protected $status;
    protected $error;
    public function __construct()
    {
        $this->config = new Config;
        // $this->error = new Error();
    }
    public function handle()
    {
        $this->scan = new Scan();
    }
    public function getServices()
    {
        return $this->scan->getServices();
    }
}
