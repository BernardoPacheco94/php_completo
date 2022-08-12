<?php

require_once "config.php";



// $access->execQuery("INSERT INTO tb_profile (nome, idade, genero) VALUES (:NOME, :IDADE, :GENERO)", [':NOME'=> 'bernardo', ':IDADE'=> 28, ':GENERO'=>'M']);

// $profile = $access->select("SELECT * FROM tb_profile");

// echo json_encode($profile);

$profile = new Profile;

$profile->loadById(3);
echo $profile;