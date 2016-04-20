<?php
namespace Phpna\Support\Repository;
class Error
{
    protected $error = [];
    public function set($type,$args = array())
    {
        $this->error = array('type' => $type,'args' => $args);
        return $this;
    }
    public function reset()
    {
        $this->error = [];
    }
    public function get()
    {
        return $this->error;
    }
    public function arraySet($array = [])
    {
        if (!empty($array)) {
            $type = array_shift($array);
            return $this->set($type,$array);
        }else{
            $this->reset();
            return true;
        }
    }
    public function handle()
    {
        if(!empty($this->error)){
            list($method,$class) = explode('_',$this->error['type']);
            $object = new 'Phpna\\Error\\'.ucfirst($class).'Error';
            $this->reset();
            return call_user_func_array([$object, $method], $this->error['args']);
        }
        return true;
    }
}
