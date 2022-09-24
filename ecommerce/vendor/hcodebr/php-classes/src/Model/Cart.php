<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;
use \Hcode\Model\User;
use sql as GlobalSql;

class Cart extends Model
{
    const SESSION = 'Cart';
    const SESSION_ERROR = 'CartError';

    public static function getFromSession() //cria ou retorna o carrinho a partir da sessao
    {
        $cart = new Cart;

        if (isset($_SESSION[Cart::SESSION]) && (int)$_SESSION[Cart::SESSION]['idcart'] > 0) {
            $cart->get((int)$_SESSION[Cart::SESSION]['idcart']);
        } else {
            $cart->getFromSessionID();

            if (!(int)$cart->getidcart() > 0) //cria o carrinho caso nao exista
            {
                $data = [
                    'dessessionid' => session_id()
                ];

                if (User::checkLogin(false)) {
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

    public function getFromSessionID() //pega a sessao a partir do id
    {
        $sql = new Sql;

        $result = $sql->select('SELECT * FROM tb_carts WHERE dessessionid = :dessessionid', [
            ':dessessionid' => session_id()
        ]);

        if (count($result) > 0) {
            $this->setData($result[0]);
        }
    }

    public function get($idcart)
    {
        $sql = new Sql;

        $result = $sql->select('SELECT * FROM tb_carts WHERE idcart = :idcart', [
            ':idcart' => $idcart
        ]);

        if (count($result) > 0) {
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
            ':idcart' => $this->getidcart(),
            ':idproduct' => $product->getidproduct()
        ]);

        $this->getCalculateTotal();
    }

    public function removeProduct(Product $product, $all = false)
    {
        $sql = new Sql;

        if ($all) {
            $sql->query('UPDATE tb_cartsproducts SET dtremoved = NOW() WHERE idcart = :idcart AND idproduct = :idproduct AND dtremoved IS NULL;', [
                ':idcart' => $this->getidcart(),
                ':idproduct' => $product->getidproduct()
            ]);
        } else {
            $sql->query('UPDATE tb_cartsproducts SET dtremoved = NOW() WHERE idcart = :idcart AND idproduct = :idproduct AND dtremoved IS NULL LIMIT 1;', [
                ':idcart' => $this->getidcart(),
                ':idproduct' => $product->getidproduct()
            ]);
        }
        
        $this->getCalculateTotal();
    }

    public function getProducts() //exibe os produtos que estão no carrinho
    {
        $sql = new Sql;

        $rows = $sql->select('SELECT b.idproduct, b.desproduct, b.vlprice, b.vlwidth, b.vlheight, b.vllength, b.vlweight, b.desurl, COUNT(*) AS nrqtd,
        SUM(b.vlprice) AS vltotal 
        FROM tb_cartsproducts a 
        INNER JOIN tb_products b ON a.idproduct = b.idproduct 
        WHERE a.idcart = :idcart AND a.dtremoved IS NULL 
        GROUP BY b.idproduct, b.desproduct, b.vlprice, b.vlwidth, b.vlheight, b.vllength, b.vlweight, b.desurl
        ORDER BY b.desproduct
        ', [
            ':idcart' => $this->getidcart()
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
            ':idcart' => $this->getidcart()
        ]);

        return (count($results) > 0) ? $results[0] : [];
    }

    public function setFreight($nrzipcode)
    {
        $nrzipcode = str_replace('-', '', $nrzipcode);
        $nrzipcode = str_replace('.', '', $nrzipcode);

        $totals = $this->getProductsTotals();



        if ($totals['nrqtd'] > 0) //calcula o frete
        {
            $sum = $totals['vllength'] + $totals['vlheight'] + $totals['vlwidth'];

            if ($sum < 25) {
                $totals['vllength'] = 16;
                $totals['vlheight'] = 2;
                $totals['vlwidth'] = 11;
            }
            if ($sum > 200) {
                $totals['vllength'] = 65;
                $totals['vlheight'] = 65;
                $totals['vlwidth'] = 65;
            }

            $qs = http_build_query([
                'nCdEmpresa' => '',
                'sDsSenha' => '',
                'nCdServico' => '41106',
                'sCepOrigem' => '88015902',
                'sCepDestino' => $nrzipcode,
                'nVlPeso' => $totals['vlweight'],
                'nCdFormato' => 1,
                'nVlComprimento' => $totals['vllength'],
                'nVlAltura' => $totals['vlheight'],
                'nVlLargura' => $totals['vlwidth'],
                'nVlDiametro' => 0,
                'sCdMaoPropria' => 'N',
                'nVlValorDeclarado' => $totals['vlprice'],
                'sCdAvisoRecebimento' => 'S'
            ]); //monta querys para requisições http (vai ser usado no xml_load_file)



            $xml = simplexml_load_file('http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrecoPrazo?' . $qs);

            $result = $xml->Servicos->cServico;
            
            
            if($result->MsgErro !== "")
            {
                Cart::setMsgError($result->MsgErro);
                
            } else
            {
                Cart::clearMsgError();
            }
            
            $this->setnrdays($result->PrazoEntrega);
            $this->setvlfreight(Cart::formatValueToDecimal($result->Valor));
            $this->setdeszipcode($nrzipcode);
            
            
            $this->save();

            return $result;

            
        } else {
            
        }


        
    }

    public static function formatValueToDecimal($value)
    {
        $value = str_replace('.','',$value);
        return str_replace(',','.', $value);
    }

    public static function setMsgError($msg)//sessao para passar a mensagem de erro no calculo do frete, caso exista
    {
        $_SESSION[Cart::SESSION_ERROR] = (string)$msg;        
    }

    public static function getMsgError()
    {
        $msg = (isset($_SESSION[Cart::SESSION_ERROR])) ? $_SESSION[Cart::SESSION_ERROR] : "";
       
        return $msg;
    }

    public static function clearMsgError()
    {
        $_SESSION[Cart::SESSION_ERROR] = NULL;
    }

    public function updateFreight()
    {
        if($this->getdeszipcode() != '')
        {
            $this->setFreight($this->getdeszipcode());
        }

    }

    public function checkProductsQty()
    {
        $product = $this->getProducts();

        if(!count($product)>0)
        {
            $this->setdeszipcode('');
            $this->setvlfreight(0);
            $this->setnrdays(0);

            Cart::setMsgError('Sem produtos no carrinho');
        }
    }

    public function getData()
    {
        $this->getCalculateTotal();

        return parent::getData();
    }

    public function getCalculateTotal()
    {
        $this->updateFreight();

        $totals = $this->getProductsTotals();

        $this->setvlsubtotal($totals['vlprice']);
        $this->setvltotal($totals['vlprice'] + $this->getvlfreight());
    }
}
