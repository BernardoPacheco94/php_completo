<?php

require_once "Model.php";


use Usuario as GlobalUsuario;

class Usuario extends Model {
    const SESSION = 'Usuario';

    public function login($name, $pass){
        $sql = new sql;

        $result = $sql->select("SELECT * FROM tb_usuarios WHERE name = :NAME",array(":NAME"=>$name));

        if (count($result) === 0){
            throw new Exception("Usuário ou senha inválidos");
        }
        
        $data = $result[0];
        
        if( password_verify($pass, $data['pass'])){
            $user = new GlobalUsuario();

            $user->setData($data);//setters

            $_SESSION[Usuario::SESSION] = $user->getData();

            header('Location: index.php');
            
            return $user;
        } else {            
            throw new Exception("Usuário ou senha inválidos");
        }
    }
    
    public function loadUser(){

    }

    public function insert($name, $pass){

        $sql = new sql;

        $sql->execQuery("INSERT INTO tb_usuarios (name, pass) VALUES (:NAME, :PASS)", array(
            ':NAME'=>$name,
            ':PASS'=>$pass
        ));

        header('Location: login.html');
    }
}
