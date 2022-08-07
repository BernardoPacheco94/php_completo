<?php

spl_autoload_register(function($className)
{
    $dirClass = "class";//pasta
    $filename = $dirClass.DIRECTORY_SEPARATOR."$className.php";//path

    if (file_exists($filename))
    {
        require_once $filename;
    }
});


?>