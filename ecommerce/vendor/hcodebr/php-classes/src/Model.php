<?php

namespace Hcode;

class Model {

    private $values = [];

    public function __call($name, $arguments)
    {   
        $method = substr($name, 0, 3);
        $fieldName = substr($name, 3, strlen($name));

        switch ($method) {
            case 'set':
                $this->values[$fieldName] = $arguments[0];
            break;
            
            case 'get':
                return $this->values[$fieldName];
            break;
        }

    }

}

