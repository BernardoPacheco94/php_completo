<?php

class Produto
{
    private $id;
    private $nome;
    private $tipo;
    private $ingredientes;
    private $valor;
    private $ativo;

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function getIngredientes()
    {
        return $this->ingredientes;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function getAtivo()
    {
        return $this->ativo;
    }


    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function setIngredientes($ingredientes)
    {
        $this->ingredientes = $ingredientes;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }

    //métodos crud
}
