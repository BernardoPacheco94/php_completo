<?php

use Documento as GlobalDocumento;

class Documento 
{
    private $numero;

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero ($n)
    {
        $this->numero = $n;
    }
}

class CPF extends Documento 
{
    public function validar():bool
    {
        $this->getNumero();
        return true;
    }
}


$doc = new CPF;
$doc->setNumero('99999999999');

var_dump($doc->validar());
echo "<br>";
var_dump($doc->getNumero());