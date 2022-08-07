<?php
//TRANSAÇÕES

$conn = new PDO (
    "mysql:dbname=db_php8; host=127.0.0.1",'root',''
);

$conn -> beginTransaction();//inicia a transação

$stmt = $conn->prepare("DELETE FROM tb_usuarios WHERE idusuario = ? ");

$id = 3;


$stmt->execute(array($id));

//$conn->rollBack();//desfaz o comando delete
$conn->commit();//confirma o comando delete


echo "Usuário deletado";