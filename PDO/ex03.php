<?php

$conn = new PDO (
    "mysql:dbname=db_php8; host=127.0.0.1",'root',''
);

$stmt = $conn->prepare("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID ");

$login_antigo = 'bernardo';
$login = 'gabriel';
$password = 'papi';
$id = 5;


$stmt->bindParam(":LOGIN", $login);
$stmt->bindParam(":PASSWORD", $password);
$stmt->bindParam(":ID", $id);

$stmt->execute();

echo "Usuário<strong> $login_antigo </strong>alterado para $login";