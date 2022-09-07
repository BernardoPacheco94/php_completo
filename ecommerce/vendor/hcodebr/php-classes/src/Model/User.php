<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;
use sql as GlobalSql;

class User extends Model
{
    
    const SESSION = "User"; //constante da sessao

    public static function login($login, $password)
    {
        $sql = new Sql;

        $result = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
            ":LOGIN" => $login
        ));


        if (!count($result)) {
            throw new \Exception("Usuário inexistente ou senha inválida"); // a contrabarra no Exception é pq estamos usando o namespace, e nao há classe exception nesse namespace, portanto a classe exception deve vir da raiz
        }

        $data = $result[0]; //joga em data o resutado da query

        if (password_verify($password, $data['despassword'])) //valida a senha e inicia a sessao
        {
            $user = new User();

            $user->setiduser($data["iduser"]);

            $user->setData($data);

            $_SESSION[User::SESSION] = $user->getData(); //pega os dados e atribui na sessao

            return $user;
        } else {
            throw new \Exception("Usuário inexistente ou senha inválida");
        }
    }

    public static function verifyLogin($inadmin = true)
    {
        if (
            !isset($_SESSION[User::SESSION])
            ||
            !$_SESSION[User::SESSION]
            ||
            !(int)$_SESSION[User::SESSION]["iduser"] > 0
            ||
            (bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin
        ) {
            header('Location: /admin/login');
            exit;
        }
    }

    public static function logout()
    {
        $_SESSION[User::SESSION] = NULL;
    }

    public static function listAll()
    {
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING (idperson) ORDER BY b.desperson");
    }

    public function save()
    {
        $sql = new Sql;

        $results = $sql->select("CALL sp_users_save (:desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
            ":desperson" => $this->getdesperson(),
            ":deslogin" => $this->getdeslogin(),
            ":despassword" => $this->getdespassword(),
            ":desemail" => $this->getdesemail(),
            ":nrphone" => $this->getnrphone(),
            ":inadmin" => $this->getinadmin()
        ));


        $this->setData($results[0]);
    }

    public function get($iduser)
    {
        $sql = new Sql;

        $results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING (idperson) WHERE a.iduser = :iduser", array(
            ":iduser"=>$iduser
        ));

        $this->setData($results[0]);
    }

    public function update()
    {
        $sql = new Sql;

        $results = $sql->select("CALL sp_usersupdate_save(:iduser, :desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
            ":iduser" => $this->getiduser(),
            ":desperson" => $this->getdesperson(),
            ":deslogin" => $this->getdeslogin(),
            ":despassword" => $this->getdespassword(),
            ":desemail" => $this->getdesemail(),
            ":nrphone" => $this->getnrphone(),
            ":inadmin" => $this->getinadmin()
        ));


        $this->setData($results[0]);        
    }

    public function delete()
    {
        $sql = new Sql;

        $sql->query("CALL sp_users_delete (:iduser)", array(
            ":iduser" => $this->getiduser()
        ));
    }

    public static function getForgot($email)
    {
        $sql = new Sql;

        $results = $sql->select("
            SELECT * FROM tb_persons a
            INNER JOIN tb_users b USING(idperson)
            WHERE a.desemail = :EMAIL;
        ", array(
            "email" => $email
        ));

        if(!count($results))
        {
            throw new \Exception("Não foi possível recuperar a senha");
            
        }
        else
        {
            $data = $results[0];
            $queryReturn = $sql->select("CALL sp_userspasswordsrecoveries_create(:iduser, :desip)", array(
                ":iduser" => $data["iduser"],
                ":desip" => $_SERVER["REMOTE_ADDR"]
            )); 
            
            if(!count($queryReturn))
            {
                throw new \Exception("Não foi possível recuperar a senha");
                
            }
            else
            {
                $dataRecovery = $queryReturn[0];

                define('SECRET', pack('a16', 'senha'));
                $code = base64_encode(openssl_encrypt($dataRecovery["idrecovery"], 'AES-128-CBC', SECRET, 0, SECRET));

                $link = "http://www.hcodecommerce.com.br/admin/forgot/reset?code=$code";
            }
        }
    }
}
