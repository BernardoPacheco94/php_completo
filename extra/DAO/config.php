<?php

spl_autoload_register(function ($classname) 
{
    $fileName = "class".DIRECTORY_SEPARATOR."$classname.php";
    require_once $fileName;
});
