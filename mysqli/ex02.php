<?php

$conn = new mysqli('127.0.0.1','root','','db_php8');//construtores da classe mysqli

if ($conn->connect_error)//testando a conexão
{
    echo "Error: Erro ao conectar ao banco de dados";
}

$result = $conn->query("SELECT * FROM tb_usuarios");

$data = array();

while ($row = $result->fetch_array())
{
    array_push($data, $row);
}

echo json_encode($data);