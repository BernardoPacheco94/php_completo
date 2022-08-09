<?php

$conn = new PDO("mysql:dbname=db_php8;host:localhost",'root','');//o primeiro parametro é o db type, se fosse outro banco (sqlserver) seria alterado esse parametro

$stmt = $conn->prepare("SELECT * FROM tb_usuarios ORDER BY deslogin");

$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);//o fetch all passa por todas as linhas

print_r($results);