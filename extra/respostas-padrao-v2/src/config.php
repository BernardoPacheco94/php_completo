<?php

spl_autoload_register(function($class_name){
    $filename = "src".DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR."$class_name.php";

    if(file_exists($filename)){
        require_once "$filename";
    } 
    else{
        require_once "class".DIRECTORY_SEPARATOR."$class_name.php";
    }
});