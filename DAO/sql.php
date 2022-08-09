<?php

class sql extends PDO
{
    private $conn;

    public function __construct()//Construtor, para que eu passe o PDO ao instanciar a classe
    {
        $this->conn = new PDO ("mysql:host=localhost; dbname=db_php8",'root','');
    }

    private function setParams()
    {
        
    }

    public function execQuery($rawQuery, $params = array())//Execução de uma consulta generica, passando a consulta e o array do que será consultado
    {
        $stmt = $this->conn->prepare($rawQuery);//usa uma variavel pra preparar a consulta
        
        foreach($params as $key => $value){//executa um processo para cada parametro
            $stmt->bindParam($key, $value);// atribui os parametros da consulta e as variáveis do código
        }
    }
}