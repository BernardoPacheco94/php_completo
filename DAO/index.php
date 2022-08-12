<?php

require_once "config.php";

$user = new Usuario;

 $user->findById(2);

 echo $user;//apneas o echo, pois há o construtor toString na classe Usuario
