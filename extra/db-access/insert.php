<?php

$conn = new PDO("mysql:host=127.0.0.1;dbname=db_profile", "root", "");

$stmt = $conn->prepare("INSERT INTO tb_profile (nome, idade, genero) VALUES (:NOME, :IDADE, :GENERO)");

$nome = 'bernardo';
$idade = 28;
$genero = 'm';

$stmt->bindParam(":NOME", $nome);
$stmt->bindParam(":IDADE", $idade);
$stmt->bindParam(":GENERO", $genero);

$stmt->execute();

echo "Perfil do {$nome} cadastrado";
