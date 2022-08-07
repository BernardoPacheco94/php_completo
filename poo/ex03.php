<?php

class Endereco {

    private $logradouro;
    private $numero;
    private $cidade;


    public function __construct($a, $b, $c)
    {
        $this->logradouro = $a;
        $this->numero = $b;
        $this->cidade = $c;
    }

    public function __destruct()//remove da memoria
    {
        var_dump("DESTRUIR");        
    }

    public function __toString()//converte o obj p string
    {
        return $this->logradouro.", ".$this->numero.", ".$this->cidade; 
    }
    
}


$meuEndereco = new Endereco('Silva Jardim', '2410', 'Santa Maria');//Passa os construtores via parametro na instancia
echo var_dump($meuEndereco);
echo "<hr>";
echo $meuEndereco;//exibe o objeto em string pq foi setado para fazer isso no toString

unset($meuEndereco);

