
<?php

class Comandas
{
    private $id;
    private $produtos;
    private $mesa;
    private $valorTotal;
    private $status;

    public function getId()
    {
        return $this->id;
    }

    public function getProdutos()
    {
        return $this->produtos;
    }

    public function getMesa()
    {
        return $this->mesa;
    }

    public function getValorTotal()
    {
        return $this->valorTotal;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setProdutos($produtos)
    {
        $this->produtos=$produtos;
    }

    public function setMesa($mesa)
    {
        $this->mesa=$mesa;
    }

    public function setValorTotal($valorTotal)
    {
        $this->valorTotal=$valorTotal;
    }
    public function setStatus($status)
    {
        $this->status=$status;
    }

    //métodos: novaComanda, incluirProduto, Encerrar
}
