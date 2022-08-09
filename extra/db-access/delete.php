<?php

$conn = new PDO ("mysql:host=localhost;dbname=db_profile", "root", "");

$stmt = $conn->prepare("DELETE FROM tb_profile WHERE idprofile = :ID");

$id = 2;

$stmt->bindParam(":ID", $id);

$stmt->execute();

echo "Perfil excluído";