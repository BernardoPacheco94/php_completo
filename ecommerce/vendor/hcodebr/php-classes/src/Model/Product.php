<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;
use sql as GlobalSql;

class Product extends Model
{
    
    public static function listAll()
    {
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_products ORDER BY desproduct");
    }

    public function save()
    {
        $sql = new Sql;

        $results = $sql->select("CALL sp_products_save (:idproduct, :desproduct, :vlprice, :vlwidth, :vlheight, :vllength, :vlweight, :desurl)", array(
            ":idproduct" => $this->getidproduct(),
            ":desproduct" => $this->getdesproduct(),
            ":vlprice" => $this->getvlprice(),
            ":vlwidth" => $this->getvlwidth(),
            ":vlheight" => $this->getvlheight(),
            ":vllength" => $this->getvllength(),
            ":vlweight" => $this->getvlweight(),
            ":desurl" => $this->getdesurl()
        ));

        $this->setData($results[0]);
    }

    public function get($idproduct)//faz o set do objeto passado no parametro
    {
        $sql = new Sql;

        $result = $sql->select("SELECT * FROM tb_products WHERE idproduct = :idproduct", array(
            ":idproduct" => $idproduct
        ));

        $this->setData($result[0]);
    }

    public function delete()
    {
        $sql = new Sql;

        $sql->query("DELETE FROM tb_products WHERE idproduct = :idproduct", array(
            ":idproduct" => $this->getidproduct()
        ));
    }


    public function checkPhoto()
    {
        if(file_exists($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'res'.DIRECTORY_SEPARATOR.'site'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'products'.DIRECTORY_SEPARATOR.$this->getidproduct()."jpg"))
        {
            $url = '/res/site/img/products/'.$this->getidproduct().'jpg';
        }
        else
        {
            $url = '/res/site/img/products/product.jpg';
        }

        $this->setdesphoto($url);
    }

    public function getData()
    {
        $this->checkPhoto();

        $values = parent::getData();

        return $values;
    }

}
