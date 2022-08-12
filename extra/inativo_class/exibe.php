<?php

require_once "autoload.php";

$usuario = new Usuario;

$usuario->loadById(2);

echo $usuario;