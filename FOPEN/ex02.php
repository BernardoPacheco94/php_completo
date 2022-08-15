<?php

require_once "config.php";

$sql = new sql;

$usuarios = $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");

$headers = array();//iniciando o cabeçalho

foreach ($usuarios[0] as $colum => $value) { //preenchendo o cabeçalho
    array_push($headers, ucfirst($colum));
}

$file = fopen("usuarios.csv", "w+");//criando o arquivo em modo sobrescrita

fwrite($file, implode(",",$headers)."\r\n");

foreach ($usuarios as $row) {    
    $data = array();
    
    foreach ($row as $key => $value) {//preenchendo o array
        array_push($data, $value);
    }//encerra coluna

    fwrite($file, implode(",",$data)."\r\n");//colocando o array no arquivo
}//encerra a linha

fclose($file);

echo "csv gerado";