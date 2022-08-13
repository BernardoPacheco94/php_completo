<?php

require_once "config.php";

//$user = new Usuario;

//  $user->findById(4);

//  echo $user;//apneas o echo, pois há o construtor toString na classe Usuario



// $list = Usuario::getList();
// echo json_encode($list);


// $search = Usuario::search("be");

// echo json_encode($search);


// $user->login("gabriel","papai123");

//$user = Usuario::insert("aabrao","12345");//insert sem procedure
//$list = Usuario::getList();

$user = new Usuario("jubileu", "bora");
$user->insert();

echo $user;

