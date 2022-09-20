<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;
use \Hcode\Model\User;
use sql as GlobalSql;

class Cart extends Model
{
    const SESSION = 'Cart';

    public static function getFromSession()//cria ou retorna o carrinho a partir da sessao
    {
        $cart = new Cart;

        if (isset($_SESSION[Cart::SESSION]) && (int)$_SESSION[Cart::SESSION]['idcart'] > 0) {
            $cart->get((int)$_SESSION[Cart::SESSION]['idcart']);
        } else {
            $cart->getFromSessionID();

            if(!(int)$cart->getidcart() > 0)//cria o carrinho caso nao exista
            {
                $data = [
                    'dessessionid'=>session_id()
                ];

                if(User::checkLogin(false))
                {
                    $user = User::getFromSession();

                    $data['iduser'] = $user->getiduser();
                }

                $cart->setData($data);

                $cart->save();

                $cart->setToSession();                
            }
        }

        return $cart;
    }

    public function setToSession()
    {
        $_SESSION[Cart::SESSION] = $this->getData();
    }

    public function getFromSessionID()//pega a sessao a partir do id
    {
        $sql = new Sql;

        $result = $sql->select('SELECT * FROM tb_carts WHERE dessessionid = :dessessionid', [
            ':dessessionid' => session_id()
        ]);

        if (count($result) > 0) 
        {
            $this->setData($result[0]);
        }
    }

    public function get($idcart)
    {
        $sql = new Sql;

        $result = $sql->select('SELECT * FROM tb_carts WHERE idcart = :idcart', [
            ':idcart' => $idcart
        ]);

        if (count($result) > 0) 
        {
            $this->setData($result[0]);
        }
    }

    public function save()
    {
        $sql = new Sql;

        $result = $sql->select('CALL sp_carts_save(:idcart, :dessessionid, :iduser, :deszipcode, :vlfreight, :nrdays)', [
            ":idcart" => $this->getidcart(),
            ":dessessionid" => $this->getdessessionid(),
            ":iduser" => $this->getiduser(),
            ":deszipcode" => $this->getdeszipcode(),
            ":vlfreight" => $this->getvlfreight(),
            ":nrdays" => $this->getnrdays()
        ]);

        $this->setData($result[0]);
    }
}
