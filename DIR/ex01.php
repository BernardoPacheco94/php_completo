<?php

$name = "images";

if (!is_dir($name))
{
    mkdir($name);
    echo "Diretório $name criado com sucesso.";
}
else
{
    echo "Diretório $name já existe";
    //rmdir($name); //Remove o diretório
}