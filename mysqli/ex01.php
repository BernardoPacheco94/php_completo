<?php

$conn = new mysqli('127.0.0.1','root','','db_php8');//construtores da classe mysqli

if ($conn->connect_error)//testando a conexão
{
    echo "Error: Erro ao conectar ao banco de dados";
}

$stmt = $conn->prepare("INSERT INTO tb_usuarios (deslogin, dessenha) VALUES (?,?) ");

$stmt->bind_param("ss",$user, $pass);//informa os tipos de dados que irão no lugar do ponto de interrogação do comando anterior. s - string, i - int, d - double/float

$user = "user";
$pass = "1234";

$stmt->execute();//roda o stmt

$user = "root";
$pass = "1234";

$stmt->execute();//O detalhe aqui é que não é necessário refazer o comando todo, apenas usar o execute já inclui no banco