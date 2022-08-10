<?php

spl_autoload_register(function ($classname) 
{
    $fileName = "$classname.php";
    require_once $fileName;
});
