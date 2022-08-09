<?php

$conn = new PDO("mysql:host=localhost;dbname=db_profile", "root", "");


$stmt = $conn->prepare("SELECT * FROM tb_profile");

$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);