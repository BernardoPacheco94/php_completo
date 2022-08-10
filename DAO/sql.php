<?php

class sql extends PDO
{
    private $conn;

    public function __construct() //Construtor, para que eu passe o PDO ao instanciar a classe
    {
        $this->conn = new PDO("mysql:host=localhost; dbname=db_php8", 'root', '');
    }

    private function setParams($statement, $parameters = array())//método para atribuir os parametros na query
    {
        foreach ($parameters as $key => $value) { //executa um processo para cada parametro
            $this->setParam($statement, $key, $value); // atribui os parametros da consulta e as variáveis do código
        }
    }

    private function setParam($stmt, $key, $value)//atribui apenas um parametro
    {
        $stmt->bindParam($key, $value);
    }

    public function execQuery($rawQuery, $params = array()) //Execução de uma consulta generica, passando a consulta bruta e o array do que será consultado
    {
        $stmt = $this->conn->prepare($rawQuery); //usa uma variavel pra preparar a consulta
        $this->setParams($stmt, $params);

        $stmt->execute();
        return $stmt;
    }

    public function select($rawQuery, $params = array()):array
    {
        $stmt = $this->execQuery($rawQuery, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
