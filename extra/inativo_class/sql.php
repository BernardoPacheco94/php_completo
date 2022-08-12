<?php

require_once "autoload.php";

class sql extends PDO
{
    private $conn;

    public function __construct()
    {
        $this->conn = new PDO("mysql:host=localhost; dbname=db_inativo", 'root','');
    }

    private function loadParams($stmt, $params=array())//chamado se forem varios parametros para a consulta sql
    {
        foreach ($params as $key => $value) 
        {
            $this->loadParam($stmt, $key, $value);
        }
    }

    private function loadParam($stmt, $key, $value)//chamado se for apenas um parametro para a consulta sql
    {
        $stmt->bindParam($key, $value);
    }


    public function execQuery($rawQuery, $parameters=array())//método para executar qualquer query, sem retornar infos
    {
        $statement = $this->conn->prepare($rawQuery);

        $this->loadParams($statement, $parameters);

        $statement->execute();

        return $statement;
    }

    public function select($query, $params= array()):array//método que retorna infos de um select
    {
        $stmt = $this->execQuery($query, $params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}