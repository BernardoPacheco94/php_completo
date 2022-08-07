<?php

$conn = new PDO (
    "mysql:dbname=db_php8; host=127.0.0.1",'root',''
);

$stmt = $conn->prepare("INSERT INTO tb_usuarios (deslogin, dessenha) VALUES (:LOGIN,:PASSWORD)");

$login = 'bernardo';
$password = '12345';

$stmt->bindParam(":LOGIN", $login);
$stmt->bindParam(":PASSWORD", $password);

$stmt->execute();

echo "Usuário cadastrado";