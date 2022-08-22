<?php

session_start();

require_once "config.php";



if (isset($_POST['btn_entrar'])){
    $name = $_POST['input_name'];
    $pass = $_POST['input_pass'];

    $user = new Usuario();

    $user->login($name, $pass);
}

else if(isset($_POST['btn_cadastrar'])){
    $name = $_POST['input_name'];
    $pass = $_POST['input_pass'];

    $securePass = password_hash($pass, PASSWORD_DEFAULT);

    $newUser = new Usuario();

    $newUser->insert($name, $securePass);
}


else{
    header('Location: login.html');
}



