<?php

$id = (isset($_GET['id'])) ? $_GET['id'] : 1;

if (!is_numeric($id) || strlen($id))
{
    exit('Sistema bloqueado por motivos de segurança');
}

$conn = new mysqli("localhost", "root", "", "db_php8");

$sql = "SELECT * FROM tb_usuarios WHERE idusuario = $id";


$exec = mysqli_query($conn, $sql);

while ($resultado = mysqli_fetch_object($exec)){
    echo $resultado->deslogin."<br>";
}