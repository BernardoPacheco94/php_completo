<?php

class Ingredientes

{
    private $id;
    private $nome;
    private $valorAdicional;
    private $ativo;


    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getValorAdicional()
    {
        return $this->valorAdicional;
    }

    public function getAtivo()
    {
        return $this->ativo;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setValorAdicional($valorAdicional)
    {
        $this->valorAdicional=$valorAdicional;
    }

    public function setAtivo($ativo)
    {
        $this->ativo=$ativo;
    }

    //Métodos crud
}

