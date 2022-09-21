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

    public function addProduct(Product $product)
    {
        $sql = new Sql;
        
        $sql->query('INSERT INTO tb_cartsproducts (idcart, idproduct) VALUES (:idcart, :idproduct)', [
            ':idcart'=>$this->getidcart(),
            ':idproduct'=>$product->getidproduct()
        ]);
    }
    
    public function removeProduct(Product $product, $all = false)
    {
        $sql = new Sql;

        if($all)
        {
            $sql->query('UPDATE tb_cartsproducts SET dtremoved = NOW() WHERE idcart = :idcart AND idproduct = :idproduct AND dtremoved IS NULL;',[
                ':idcart'=>$this->getidcart(),
                ':idproduct'=>$product->getidproduct()
            ]);
        }
        else{
            $sql->query('UPDATE tb_cartsproducts SET dtremoved = NOW() WHERE idcart = :idcart AND idproduct = :idproduct AND dtremoved IS NULL LIMIT 1;',[
                ':idcart'=>$this->getidcart(),
                ':idproduct'=>$product->getidproduct()
            ]);
        }
    }

    public function getProducts()//exibe os produtos que estão no carrinho
    {
        $sql = new Sql;

        $rows = $sql->select('SELECT b.idproduct, b.desproduct, b.vlprice, b.vlwidth, b.vlheight, b.vllength, b.vlweight, b.desurl, COUNT(*) AS nrqtd,
        SUM(b.vlprice) AS vltotal 
        FROM tb_cartsproducts a 
        INNER JOIN tb_products b ON a.idproduct = b.idproduct 
        WHERE a.idcart = :idcart AND a.dtremoved IS NULL 
        GROUP BY b.idproduct, b.desproduct, b.vlprice, b.vlwidth, b.vlheight, b.vllength, b.vlweight, b.desurl
        ORDER BY b.desproduct
        ',[
            ':idcart'=>$this->getidcart()
        ]);

        return Product::checkList($rows);
    }

    public function getProductsTotals()
    {
        $sql = new Sql;

        $results = $sql->select('SELECT SUM(vlprice) AS vlprice, SUM(vlwidth) AS vlwidth, SUM(vlheight) AS vlheight, SUM(vllength) AS vllength, SUM(vlweight) AS vlweight, COUNT(*) AS nrqtd
        FROM tb_products a
        INNER JOIN tb_cartsproducts b ON a.idproduct = b.idproduct
        WHERE b.idcart = :idcart AND dtremoved IS NULL;', [
            ':idcart'=>$this->getidcart()
        ]);

        // if(count($results) > 0)
        // {
        //     return $results[0];
        // }
        // else
        // {
        //     return [];
        // }

        return (count($results) > 0) ? $results[0] : [];
    }

    public function setFreight($nrzipcode)
    {
        $nrzipcode = str_replace('-','',$nrzipcode);
        $nrzipcode = str_replace('.','',$nrzipcode);

        $totals = $this->getProductsTotals();

        if($totals['nrqtd'] > 0) //calcula o frete
        {
            $qs = http_build_query([
                'nCdEmpresa'=>'',
                'sDsSenha'=>'',
                'nCdServico'=>'40010',
                'sCepOrigem'=>'81690-300',
                'sCepDestino'=>$nrzipcode,
                'nVlPeso'=>$totals['vlweight'],
                'nCdFormato'=> 1,
                'nVlComprimento'=>16,
                'nVlAltura'=>2,
                'nVlLargura'=>11,
                'nVlDiametro'=> 1,
                'sCdMaoPropria'=>'S',
                'nVlValorDeclarado'=> 50,
                'sCdAvisoRecebimento'=>'S'
            ]);//monta querys para requisições http (vai ser usado no xml_load_file)
            
            
            $xml = simplexml_load_file('http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrecoPrazo?'.$qs);

            echo json_encode($xml);
            exit;
        }
        else{

        }
    }
}
