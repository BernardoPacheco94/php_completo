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

    public static function checkList($list)
    {
        foreach ($list as &$row) { // o & serve para que a propria variavel row seja modificada
            $p = new Product();
            $p->setData($row);
            $row = $p->getData(); //aqui vai fazer os getters todos e pegar a foto do servidor, em cara row (&)
        }

        return $list; //retorna toda a lista com getdata em todos os elementos
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

    public function get($idproduct) //faz o set do objeto passado no parametro
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
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'res' . DIRECTORY_SEPARATOR . 'site' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . $this->getidproduct() . ".jpg")) {
            $url = '/res/site/img/products/' . $this->getidproduct() . '.jpg';
        } else {
            $url = '/res/site/img/products/product.jpg';
        }

        $this->setdesphoto($url);
    }

    public function setPhoto($file)
    {

        $extension = explode('.', $file['name']);
        $extension = end($extension);

        switch ($extension) {

            case "jpg":
            case "jpeg":
                $image = imagecreatefromjpeg($file['tmp_name']);
                break;

            case "gif":
                $image = imagecreatefromgif($file['tmp_name']);
                break;

            case "png":
                break;

            case "webp":
                $image = imagecreatefromwebp($file['tmp_name']);
                break;

            case "bmp":
                $image = imagecreatefrombmp($file['tmp_name']);
                break;
        }

        $path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'res' . DIRECTORY_SEPARATOR . 'site' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . $this->getidproduct() . ".jpg";
        imagejpeg($image, $path);
        imagedestroy($image);

        $this->checkPhoto();
    }

    public function getData()
    {
        $this->checkPhoto();

        $values = parent::getData();

        return $values;
    }

    public function getFromURL($desurl)
    {
        $sql = new Sql;

        $row = $sql->select('SELECT * FROM tb_products WHERE desurl = :desurl; LIMIT 1', [
            ':desurl'=> $desurl
        ]);

        $this->setData($row[0]);
    }

    public function getCategories()
    {
        $sql = new Sql;

        return $sql->select('
        SELECT * FROM tb_categories a
        INNER JOIN tb_productscategories b
        ON a.idcategory = b.idcategory WHERE b.idproduct = :idproduct
        ',[
            ":idproduct"=>$this->getidproduct()
        ]);
    }
}
