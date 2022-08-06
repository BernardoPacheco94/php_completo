<?php

use Pessoa as GlobalPessoa;

class Pessoa {
    public $nome = "Bernardo";
    protected $idade = 27;
    private $senha = "12345";

    public function verDados ()
    {
        echo $this->nome."<br>";
        echo $this->idade."<br>";
        echo $this->senha."<br>";
    }

}

class Programador extends Pessoa
{
    public function verDados ()
    {
        echo get_class($this);//mostra de que classe está vindo o método usado
        echo "<br>";

        echo $this->nome."<br>";
        echo $this->idade."<br>";
        echo $this->senha."<br>";//aqui ele não acessa a senha pq é private da classe pessoa
    }
}

$obj = new Programador;

$obj->verDados();



