<?php

spl_autoload_register(function ($class_name){
    
    $filename = "class".DIRECTORY_SEPARATOR."$class_name.php";
    
    if(file_exists(($filename)))
    {
        require_once $filename;
    }
});


/*
spl_autoload_register(function ($nomeClasse)

Verifica se a classe está em um diretorio anteriro ou no mesmo
{
    if (file_exists("Abstratas".DIRECTORY_SEPARATOR."$nomeClasse.php"))//Passar o caminho completo do arquivo
    {
        require_once "Abstratas".DIRECTORY_SEPARATOR."$nomeClasse.php";
    }
    else
    {
        require_once "$nomeClasse.php";
    }   

});
*/