<?php

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

$pessoa = new Pessoa;


echo $pessoa->nome;
echo "<br>";
echo $pessoa->idade;//nao pode acessar a variavel pq é protegida, funções dentro da classe conseguem
echo "<br>";
echo $pessoa->senha;//nem mesmo os herdeiros (extends) acessam essa variável

echo "<hr>";
$pessoa->verDados();//essa  função está dentro da classe e publica, por isso os dados aparecem
