<?php

spl_autoload_register(function ($classname) 
{
    $filename = "class".DIRECTORY_SEPARATOR."$classname.php";
    require_once $filename;
});
