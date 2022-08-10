<?php

class Access extends PDO
{
    private $conn;

    public function __construct()
    {
        $this->conn = new PDO("mysql: host=localhost; dbname=db_profile", "root", "");
    }

    private function setParam ($stmt, $key, $value)
    {
        $stmt->bindParam($key, $value);
    }

    private function setParams ($stmt, $parametros=array())
    {
        foreach ($parametros as $key => $value) 
        {
            $this->setParam($stmt, $key, $value);
        }
    }

    public function execQuery ($query, $params = array())
    {
        $stmt = $this-> conn -> prepare($query);

        $this->setParams($stmt, $params);

        $stmt->execute();

        return $stmt;
    }

    public function select ($query, $params=array()):array
    {
        $stmt = $this->execQuery($query, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}