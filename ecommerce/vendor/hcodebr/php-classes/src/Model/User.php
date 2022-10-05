<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;
use Hcode\Mailer;
use \Hcode\Model;
use sql as GlobalSql;

class User extends Model
{

    const SESSION = "User"; //constante da sessao
    const ERROR = "UserError";
    const ERROR_REGISTER = "UserErrorRegister";
    const SUCCESS = "UserMsgSuccess";

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

    public  static function getFromSession() //retorna uma sessao vazia caso nao haja usuario
    {
        $user = new User;

        if (isset($_SESSION[User::SESSION]) && (int)$_SESSION[User::SESSION]['iduser'] > 0) {
            $user->setData($_SESSION[User::SESSION]);
        }

        return $user;
    }

    public static function checkLogin($inadmin = true) //verificar se está logado
    {
        if (
            !isset($_SESSION[User::SESSION])
            ||
            !$_SESSION[User::SESSION]
            ||
            !(int)$_SESSION[User::SESSION]["iduser"] > 0
        ) {
            //nao está logado
            return false;
        } else {
            if ($inadmin === true && (bool)$_SESSION[User::SESSION]["inadmin"] === true) {
                return true;
            } else if ($inadmin === false) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function verifyLogin($inadmin = true) //verifica se o usuário está logado e é admin
    {
        if (!User::checkLogin($inadmin)) {

            if ($inadmin) {
                header('Location: /admin/login');
            } else {
                header('Location: /login');
            }
            exit;
        }
    }

    public static function logout()
    {
        $_SESSION[User::SESSION] = NULL;
        session_destroy();
    }

    public static function listAll()
    {
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING (idperson) ORDER BY b.desperson");
    }

    public function save()
    {
        $sql = new Sql;

        $securePass = password_hash($this->getdespassword(), PASSWORD_DEFAULT, ["cost" => 10]);

        $results = $sql->select("CALL sp_users_save (:desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
            ":desperson" => $this->getdesperson(),
            ":deslogin" => $this->getdeslogin(),
            ":despassword" => $securePass,
            ":desemail" => $this->getdesemail(),
            ":nrphone" => $this->getnrphone(),
            ":inadmin" => $this->getinadmin()
        ));

        $this->setData($results[0]);
    }

    public function get($iduser) //retorna os dados do usuario com a procedure (dados person)
    {
        $sql = new Sql;

        $results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING (idperson) WHERE a.iduser = :iduser", array(
            ":iduser" => $iduser
        ));

        $this->setData($results[0]);
    }

    public function update()
    {
        $sql = new Sql;

        $securePass = password_hash($this->getdespassword(), PASSWORD_DEFAULT, ["cost" => 10]);

        $results = $sql->select("CALL sp_usersupdate_save(:iduser, :desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
            ":iduser" => $this->getiduser(),
            ":desperson" => $this->getdesperson(),
            ":deslogin" => $this->getdeslogin(),
            ":despassword" => $securePass,
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

    public static function getForgot($email, $inadmin = true)
    {
        $sql = new Sql;

        $results = $sql->select("
            SELECT * FROM tb_persons a
            INNER JOIN tb_users b USING(idperson)
            WHERE a.desemail = :EMAIL;
        ", array(
            ":EMAIL" => $email
        ));

        if (!count($results)) {
            throw new \Exception("Não foi possível recuperar a senha");
        } else {
            $data = $results[0];
            $queryReturn = $sql->select("CALL sp_userspasswordsrecoveries_create(:iduser, :desip)", array(
                ":iduser" => $data["iduser"],
                ":desip" => $_SERVER["REMOTE_ADDR"]
            ));

            if (!count($queryReturn)) {
                throw new \Exception("Não foi possível recuperar a senha");
            } else {
                $dataRecovery = $queryReturn[0];

                define('SECRET', pack('a16', 'senha'));
                $code = base64_encode(openssl_encrypt($dataRecovery["idrecovery"], 'AES-128-CBC', SECRET, 0, SECRET));

                if ($inadmin == true) {
                    $link = "http://www.hcodecommerce.com.br/admin/forgot/reset?code=$code";
                } else {
                    $link = "http://www.hcodecommerce.com.br/forgot/reset?code=$code";
                }


                $mailer = new Mailer($data["desemail"], $data["desperson"], 'Recuperação de senha - HCode Store', 'forgot', array(
                    "name" => $data["desperson"],
                    "link" => $link
                ));

                $mailer->send();

                return $data;
            }
        }
    }

    public static function validForgotDecrypt($code)
    {
        define('SECRET', pack('a16', 'senha'));
        $idrecovery = base64_decode(
            openssl_decrypt($code, 'AES-128-CBC', SECRET, 0, SECRET)
        );

        $sql = new Sql;

        $result = $sql->select("
        SELECT * FROM tb_userspasswordsrecoveries a
        INNER JOIN tb_users b USING (iduser)
        INNER JOIN tb_persons c USING (idperson)
        WHERE
            a.idrecovery = :idrecovery
            AND
            a.dtrecovery IS NULL
            AND
            DATE_ADD(a.dtregister, INTERVAL 1 HOUR) >= NOW();
        ", array(":idrecovery" => $idrecovery));

        if (!count($result)) {
            throw new \Exception("Não foi possível recuperar a senha");
        } else {
            return $result[0];
        }
    }

    public static function setForgotUser($idrecovery)
    {
        $sql = new Sql;


        $sql->query("UPDATE tb_userspasswordsrecoveries SET dtrecovery = NOW() WHERE idrecovery = :idrecovery", array(":idrecovery" => $idrecovery));
    }

    public function setPassWord($pass)
    {
        $sql = new Sql;

        $sql->query("UPDATE tb_users SET despassword = :password WHERE iduser = :iduser", array(
            ":password" => $pass,
            ":iduser" => $this->getiduser()
        ));
    }

    public static function setError($msg)
    {
        $_SESSION[User::ERROR] = $msg;
    }

    public static function getError()
    {
        $msg = (isset($_SESSION[User::ERROR]) && $_SESSION[User::ERROR]) ? $_SESSION[User::ERROR] : '';

        User::clearError();

        return $msg;
    }

    public static function clearError()
    {
        $_SESSION[User::ERROR] = null;
    }

    public static function setErrorRegister($msg)
    {
        $_SESSION[User::ERROR_REGISTER] = $msg;
    }

    public static function getErrorRegister()
    {
        $msg = (isset($_SESSION[User::ERROR_REGISTER]) && $_SESSION[User::ERROR_REGISTER]) ? $_SESSION[User::ERROR_REGISTER] : '';

        User::clearErrorRegister();

        return $msg;
    }

    public static function clearErrorRegister()
    {
        $_SESSION[User::ERROR_REGISTER] = null;
    }

    public static function checkLoginExist($login)
    {
        $sql = new Sql;

        $result = $sql->select('SELECT * FROM tb_users WHERE deslogin = :deslogin', [
            'deslogin' => $login
        ]);

        return (count($result) > 0); //retorna true se já houver um login, false se não houver
    }


    public static function setMsgSuccess($msg)
    {
        $_SESSION[User::SUCCESS] = $msg;
    }

    public static function getMsgSuccess()
    {
        $msg = (isset($_SESSION[User::SUCCESS]) && $_SESSION[User::SUCCESS]) ? $_SESSION[User::SUCCESS] : '';

        User::clearMsgSuccess();

        return $msg;
    }

    public static function clearMsgSuccess()
    {
        $_SESSION[User::SUCCESS] = null;
    }

    public function getOrders()
    {
        $sql = new Sql;

        $result = $sql->select(
            "SELECT * 
        FROM tb_orders a 
        INNER JOIN tb_ordersstatus b USING(idstatus)
        INNER JOIN tb_carts c USING (idcart)
        INNER JOIN tb_users d ON d.iduser = a.iduser/*usado o on para vincular exatamente ao id da tabela a(tb_orders) */
        INNER JOIN tb_addresses e USING(idaddress)
        INNER JOIN tb_persons f ON f.idperson = d.idperson
        WHERE a.iduser = :iduser",
            [
                ':iduser' => $this->getiduser()
            ]
        );

        return $result;
    }

    public static function getPage($page = 1, $itemsPerPage = 10)
    {
        $start = ($page - 1) * $itemsPerPage;//inicial do limit

        $sql = new Sql;


        $result = $sql->select("
        SELECT SQL_CALC_FOUND_ROWS *
        FROM tb_users a INNER JOIN tb_persons b USING (idperson)LIMIT $start, $itemsPerPage;
        ");

        $resultTotal = $sql -> select('
        SELECT FOUND_ROWS() AS nrtotal;
        ');

        return [
            'data'=>$result,
            'total'=>(int)$resultTotal[0]['nrtotal'],
            'pages'=>ceil($resultTotal[0]['nrtotal'] / $itemsPerPage)//quantidade de paginas geradas, ceil arredonda numeros para cima
        ];
    }
    public static function getPageSearch($search, $page = 1, $itemsPerPage = 10)
    {
        $start = ($page - 1) * $itemsPerPage;//inicial do limit

        $sql = new Sql;


        $result = $sql->select("
        SELECT SQL_CALC_FOUND_ROWS *
        FROM tb_users a INNER JOIN tb_persons b USING (idperson) WHERE b.desperson LIKE :search OR b.desemail = :search OR a.deslogin LIKE :search 
        LIMIT $start, $itemsPerPage;
        ",[
            "search" => '%'.$search.'%'
        ]);

        $resultTotal = $sql -> select('
        SELECT FOUND_ROWS() AS nrtotal;
        ');

        return [
            'data'=>$result,
            'total'=>(int)$resultTotal[0]['nrtotal'],
            'pages'=>ceil($resultTotal[0]['nrtotal'] / $itemsPerPage)//quantidade de paginas geradas, ceil arredonda numeros para cima
        ];
    }
}
