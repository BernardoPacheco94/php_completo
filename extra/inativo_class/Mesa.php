<?php

//conecta com o banco

class Mesa
{
    private $id;
    private $comandas;
    private $status;

    public function getId()
    {
        return $this->id;
    }

    public function getComandas()//array
    {
        return $this->comandas;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setComandas($comandas)
    {
        $this->comandas = $comandas;
    }

    public function setStatus($status)
    {
        $this->status=$status;
    }

    //métodos para incluir comandas e altera status
}
