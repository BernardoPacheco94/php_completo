<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;
use sql as GlobalSql;

class Category extends Model
{
    
    public static function listAll()
    {
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_categories ORDER BY descategory");
    }

    public function save()
    {
        $sql = new Sql;

        $results = $sql->select("CALL sp_categories_save (:idcategory, :descategory)", array(
            "idcategory" => $this->getidcategory(),
            "descategory" => $this->getdescategory()
        ));

        $this->setData($results[0]);

        Category::updateFile();
    }

    public function get($idcategory)//faz o set do objeto passado no parametro
    {
        $sql = new Sql;

        $result = $sql->select("SELECT * FROM tb_categories WHERE idcategory = :idcategory", array(
            ":idcategory" => $idcategory
        ));

        $this->setData($result[0]);
    }

    public function delete()
    {
        $sql = new Sql;

        $sql->query("DELETE FROM tb_categories WHERE idcategory = :idcategory", array(
            ":idcategory" => $this->getidcategory()
        ));      
        
        Category::updateFile();
    }

    public static function updateFile()//esse método separa as categorias do arquivo footer
    {
        $categories = Category::listAll();

        $html = [];

        foreach ($categories as $row) {
            array_push($html, '<li><a href="/categories/'.$row['idcategory'].'">'.$row['descategory'].'</a></li>
            ');
        }

        file_put_contents($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'categories-menu.html', implode('', $html));//salvando o arquivo
    }

    public function getCategoryProducts($related = true)
    {
        $sql = new Sql;

        if($related)
        {
            return $sql->select("
            SELECT * FROM tb_products WHERE idproduct IN (
                SELECT a.idproduct
                FROM tb_products a
                INNER JOIN tb_productscategories b ON a.idproduct = b.idproduct
                WHERE b.idcategory = :idcategory
                );
            ", [
                ':idcategory'=>$this->getidcategory()
            ]);
        }
        else
        {
            return $sql->select("
            SELECT * FROM tb_products WHERE idproduct NOT IN (
                SELECT a.idproduct
                FROM tb_products a
                INNER JOIN tb_productscategories b ON a.idproduct = b.idproduct
                WHERE b.idcategory = :idcategory
                );
            ", [
                ':idcategory'=>$this->getidcategory()
            ]);

        }
    }

    public function addProduct(Product $product)
    {
        $sql = new Sql;

        $sql->query('INSERT INTO tb_productscategories (idcategory, idproduct) VALUES (:idcategory, :idproduct)', [
            ':idcategory' => $this->getidcategory(),
            ':idproduct' => $product->getidproduct()
        ]);
    }

    public function removeProduct(Product $product)
    {
        $sql = new Sql;

        $sql->query('DELETE FROM tb_productscategories WHERE idcategory = :idcategory AND idproduct = :idproduct', [
            ':idcategory' => $this->getidcategory(),
            ':idproduct' => $product->getidproduct()
        ]);
    }

    public function getProductsPage($page = 1, $itemsPerPage = 3)
    {
        $start = ($page - 1) * $itemsPerPage;//inicial do limit

        $sql = new Sql;


        $result = $sql->select("
        SELECT SQL_CALC_FOUND_ROWS *
        FROM tb_products a
        INNER JOIN tb_productscategories b ON a.idproduct = b.idproduct
        INNER JOIN tb_categories c ON c.idcategory = b.idcategory
        WHERE c.idcategory = :idcategory
        LIMIT $start, $itemsPerPage;
        ", [
             ":idcategory"=>$this->getidcategory()
        ]);

        $resultTotal = $sql -> select('
        SELECT FOUND_ROWS() AS nrtotal;
        ');

        return [
            'data'=>Product::checkList($result),
            'total'=>(int)$resultTotal[0]['nrtotal'],
            'pages'=>ceil($resultTotal[0]['nrtotal'] / $itemsPerPage)//quantidade de paginas geradas, ceil arredonda numeros para cima
        ];
    }

}
