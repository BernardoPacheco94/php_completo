<?php

class Model {
    private $values = [];


    public function __call($name, $arguments)
    {
        $method = substr($name,0,3);
        $filedName = substr($name,3,strlen($name));

        switch($method){
            case "get":
                return $this->values[$filedName];
            break;

            case "set":
                $this->values[$filedName] = $arguments[0];
            break;
        }

    }


    public function setData($data = array())//setters
    {
        foreach ($data as $key => $value) {
            $this->{"set".$key}($value);
        }
    }

    public function getData()//getters
    {
        return $this->values;
    }
}