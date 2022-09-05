<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;

class User extends Model {


    public static function login ($login, $password) 
    {
        $sql = new Sql;

        $result = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
            ":LOGIN" => $login
        ));

        if (!count($result))
        {
            throw new \Exception("Usuário inexistente ou senha inválida");// a contrabarra no Exception é pq estamos usando o namespace, e nao há classe exception nesse namespace, portanto a classe exception deve vir da raiz
        }

        $data = $result[0];

        if (password_verify($password, $data['despassword']))
        {
            $user = new User();
            

        }
        else
        {
            throw new \Exception("Usuário inexistente ou senha inválida");
        }
    }
}