<?php


spl_autoload_register(function ($nomeClasse)
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

$carro = new DelRey;
$carro->acelerar(20);//metodo da classe Automovel.php
$carro->empurrar();//metodo da classe DelRey.php