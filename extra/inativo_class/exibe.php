<?php

require_once "autoload.php";

$usuario = new Usuario;

// $lista = Usuario::listUsuarios();

// echo json_encode($lista);


$usuario->login("bernardp@gmail.com","passhash");

echo $usuario;