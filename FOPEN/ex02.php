<?php

require_once "config.php";

$sql = new sql;

$usuarios = $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");

$headers = array();

foreach ($usuarios[0] as $colum => $value) {    
    array_push($headers, ucfirst($colum));
}

$file = fopen("usuarios.csv", "w+");

fwrite($file, implode(",",$headers)."\r\n");

foreach ($usuarios as $row) {    
    $data = array();
    
    foreach ($row as $key => $value) {
        array_push($data, $value);
    }//encerra coluna

    fwrite($file, implode(",",$data)."\r\n");
}//encerra a linha

fclose($file);

echo "csv gerado";