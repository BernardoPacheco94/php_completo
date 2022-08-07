<?php

$conn = new PDO (
    "mysql:dbname=db_php8; host=127.0.0.1",'root',''
);

$stmt = $conn->prepare("DELETE FROM tb_usuarios WHERE idusuario = :ID ");

$id = 4;


$stmt->bindParam(":ID", $id);

$stmt->execute();

echo "Usuário deletado";