<?php

require_once "config.php";

$sql = new sql();

$usuarios = $sql->select("SELECT * FROM tb_usuarios");

$sql->execQuery("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :SENHA WHERE idusuario = :ID" , [':LOGIN'=>'murilo', ':SENHA'=>'abcde', ':ID'=>5]);

echo json_encode($usuarios);

