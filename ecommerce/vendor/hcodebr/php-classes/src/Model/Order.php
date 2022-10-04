<?php

namespace Hcode\Model;

use Hcode\DB\Sql;
use Hcode\Model;

class Order extends Model {
    const SUCCESS = 'OrderSuccess';
    const ERROR = 'OrderError';

    public function save()
    {
        $sql = new Sql;

        $result = $sql->select('CALL sp_orders_save (:idorder, :idcart, :iduser, :idstatus, :idaddress, :vltotal)',[
            'idorder' => $this->getidorder(),
            'idcart' => $this->getidcart(),
            'iduser' => $this->getiduser(),
            'idstatus' => $this->getidstatus(),
            'idaddress' => $this->getidaddress(),
            'vltotal' => $this->getvltotal(),
        ]);

        
        if(count($result) > 0)
        {
            $this->setData($result[0]);
        }
    }

    public function get($idorder)
    {
        $sql = new Sql;

        $result = $sql->select("SELECT * 
        FROM tb_orders a 
        INNER JOIN tb_ordersstatus b USING(idstatus)
        INNER JOIN tb_carts c USING (idcart)
        INNER JOIN tb_users d ON d.iduser = a.iduser/*usado o on para vincular exatamente ao id da tabela a(tb_orders) */
        INNER JOIN tb_addresses e USING(idaddress)
        INNER JOIN tb_persons f ON f.idperson = d.idperson
        WHERE a.idorder = :idorder",
        [
            ':idorder' => $idorder
        ]);


        if(count($result) > 0)
        {
            $this->setData($result[0]);
        }
    }

    public static function listAll()
    {
        $sql = new Sql;

        return $sql->select('SELECT * 
        FROM tb_orders a 
        INNER JOIN tb_ordersstatus b USING(idstatus)
        INNER JOIN tb_carts c USING (idcart)
        INNER JOIN tb_users d ON d.iduser = a.iduser/*usado o on para vincular exatamente ao id da tabela a(tb_orders) */
        INNER JOIN tb_addresses e USING(idaddress)
        INNER JOIN tb_persons f ON f.idperson = d.idperson
        ORDER BY a.dtregister DESC'
        );
    }

    public function delete()
    {
        $sql = new Sql;

        $sql->query('DELETE FROM tb_orders WHERE idorder = :idorder', [
            'idorder' => $this->getidorder()
        ]);
    }

    
    public static function setError($msg)
    {
        $_SESSION[Order::ERROR] = $msg;
    }

    public static function getError()
    {
        $msg = (isset($_SESSION[Order::ERROR]) && $_SESSION[Order::ERROR]) ? $_SESSION[Order::ERROR] : '';

        Order::clearError();

        return $msg;
    }

    public static function clearError()
    {
        $_SESSION[Order::ERROR] = null;
    }

    
    public static function setMsgSuccess($msg)
    {
        $_SESSION[Order::SUCCESS] = $msg;
    }

    public static function getMsgSuccess()
    {
        $msg = (isset($_SESSION[Order::SUCCESS]) && $_SESSION[Order::SUCCESS]) ? $_SESSION[Order::SUCCESS] : '';

        Order::clearMsgSuccess();

        return $msg;
    }

    public static function clearMsgSuccess()
    {
        $_SESSION[Order::SUCCESS] = null;
    }

}