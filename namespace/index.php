<?php

require_once "config.php";

use Cliente\Cadastro;

$cad = new Cadastro;

$cad->setNome('Bernardo');
$cad->setEmail('bpacheco94@gmail.com');
$cad->setSenha('12345');

echo $cad."<br>";
$cad->registrarVenda();//metodo que está dentro de outro diretorio com o mesmo nome
