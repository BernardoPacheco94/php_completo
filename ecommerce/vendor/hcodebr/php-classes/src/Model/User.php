<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;

class User extends Model {

    const SESSION = "User";//constante da sessao

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

        $data = $result[0];//joga em data o resutado da query

        if (password_verify($password, $data['despassword']))//valida a senha e inicia a sessao
        {
            $user = new User();

            $user->setData($data);

            $_SESSION[User::SESSION] = $user->getData();//pega os dados e atribui na sessao

            return $user;
        }
        else
        {
            throw new \Exception("Usuário inexistente ou senha inválida");
        }
    }

    public static function verifyLogin($inadmin = true) 
    {
        // if (
        //     !isset($_SESSION[User::SESSION])
        //     ||
        //     !$_SESSION[User::SESSION]
        //     ||
        //     !(int)$_SESSION[User::SESSION]["iduser"] > 0
        //     ||
        //     (bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin
        // ) 
        // {
        //     header('Location: /admin/login');
        //     exit;
        // }
    }

    public static function logout()
    {
        $_SESSION[User::SESSION] = NULL;
    }
}