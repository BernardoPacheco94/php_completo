<?php

class sql extends PDO {
    
    private $conn;

    public function __construct()
    {
        $this->conn = new PDO("mysql:host=localhost; dbname=db_anotacoes", "root", "");
    }

    private function setParams ($stmt, $params = array())
    {
        foreach ($params as $key => $value) {
            $this->setParam($stmt, $key, $value);
        }
    }


    private function setParam ($stmt, $key, $value)
    {
        $stmt->bindParam($key, $value);
    }

    public function execQuery($query, $params = array())
    {
        $stmt = $this->conn->prepare($query);

        $this->setParams($stmt, $params);

        $stmt->execute();

        return $stmt;
    }

    public function select($query, $params)
    {
        $stmt = $this->execQuery($query, $params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}