<?php

namespace Cliente;

class Cadastro extends \Cadastro
{
    public function registrarVenda()
    {
        echo "venda registrada para cliente: ".$this->getNome();
    }
}