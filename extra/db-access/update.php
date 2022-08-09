<?php

$conn = new PDO("mysql:host=localhost;dbname=db_profile", "root","");

$stmt = $conn->prepare("UPDATE tb_profile SET nome = :NOME, idade = :IDADE,  genero = :GENERO");

$nome = 'gabriel';
$idade = 1;
$genero = 'M';

$stmt->bindParam(":NOME",$nome);
$stmt->bindParam(":IDADE",$idade);
$stmt->bindParam(":GENERO",$genero);

$stmt->execute();

echo "Registro alterado";